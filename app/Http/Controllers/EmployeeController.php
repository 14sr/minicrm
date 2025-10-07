<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Company;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::paginate(5);
        $companies = Company::all(); // pagination
        return view('employees.index', compact('employees','companies'));
    }

    public function create()
    {
        return view('employees.create');
    }

    public function store(Request $request)
{
    $request->validate([
        'first_name' => 'required|string|max:255',
        'last_name'  => 'required|string|max:255',
        'email'      => 'nullable|email|unique:employees,email',
        'phone'      => 'nullable|string|max:15',
        'company_id' => 'required|exists:companies,id',
    ]);

    Employee::create([
        'first_name' => $request->first_name,
        'last_name'  => $request->last_name,
        'email'      => $request->email,
        'phone'      => $request->phone,
        'company_id'=>$request->company_id,
    ]);

    return redirect()->route('employees.index')->with('success', 'Employee added successfully.');
}


    public function edit(Employee $employee)
    {
        return view('employees.edit', compact('employee'));
    }

    public function update(Request $request, Employee $employee)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:employees,email,'.$employee->id,
            'phone' => 'required|string|max:15',
            'position' => 'required|string|max:100',
        ]);

        $employee->update($request->all());
        return redirect()->route('employees.index')->with('success', 'Employee updated successfully.');
    }

    public function destroy($id)
    {
        try {
            // Find the employee by ID
            $employee = Employee::findOrFail($id);

            // Delete the employee
            $employee->delete();

            return redirect()->route('employees.index')->with('success', 'Employee deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('employees.index')->with('error', 'Failed to delete employee: ' . $e->getMessage());
        }
    }

}
