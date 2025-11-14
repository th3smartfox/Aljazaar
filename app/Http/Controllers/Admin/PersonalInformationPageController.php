<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PersonalInformationPage;
use Illuminate\Http\Request;

class PersonalInformationPageController extends Controller
{

    public function index()
    {
        $personalPages = PersonalInformationPage::latest()->get();
        return view('dynamic_content.personal_information_page.index', compact('personalPages'));
    }

    public function create()
    {
        return view('dynamic_content.personal_information_page.create');
    }

    public function store(Request $request)
    {
        $request->validate($this->getValidationRules());
        PersonalInformationPage::create($request->all());
        return redirect()->route('personal-information-pages.index')
                         ->with('success', 'Personal Information Page content created successfully.');
    }

    public function show(PersonalInformationPage $personalInformationPage)
    {
        return redirect()->route('personal-information-pages.edit', $personalInformationPage);
    }

    public function edit(PersonalInformationPage $personalInformationPage)
    {
        return view('dynamic_content.personal_information_page.edit', compact('personalInformationPage'));
    }

    public function update(Request $request, PersonalInformationPage $personalInformationPage)
    {
        $request->validate($this->getValidationRules());
        $personalInformationPage->update($request->all());
        return redirect()->route('personal-information-pages.index')
                         ->with('success', 'Personal Information Page content updated successfully.');
    }

    public function destroy(PersonalInformationPage $personalInformationPage)
    {
        $personalInformationPage->delete();
        return redirect()->route('personal-information-pages.index')
                         ->with('success', 'Personal Information Page content deleted successfully.');
    }

    private function getValidationRules()
    {
        return [
            'title' => 'required|string|max:100',
            'label_name' => 'required|string|max:100',
            'label_email' => 'required|string|max:100',
            'label_phone' => 'required|string|max:100',
            'button_cancel' => 'required|string|max:50',
            'button_save' => 'required|string|max:50',
            'status' => 'required|boolean',
        ];
    }
}