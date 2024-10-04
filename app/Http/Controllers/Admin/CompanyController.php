<?php

namespace App\Http\Controllers\Admin;

use App\Company;
use App\Country;
use App\Http\Controllers\Controller;
use App\Status;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function index()
    {
        return view('admin.company.index', [
            'companies' => Company::all(),
        ]);
    }

    public function edit(Company $company)
    {
        return view('admin.company.edit', [
            'company' => $company,
            'countries' => Country::all(),
            'statuses' => Status::all(),
        ]);
    }

    public function update(Request $request, Company $company)
    {
        $validated = $request->validate([
            'status' => ['required', 'integer', 'exists:statuses,id'],
        ]);

        if ($company->status->id !== $validated['status']) {
            $company->update([
                'status_id' => $validated['status'],
            ]);
        }

        return redirect()->route('admin.companies.index')->with('success', 'Status company changed');
    }

    public function destroy(Company $company)
    {
        $company->delete();

        return redirect()->route('admin.companies.index')->with('success', 'Company deleted');
    }
}
