<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SigninPage;
use Illuminate\Http\Request;

class SigninPageController extends Controller
{

    public function index()
    {
        $signinPages = SigninPage::latest()->get();
        return view('dynamic_content.signin_page.index', compact('signinPages'));
    }

    public function create()
    {
        return view('dynamic_content.signin_page.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'sub_title' => 'required|string|max:255',
            'email_or_phone_label' => 'required|string|max:255',
            'email_or_phone_hint' => 'required|string|max:255',
            'password_label' => 'required|string|max:255',
            'password_hint' => 'required|string|max:255',
            'forgot_password_text' => 'required|string|max:255',
            'login_button_text' => 'required|string|max:255',
            'dont_have_account_text' => 'required|string|max:255',
            'sign_up_text' => 'required|string|max:255',
            'status' => 'required|boolean',
        ]);

        SigninPage::create($request->all());

        return redirect()->route('signin-pages.index')
            ->with('success', 'Signin Page content created successfully.');
    }

    public function show(SigninPage $signinPage)
    {
        return redirect()->route('signin-pages.edit', $signinPage);
    }

    public function edit(SigninPage $signinPage)
    {
        return view('dynamic_content.signin_page.edit', compact('signinPage'));
    }

    public function update(Request $request, SigninPage $signinPage)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'sub_title' => 'required|string|max:255',
            'email_or_phone_label' => 'required|string|max:255',
            'email_or_phone_hint' => 'required|string|max:255',
            'password_label' => 'required|string|max:255',
            'password_hint' => 'required|string|max:255',
            'forgot_password_text' => 'required|string|max:255',
            'login_button_text' => 'required|string|max:255',
            'dont_have_account_text' => 'required|string|max:255',
            'sign_up_text' => 'required|string|max:255',
            'status' => 'required|boolean',
        ]);

        $signinPage->update($request->all());

        return redirect()->route('signin-pages.index')
            ->with('success', 'Signin Page content updated successfully.');
    }

    public function destroy(SigninPage $signinPage)
    {
        $signinPage->delete();
        return redirect()->route('signin-pages.index')
            ->with('success', 'Signin Page content deleted successfully.');
    }
}
