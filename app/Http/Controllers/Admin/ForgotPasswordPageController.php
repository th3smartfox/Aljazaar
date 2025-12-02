<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ForgotPasswordPage;
use Illuminate\Http\Request;

class ForgotPasswordPageController extends Controller
{

    public function index()
    {
        $forgotPasswordPages = ForgotPasswordPage::latest()->get();
        return view('dynamic_content.forgot_password_page.index', compact('forgotPasswordPages'));
    }

    public function create()
    {
        return view('dynamic_content.forgot_password_page.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'sub_title' => 'required|string|max:255',
            'email_or_phone_label' => 'required|string|max:255',
            'email_or_phone_hint' => 'required|string|max:255',
            'continue_button_text' => 'required|string|max:255',
            'status' => 'required|boolean',
        ]);

        ForgotPasswordPage::create($request->all());

        return redirect()->route('forgot-password-pages.index')
            ->with('success', 'Forgot Password Page content created successfully.');
    }

    public function show(ForgotPasswordPage $forgotPasswordPage)
    {
        return redirect()->route('forgot-password-pages.edit', $forgotPasswordPage);
    }

    public function edit(ForgotPasswordPage $forgotPasswordPage)
    {
        return view('dynamic_content.forgot_password_page.edit', compact('forgotPasswordPage'));
    }

    public function update(Request $request, ForgotPasswordPage $forgotPasswordPage)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'sub_title' => 'required|string|max:255',
            'email_or_phone_label' => 'required|string|max:255',
            'email_or_phone_hint' => 'required|string|max:255',
            'continue_button_text' => 'required|string|max:255',
            'status' => 'required|boolean',
        ]);

        $forgotPasswordPage->update($request->all());

        return redirect()->route('forgot-password-pages.index')
            ->with('success', 'Forgot Password Page content updated successfully.');
    }

    public function destroy(ForgotPasswordPage $forgotPasswordPage)
    {
        $forgotPasswordPage->delete();
        return redirect()->route('forgot-password-pages.index')
            ->with('success', 'Forgot Password Page content deleted successfully.');
    }
}
