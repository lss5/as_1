<?php

namespace App\Http\Controllers;

use App\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function index()
    {
        return view('admin.company.index', [
            'companies' => Company::all(),
        ]);
    }

    public function show(Company $company)
    {
        //
    }

    public function edit(Company $company)
    {
        //
    }

    public function update(Request $request, Company $company)
    {
        //
    }

    public function destroy(Company $company)
    {
        $company->delete();
    }
}
