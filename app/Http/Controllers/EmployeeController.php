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
        return view('dashboard.employee.index' , [ 'companies' => $companies , 'positions' => $positions ]);
    }

    public function draw(Request $request){

        //SERVER SIDE RENDERING HANDLE FOR data table
        $search = $request->query('search')['value'];

        $draw = $request->query('draw', 1);
        $start = $request->query('start', 0);
        $length = $request->query('length', 10);
        $totalEmployees = Employee::count();
        $filterDropDownValues = array();
        $dTcolumns = $request->query('columns');

        //checking if dropdown filter is filled
        // if(is_null($search)){
        //     for ($x = 0; $x <= 9; $x++) {
        //         if(!is_null($dTcolumns[$x]['search']['value'])){
        //             $filterDropDownValues[$dTcolumns[$x]['data']] = $dTcolumns[$x]['search']['value'];
        //         };
        //     }
        // }

        $employees = Employee::with('company' , 'bankAccount');

        #dropdown
        if(!empty($filterDropDownValues)){
            $searchPosition = array_key_exists('position', $filterDropDownValues) ? $filterDropDownValues['position'] : null;
            $searchCompany = array_key_exists('company_name', $filterDropDownValues) ? $filterDropDownValues['company_name'] : null;

            $employees
                ->where('position', 'like', "%" . $searchPosition . "%")
                ->where('companies.name', 'like', "%" . $searchCompany . "%");
            }//dropdown filter null
            else{
            $employees
                ->where('name', 'like', "%" . $search . "%")
                ->orWhere('position', 'like', "%" . $search . "%")
                ->orWhere('email', 'like', "%" . $search . "%")
                ->orWhere('address', 'like', "%" . $search . "%")
                ->orWhere('dob', 'like', "%" . $search . "%")
                ->orWhere('phone', 'like', "%" . $search . "%")
                ->orWhereHas('bankAccount',function ($q) use ($search) { //this is a closure function uk js closure..$q is the query of the modal and $search is passing the variale to closure as it cant accessthe varibales out of the fucnions
                    $q->where('account_no', 'like', "%" . $search . "%");
                })
                ->orWhereHas('company', function ($q) use ($search) {
                    $q->where('companies.name', 'like', "%" . $search . "%")
                    ->orWhere('companies.branch', 'like', "%" . $search . "%");
                });
        }

        #column ordering
        if ($request->query('order') != null){
            if($request->query('order')[0]['name'] != null){
                $orderCol = $request->query('order')[0]['name'];
                $orderDir = $request->query('order')['0']['dir'];
                if ($orderCol === 'company.branch') {
                    $employees->orderBy(
                        Company::select('branch')
                            ->whereColumn('companies.id', 'employees.company_id')
                            ->withTrashed(),
                        $orderDir);
                } elseif ($orderCol === 'company.name') {
                    $employees->orderBy(
                        Company::select('name')
                            ->whereColumn('companies.id', 'employees.company_id')
                            ->withTrashed(),
                        $orderDir);
                } elseif ($orderCol === 'bank_account.account_no') {
                    $employees->orderBy(
                        BankAccount::select('account_no')
                            ->whereColumn('employees.id', 'bank_accounts.employee_id'),
                        $orderDir);
                }else{
                    $employees->orderBy($orderCol,$orderDir);
                }
            }
        };


        // #column ordering
        // if (!is_null($request->query('order'))) {
        //     $num = $request->query('order')['0']['column'];
        //     $orderDir = $request->query('order')['0']['dir'];
        //     if(!$num == 0){

        //         $employees = ($orderDir == 'desc')
        //                 ? $employees->orderBy('company_id', $orderDir)
        //                 : $employees->orderBy('company_id', $orderDir);
        //     }
        // };

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
