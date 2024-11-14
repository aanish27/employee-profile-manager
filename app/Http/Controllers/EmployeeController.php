<?php

namespace App\Http\Controllers;
use App\Models\BankAccount;
use App\Models\Company;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class EmployeeController extends Controller
{
    public function index(Request $request){
        $companies = Company::withTrashed()->get();
        $positions = Employee::pluck('position');
        return view('dashboard.employee' , [ 'companies' => $companies , 'positions' => $positions ]);
    }

    public function draw(Request $request){

        //SERVER SIDE RENDERING HANDLE FOR data table
        $search = $request->query('search')['value'];

        $draw = $request->query('draw', 1);
        $start = $request->query('start', 0);
        $length = $request->query('length', 10);
        $totalEmployees =   Employee::count();

        $employees = Employee::with('company' , 'bankAccount');

        if(!$request->dropdowns){
            $employees->where('name', 'like', "%" . $search . "%")
                ->orWhere('position', 'like', "%" . $search . "%")
                ->orWhere('email', 'like', "%" . $search . "%")
                ->orWhere('address', 'like', "%" . $search . "%")
                ->orWhere('dob', 'like', "%" . $search . "%")
                ->orWhere('phone', 'like', "%" . $search . "%")
                ->orWhereHas('bankAccount', function ($q) use ($search) { //this is a closure function uk js closure..$q is the query of the modal and $search is passing the variale to closure as it cant accessthe varibales out of the fucnions
                    $q->where('account_no', 'like', "%" . $search . "%");
                })
                ->orWhereHas('company', function ($q) use ($search) {
                    $q->where('name', 'like', "%" . $search . "%")
                        ->orWhere('branch', 'like', "%" . $search . "%");
                });
        }
        else{
            $employees = ($searchPosition = $request->dropdowns['position'] ?? null) ?
                $employees->whereIn('position', $searchPosition) : $employees;

            $employees = ($searchCompany = $request->dropdowns['company'] ?? null) ?
                $employees->whereHas('company', function ($q) use ($searchCompany) {
                    $q->whereIn('id', $searchCompany);
                }) : $employees;
        };


        if ($order = $request->query('order')[0] ?? null) {
            $orderDir = $order['dir'] ?? 'asc';
            $mapping = [
                'company.branch' => Company::select('branch')->whereColumn('companies.id', 'employees.company_id')->withTrashed(),
                'company.name' => Company::select('name')->whereColumn('companies.id', 'employees.company_id')->withTrashed(),
                'bank_account.account_no' => BankAccount::select('account_no')->whereColumn('employees.id', 'bank_accounts.employee_id')
            ];
            $employees->orderBy($mapping[$order['name']] ?? $order['name'], $orderDir);
        }

        $filteredEmployees = $search ? $employees->count() : $totalEmployees;
        $employees = $employees->skip($start)
                                ->take($length)
                                ->get();

        return Response::json([
            'draw' => intval($draw),
            'recordsTotal' => intval($totalEmployees),
            'recordsFiltered' => $filteredEmployees,
            'data' => $employees
        ]);
    }

    public function store(Request $request){
        try {
            $employeeValidated = $request->validate([
                'name' => 'required|max:50|',
                'position' => 'required|max:50|',
                'dob' => 'required|date',
                'email' => 'required|unique:employees|email',
                'phone' => 'required|max:13',
                 'address' => 'required|max:255',
                 'company_id' => 'required',
            ]);
            $bankAccValidated = $request->validate([
                'beneficiary_name' => 'required',
                'bank_name' => 'required',
                'branch' => 'required',
                'account_no' => 'required|max:9',
            ]);
            $employee = Employee::create($employeeValidated);
            $bankAccValidated['employee_id'] = $employee->id;
            BankAccount::create($bankAccValidated);
            return Response::json('New '. $employee->name . ' Details Added');
        } catch (ValidationException $e) {
            return Response::json($e->errors(), 422);
        }
    }

    public function edit(string $id){
        $employee = Employee::with(['bankAccount' , 'company' => function($query) {
            $query->withTrashed();
           }])
           ->where('id',$id)->get();
        return Response::json($employee);
    }

    public function update(Request $request , string $id){
        try {
            $employeeValidated = $request->validate([
                'name' => 'required|max:50',
                'position' => 'required|max:50',
                'dob' => 'required|date',
                'email' => [
                    'required',
                    'email',
                    Rule::unique('employees', 'email')->ignore($id),
                ],
                'phone' => 'required|max:13',
                'address' => 'required|max:255',
                'company_id' => 'required',
            ]);

            $bankAccValidated = $request->validate([
                'beneficiary_name' => 'required',
                'bank_name' => 'required',
                'branch' => 'required',
                'account_no' => 'required|max:9',
                'bank_id' => 'required',
            ]);

            Employee::find($id)->update( $employeeValidated);
            $bank_id = $bankAccValidated['bank_id'];
            unset($bankAccValidated['bank_id']);
            BankAccount::find($bank_id)->update($bankAccValidated);

            return Response::json('Employee '  . $employeeValidated['name'] . ' and related Bank Account Details Updated');
        } catch (ValidationException $e) {
            return Response::json($e->errors(), 422);
        }
    }

    public function destroy(string $id){
        $employee = Employee::find($id);
        Employee::destroy($id);
        return Response::json( "Employee " . $employee->name . " and related Bank Account Records were Deleted");
    }
}
