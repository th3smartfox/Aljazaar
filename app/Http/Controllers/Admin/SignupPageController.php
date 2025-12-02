<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SignupPage;
use Illuminate\Http\Request;

class SignupPageController extends Controller
{

    public function index()
    {
        $signupPages = SignupPage::latest()->get();
        return view('dynamic_content.signup_page.index', compact('signupPages'));
    }

    public function create()
    {
        return view('dynamic_content.signup_page.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'sub_title' => 'required|string|max:255',
            'full_name_label' => 'required|string|max:255',
            'full_name_hint' => 'nullable|string|max:255',
            'phone_number_label' => 'required|string|max:255',
            'phone_number_hint' => 'nullable|string|max:255',
            'password_label' => 'required|string|max:255',
            'password_hint' => 'nullable|string|max:255',
            'sign_up_button_text' => 'required|string|max:255',
            'already_have_account_text' => 'required|string|max:255',
            'login_button_text' => 'required|string|max:255',
            'status' => 'required|boolean',
        ]);

        SignupPage::create($request->all());

        return redirect()->route('signup-pages.index')
            ->with('success', 'Signup Page content created successfully.');
    }

    public function show(SignupPage $signupPage)
    {
        return redirect()->route('signup-pages.edit', $signupPage);
    }

    public function edit(SignupPage $signupPage)
    {
        return view('dynamic_content.signup_page.edit', compact('signupPage'));
    }

    public function update(Request $request, SignupPage $signupPage)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'sub_title' => 'required|string|max:255',
            'full_name_label' => 'required|string|max:255',
            'full_name_hint' => 'nullable|string|max:255',
            'phone_number_label' => 'required|string|max:255',
            'phone_number_hint' => 'nullable|string|max:255',
            'password_label' => 'required|string|max:255',
            'password_hint' => 'nullable|string|max:255',
            'sign_up_button_text' => 'required|string|max:255',
            'already_have_account_text' => 'required|string|max:255',
            'login_button_text' => 'required|string|max:255',
            'status' => 'required|boolean',
        ]);

        $signupPage->update($request->all());

        return redirect()->route('signup-pages.index')
            ->with('success', 'Signup Page content updated successfully.');
    }

    public function destroy(SignupPage $signupPage)
    {
        $signupPage->delete();
        return redirect()->route('signup-pages.index')
            ->with('success', 'Signup Page content deleted successfully.');
    }
}
