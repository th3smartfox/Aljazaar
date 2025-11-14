<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ChangeInformationPage;
use Illuminate\Http\Request;

class ChangeInformationPageController extends Controller
{
    // Authorization 'role:Admin' middleware ke zariye routes/web.php mein hai

    public function index()
    {
        $changeInformationPages = ChangeInformationPage::latest()->get();
        return view('dynamic_content.change_information_page.index', compact('changeInformationPages'));
    }

    public function create()
    {
        return view('dynamic_content.change_information_page.create');
    }

    public function store(Request $request)
    {
        $request->validate($this->getValidationRules());
        ChangeInformationPage::create($request->all());
        return redirect()->route('change-information-pages.index')
                         ->with('success', 'Change Information Page content created successfully.');
    }

    public function show(ChangeInformationPage $changeInformationPage)
    {
        return redirect()->route('change-information-pages.edit', $changeInformationPage);
    }

    public function edit(ChangeInformationPage $changeInformationPage)
    {
        return view('dynamic_content.change_information_page.edit', compact('changeInformationPage'));
    }

    public function update(Request $request, ChangeInformationPage $changeInformationPage)
    {
        $request->validate($this->getValidationRules());
        $changeInformationPage->update($request->all());
        return redirect()->route('change-information-pages.index')
                         ->with('success', 'Change Information Page content updated successfully.');
    }

    public function destroy(ChangeInformationPage $changeInformationPage)
    {
        $changeInformationPage->delete();
        return redirect()->route('change-information-pages.index')
                         ->with('success', 'Change Information Page content deleted successfully.');
    }

    // Helper function for validation rules
    private function getValidationRules()
    {
        return [
            'title' => 'required|string|max:100',
            'label_account' => 'required|string|max:100',
            'label_personal_information' => 'required|string|max:100',
            'label_payment_method' => 'required|string|max:100',
            'label_card_information' => 'required|string|max:100',
            'status' => 'required|boolean',
        ];
    }
}