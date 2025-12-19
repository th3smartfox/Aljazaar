<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\Address\AddressResource;

class AddressController extends Controller
{
    /**
     * API 1: Get all addresses for the logged-in user
     */
    public function index()
    {
        $addresses = Auth::user()->addresses()->with(['user', 'city'])->latest()->get();

        return response()->json([
            'addresses' => AddressResource::collection($addresses)
        ], 200);
    }

    /**
     * API 2: Store a new address
     */
    /**
     * API 2: Store a new address
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'address_title' => 'required|string|max:100',
            'address' => 'required|string|max:255',
            'street_number' => 'nullable|string|max:100',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'landmark' => 'nullable|string|max:255',
            'nearest_landmark' => 'nullable|string|max:255',
            'city_id' => 'required|exists:cities,id',
            'is_default' => 'required|boolean',
        ]);

        $userId = Auth::id();

        // Check if this is the first address
        if (Address::where('user_id', $userId)->count() === 0) {
            $validated['is_default'] = true;
        }

        if ($validated['is_default']) {
            Address::where('user_id', $userId)->update(['is_default' => false]);
        }

        // Map 'address' to 'address_line'
        $data = $validated;
        $data['address_line'] = $validated['address'];
        unset($data['address']);

        $address = Address::create($data + ['user_id' => $userId]);

        $address->load('user', 'city');

        return response()->json([
            'message' => 'Address added successfully.',
            'address' => new AddressResource($address)
        ], 201);
    }

    /**
     * API 3: Update an existing address
     */
    public function update(Request $request, Address $address)
    {
        if ($address->user_id !== Auth::id()) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'address_title' => 'required|string|max:100',
            'address' => 'required|string|max:255',
            'street_number' => 'nullable|string|max:100',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'landmark' => 'nullable|string|max:255',
            'nearest_landmark' => 'nullable|string|max:255',
            'city_id' => 'required|exists:cities,id',
            'is_default' => 'required|boolean',
        ]);

        if ($validated['is_default']) {
            Address::where('user_id', Auth::id())
                ->where('id', '!=', $address->id)
                ->update(['is_default' => false]);
        }

        // Map 'address' to 'address_line'
        $data = $validated;
        $data['address_line'] = $validated['address'];
        unset($data['address']);

        $address->update($data);

        $address->load('user', 'city');

        return response()->json([
            'message' => 'Address updated successfully.',
            'address' => new AddressResource($address)
        ], 200);
    }

    /**
     * API 4: Delete an address
     */
    public function destroy(Address $address)
    {
        if ($address->user_id !== Auth::id()) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $userId = Auth::id();
        $addressCount = Address::where('user_id', $userId)->count();

        // Prevent deletion if it's the only address
        if ($addressCount <= 1) {
            return response()->json(['message' => 'Cannot delete the only address.'], 400);
        }

        if ($address->is_default) {
            // Find the address created immediately after the current one
            $newDefault = Address::where('user_id', $userId)
                ->where('id', '!=', $address->id)
                ->where('created_at', '>=', $address->created_at)
                ->orderBy('created_at', 'asc')
                ->first();

            // If no newer address, fallback to the latest one (previous)
            if (!$newDefault) {
                $newDefault = Address::where('user_id', $userId)
                    ->where('id', '!=', $address->id)
                    ->latest()
                    ->first();
            }

            if ($newDefault) {
                $newDefault->update(['is_default' => true]);
            }
        }

        $address->delete();

        return response()->json(['message' => 'Address deleted successfully.'], 200);
    }

    /**
     * API 5: Set a specific address as default
     */
    public function setDefault(Address $address)
    {
        if ($address->user_id !== Auth::id()) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        Address::where('user_id', Auth::id())->update(['is_default' => false]);
        $address->update(['is_default' => true]);

        $addresses = Auth::user()->addresses()->with(['user', 'city'])->latest()->get();

        return response()->json([
            'message' => 'Default address updated successfully.',
            'addresses' => AddressResource::collection($addresses)
        ], 200);
    }
}