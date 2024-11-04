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
}
