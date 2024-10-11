<?php

namespace App\Http\Controllers\Profile;

use App\Company;
use App\Country;
use App\Http\Controllers\Controller;
use App\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image as ImageFacade;

class CompanyController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Company::class, 'company');
    }

    public function create()
    {
        return view('profile.company.create', [
            'countries' => Country::all(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'image_logo' => ['required', 'file', 'image', 'max:2048', 'dimensions:min_width=256,min_height=256'],
            'image_header' => ['required', 'file', 'image', 'max:4096', 'dimensions:min_width=1024,min_height=256'],
            'name' => ['required', 'string', 'max:255'],
            'legal_address' => ['required', 'string', 'max:255'],
            'actual_address' => ['required', 'string', 'max:255'],
            'country' => ['required', 'integer', 'exists:countries,id'],
            'description' => ['nullable', 'string', 'max:59392'],
        ]);

        $company = Company::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'description' => $request->description,
            'legal_address' => $request->legal_address,
            'actual_address' => $request->actual_address,
            'status_id' => Status::moderation()->first()->id,
            'country_id' => $request->country,
        ]);

        $image_logo = $company->images()->create([
            'link' => $request->file('image_logo')->store('listings', 'public'),
            'mark' => 'logo',
        ]);
        $imageFacade = ImageFacade::make(public_path('storage/'.$image_logo->link))->fit(256, 256, function ($constraint) {
            $constraint->upsize();
        });
        $imageFacade->save();

        $image_header = $company->images()->create([
            'link' => $request->file('image_header')->store('listings', 'public'),
            'mark' => 'header',
        ]);
        $imageFacade = ImageFacade::make(public_path('storage/'.$image_header->link))->fit(1024, 256, function ($constraint) {
            $constraint->upsize();
        });
        $imageFacade->save();

        return redirect()->route('profile.index')->with('success', 'Request for registering Company was send');
    }

    public function edit(Company $company)
    {
        return view('profile.company.edit', [
            'company' => $company,
            'countries' => Country::all(),
        ]);
    }

    public function update(Request $request, Company $company)
    {
        $request->validate([
            'image_logo' => ['required', 'file', 'image', 'max:2048', 'dimensions:min_width=256,min_height=256'],
            'image_header' => ['required', 'file', 'image', 'max:4096', 'dimensions:min_width=1024,min_height=256'],
            'name' => ['required', 'string', 'max:255'],
            'legal_address' => ['required', 'string', 'max:255'],
            'actual_address' => ['required', 'string', 'max:255'],
            'country' => ['required', 'integer', 'exists:countries,id'],
            'description' => ['nullable', 'string', 'max:59392'],
        ]);

        $company->update([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'description' => $request->description,
            'legal_address' => $request->legal_address,
            'actual_address' => $request->actual_address,
            'status_id' => Status::moderation()->first()->id,
            'country_id' => $request->country,
        ]);

        if ($request->has('image_logo')) {
            foreach ($company->images()->where('mark', 'logo') as $image) {
                $image->delete();
            }

            $image_logo = $company->images()->create([
                'link' => $request->file('image_logo')->store('listings', 'public'),
                'mark' => 'logo',
            ]);
            $imageFacade = ImageFacade::make(public_path('storage/'.$image_logo->link))->fit(256, 256, function ($constraint) {
                $constraint->upsize();
            });
            $imageFacade->save();
        }

        if ($request->has('image_header')) {
            foreach ($company->images()->where('mark', 'header') as $image) {
                $image->delete();
            }

            $image_header = $company->images()->create([
                'link' => $request->file('image_header')->store('listings', 'public'),
                'mark' => 'header',
            ]);
            $imageFacade = ImageFacade::make(public_path('storage/'.$image_header->link))->fit(1024, 256, function ($constraint) {
                $constraint->upsize();
            });
            $imageFacade->save();
        }

        return redirect()->route('profile.index')->with('success', 'Request for registering Company was send');
    }

}
