<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Models\Companies;
use App\Models\Employees;

class MainController extends Controller
{
    public function index() {
        return view('dashboard');
    }

    public function companiesIndex() {
        $companies = Companies::paginate(10);
        return view('companies', compact('companies'));
    }

    public function companiesSave(Request $request) {
        
        $validated = $request->validate([
            'name' => 'required|unique:companies|min:5|max:100',
            'email' => 'nullable|email|unique:companies|min:14|max:100',
            'logo' => 'nullable|mimes:jpg,jpeg,png|max:2048|dimensions:min_width=100,min_height=100',
            'website' => 'nullable|min:7|max:100',
            'country' => 'nullable|min:3|max:100'
        ],
        [
            'logo.dimensions' => 'Logo must have a minimum of 100 x 100 dimension.'
        ]
        );
        $name = Str::title($request->input('name'));
        $email = Str::lower($request->input('email'));
        $website = Str::lower($request->input('website'));
        $country = Str::title($request->input('country'));
        $logo = $request->file('logo');

        if($logo) {
            $new_logo_name = Str::lower($name).'-'.time().'.'.$logo->extension();

            if( $logo->storeAs('public', $new_logo_name ) ) {
                $company = new Companies;
                $company->name = $name;
                $company->email = $email;
                $company->website = $website;
                $company->country = $country;
                $company->logo = $new_logo_name;
                if( $company->save() ) {
                    return back()->with('suc_msg', 'Company added successfully!');
                }
                else {
                    return back()->with('err_msg', 'Company could not be added. Please try again.');
                }
            }
            else {
                return back()->with('err_msg', 'Logo could not be uploaded. Please try again.');
            }
        }
        else {
            $company = new Companies;
            $company->name = $name;
            $company->email = $email;
            $company->website = $website;
            $company->country = $country;
            $company->logo = $logo;
            if( $company->save() ) {
                return back()->with('suc_msg', 'Company added successfully!');
            }
            else {
                return back()->with('err_msg', 'Company could not be added. Please try again.');
            }
        }
        
    }

    public function companiesUpdate(Request $request) {
        $validated = $request->validate([
            'name' => 'required|unique:companies,name,'.$request->input('company_id').'|min:5|max:100',
            'email' => 'nullable|email|unique:companies,email,'.$request->input('company_id').'|min:14|max:100',
            'logo' => 'nullable|mimes:jpg,jpeg,png|max:2048|dimensions:min_width=100,min_height=100',
            'website' => 'nullable|min:7|max:100',
            'country' => 'nullable|min:3|max:100'
        ],
        [
            'logo.dimensions' => 'Logo must have a minimum of 100 x 100 dimension.'
        ]
        );
        $company_id = $request->input('company_id');
        $name = Str::title($request->input('name'));
        $email = Str::lower($request->input('email'));
        $website = Str::lower($request->input('website'));
        $country = Str::title($request->input('country'));
        $logo = $request->file('logo');

        if($logo) {
            $new_logo_name = Str::lower($name).'-'.time().'.'.$logo->extension();

            if( $logo->storeAs('public', $new_logo_name ) ) {
                $update_comp = Companies::where('id', $company_id)
                ->update(['name' => $name, 'email' => $email, 'website' => $website, 'country' => $country, 'logo' => $new_logo_name]);
                if( $update_comp ) {
                    return back()->with('suc_msg', 'Company updated successfully!');
                }
                else {
                    return back()->with('err_msg', 'Company could not be updated. Please try again.');
                }
            }
            else {
                return back()->with('err_msg', 'Logo could not be uploaded. Please try again.');
            }
        }
        else {
            $update_comp = Companies::where('id', $company_id)
            ->update(['name' => $name, 'email' => $email, 'website' => $website, 'country' => $country]);
            if( $update_comp ) {
                return back()->with('suc_msg', 'Company updated successfully!');
            }
            else {
                return back()->with('err_msg', 'Company could not be updated. Please try again.');
            }
        }
    }

    public function companiesDelete(Request $request) {
        $company_id = $request->company_id;
        $delete_comp = Companies::where('id', $company_id)
        ->delete();
        if($delete_comp) {
            return back()->with('suc_msg', 'Company deleted successfully!');
        }
        else {
            return back()->with('err_msg', 'Company could not be deleted. Please try again.');
        }
    }

    public function employeesIndex() {
        $employees = Employees::paginate(10);
        $companies = Companies::all();
        $data = array(
            'employees' => $employees,
            'companies' => $companies
        );
        return view('employees', compact('data'));
    }
    
    public function employeesSave(Request $request) {
        
        $validated = $request->validate([
            'fname' => 'required|min:3|max:50',
            'lname' => 'required|min:3|max:50',
            'email' => 'nullable|email|min:13|max:100',
            'phone' => 'nullable|regex:/^([0-9\s\-\+\(\)]*)$/|min:10|max:15'
        ]);
        $fname = Str::title($request->input('fname'));
        $lname = Str::title($request->input('lname'));
        $email = Str::lower($request->input('email'));
        $phone = $request->input('phone');
        $company_id = $request->input('company_id');

        $employee = new Employees;
        $employee->first_name = $fname;
        $employee->last_name = $lname;
        $employee->email = $email;
        $employee->phone = $phone;
        $employee->company_id = $company_id;
        if( $employee->save() ) {
            return back()->with('suc_msg', 'Employee added successfully!');
        }
        else {
            return back()->with('err_msg', 'Employee could not be added. Please try again.');
        }
        
    }

    public function employeesUpdate(Request $request) {
        
        $validated = $request->validate([
            'fname' => 'required|min:3|max:50',
            'lname' => 'required|min:3|max:50',
            'email' => 'nullable|email|min:13|max:100',
            'phone' => 'nullable|regex:/^([0-9\s\-\+\(\)]*)$/|min:10|max:15'
        ]);
        $fname = Str::title($request->input('fname'));
        $lname =Str::title($request->input('lname'));
        $email = Str::lower($request->input('email'));
        $phone = $request->input('phone');
        $company_id = $request->input('company_id');
        $employee_id = $request->input('employee_id');

        $update_emp = Employees::where('id', $employee_id)
        ->update(['first_name' => $fname, 'last_name' => $lname, 'email' => $email, 'phone' => $phone, 'company_id' => $company_id]);
        if( $update_emp ) {
            return back()->with('suc_msg', 'Employee updated successfully!');
        }
        else {
            return back()->with('err_msg', 'Employee could not be updated. Please try again.');
        }
        
    }

    public function employeesDelete(Request $request) {
        $employee_id = $request->input('employee_id');

        $delete_comp = Employees::where('id', $employee_id)
        ->delete();
        if( $delete_comp ) {
            return back()->with('suc_msg', 'Employee deleted successfully!');
        }
        else {
            return back()->with('err_msg', 'Employee could not be deleted. Please try again.');
        }
        
    }


}
