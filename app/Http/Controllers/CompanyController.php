<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
        $companies = Company::paginate(10);
        return view('companies.index', compact('companies'));
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('companies.create');
    }

       /**
     * Display the specified resource.
     */
    public function show(Company $company)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Company $company)
    {
        return response()->json($company);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:companies',
            'logo' => 'nullable|image|mimes:jpg,png|max:2048',
            'website' => 'nullable|url',
        ]);

        $logo = null;
         if ($request->hasFile('logo')) {
        $file = $request->file('logo');
        $filename = time() . '_' . $file->getClientOriginalName(); // Unique filename
        $file->move(public_path('assets/images'), $filename);       // Move to public/assets/images
        $validated['logo'] = 'assets/images/' . $filename;          // Save relative path in DB
    }

        Company::create([
            'name' => $request->name,
            'email' => $request->email,
            'logo' => $logo,
            'website' => $request->website,
        ]);

        return redirect()->route('companies.index')->with('success', 'Company added!');
    }

  

    public function update(Request $request, Company $company)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:companies,email,'.$company->id,
            'logo' => 'nullable|image|mimes:jpg,png|max:2048',
            'website' => 'nullable|url',
        ]);

        $data = $request->only('name', 'email', 'website');
        if ($request->hasFile('logo')) {
        $file = $request->file('logo');
        $filename = time() . '_' . $file->getClientOriginalName(); // Unique filename
        $file->move(public_path('assets/images'), $filename);       // Move to public/assets/images
        $validated['logo'] = 'assets/images/' . $filename;          // Save relative path in DB
    }

        $company->update($data);

        return redirect()->route('companies.index')->with('success', 'Company updated!');
    }

    public function destroy($id)
    {
        try {
            // Find the employee by ID
            $company = Company::findOrFail($id);

            // Delete the employee
            $company->delete();

            return redirect()->route('companies.index')->with('success', 'Company deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('companies.index')->with('error', 'Failed to delete company: ' . $e->getMessage());
        }
    }

 


}
