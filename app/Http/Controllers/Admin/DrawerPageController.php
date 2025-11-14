<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DrawerPage;
use Illuminate\Http\Request;

class DrawerPageController extends Controller
{

    public function index()
    {
        $drawerPages = DrawerPage::latest()->get();
        return view('dynamic_content.drawer_page.index', compact('drawerPages'));
    }

    public function create()
    {
        return view('dynamic_content.drawer_page.create');
    }

    public function store(Request $request)
    {
        $request->validate($this->getValidationRules());
        
        $data = [
            'title' => $request->title,
            'status' => $request->status == 1,
        ];

        // Process button data
        $buttons = [
            'button_my_account',
            'button_account_tier',
            'button_wallet',
            'button_change_information',
            'button_order_reordering',
            'button_order_tracking',
            'button_active_orders',
            'button_closed_orders',
            'button_redeem_rewards',
            'button_messages',
        ];

        foreach ($buttons as $button) {
            if ($request->has($button . '_title')) {
                // Get checkbox value - if not present, it means unchecked (false)
                $isSubtitle = $request->has($button . '_is_subtitle') && $request->input($button . '_is_subtitle') == '1';
                
                $data[$button] = [
                    'title' => $request->input($button . '_title'),
                    'is_subtitle' => $isSubtitle,
                    'icon' => $request->input($button . '_icon', 'FontAwesomeIcons.solidUser'),
                ];
            }
        }

        DrawerPage::create($data);
        return redirect()->route('drawer-pages.index')
                         ->with('success', 'Drawer Page content created successfully.');
    }

    public function show(DrawerPage $drawerPage)
    {
        return redirect()->route('drawer-pages.edit', $drawerPage);
    }

    public function edit(DrawerPage $drawerPage)
    {
        return view('dynamic_content.drawer_page.edit', compact('drawerPage'));
    }

    public function update(Request $request, DrawerPage $drawerPage)
    {
        
        $request->validate($this->getValidationRules());
        
        $data = [
            'title' => $request->title,
            'status' => $request->status == 1,
        ];

        // Process button data
        $buttons = [
            'button_my_account',
            'button_account_tier',
            'button_wallet',
            'button_change_information',
            'button_order_reordering',
            'button_order_tracking',
            'button_active_orders',
            'button_closed_orders',
            'button_redeem_rewards',
            'button_messages',
        ];

        foreach ($buttons as $button) {
            $titleKey = $button . '_title';
            $iconKey = $button . '_icon';
            $subtitleKey = $button . '_is_subtitle';
            
            
            // Get existing button data
            $existingButton = $drawerPage->{$button} ?? null;
            $existingTitle = null;
            $existingIcon = null;
            $existingIsSubtitle = false;
            
            if (is_array($existingButton)) {
                $existingTitle = $existingButton['title'] ?? null;
                $existingIcon = $existingButton['icon'] ?? null;
                $existingIsSubtitle = $existingButton['is_subtitle'] ?? false;
            } elseif (is_string($existingButton)) {
                // Handle old string format
                $existingTitle = $existingButton;
            }
            
            // Get values from request, fallback to existing
            $title = $request->input($titleKey, $existingTitle);
            $icon = $request->input($iconKey, $existingIcon);
            $isSubtitle = $request->has($subtitleKey) 
                ? ($request->input($subtitleKey) == '1') 
                : $existingIsSubtitle;
            
            // If icon is still empty, use default
            if (empty($icon)) {
                $defaultIcons = [
                    'button_my_account' => 'FontAwesomeIcons.solidUser',
                    'button_account_tier' => 'FontAwesomeIcons.userShield',
                    'button_wallet' => 'FontAwesomeIcons.wallet',
                    'button_change_information' => 'FontAwesomeIcons.penToSquare',
                    'button_order_reordering' => 'FontAwesomeIcons.cartShopping',
                    'button_redeem_rewards' => 'FontAwesomeIcons.gift',
                    'button_messages' => 'FontAwesomeIcons.solidMessage',
                ];
                $icon = $defaultIcons[$button] ?? 'FontAwesomeIcons.solidUser';
            }
            
            // If title is still empty, use button name as fallback
            if (empty($title)) {
                $title = ucwords(str_replace('_', ' ', str_replace('button_', '', $button)));
            }
            
            $data[$button] = [
                'title' => trim($title),
                'is_subtitle' => (bool) $isSubtitle,
                'icon' => trim($icon),
            ];
            
        }

        
        try {
            $result = $drawerPage->update($data);
            
            // Reload to verify
            $drawerPage->refresh();
            
            // Verify the update
            $updated = DrawerPage::find($drawerPage->id);
            
        } catch (\Exception $e) {
            return redirect()->back()
                             ->withInput()
                             ->with('error', 'Failed to update: ' . $e->getMessage());
        }
        
        
        return redirect()->route('drawer-pages.index')
                         ->with('success', 'Drawer Page content updated successfully.');
    }

    public function destroy(DrawerPage $drawerPage)
    {
        $drawerPage->delete();
        return redirect()->route('drawer-pages.index')
                         ->with('success', 'Drawer Page content deleted successfully.');
    }

    private function getValidationRules()
    {
        $rules = [
            'title' => 'required|string|max:100',
            'status' => 'required|boolean',
        ];

        $buttons = [
            'button_my_account',
            'button_account_tier',
            'button_wallet',
            'button_change_information',
            'button_order_reordering',
            'button_order_tracking',
            'button_active_orders',
            'button_closed_orders',
            'button_redeem_rewards',
            'button_messages',
        ];

        foreach ($buttons as $button) {
            $rules[$button . '_title'] = 'required|string|max:100';
            $rules[$button . '_is_subtitle'] = 'nullable|boolean';
            $rules[$button . '_icon'] = 'required|string|max:255';
        }

        return $rules;
    }
}