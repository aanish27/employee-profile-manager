<?php

namespace App\Http\Controllers;

use App\Models\BankAccount;
use App\Models\Company;
use App\Models\Employee;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

use function PHPUnit\Framework\isNull;

class EmployeeController extends Controller
{
    public function index(Request $request){
        $companies = Company::withTrashed()->get();
        $positions = Employee::pluck('position');
        return view('admin' , [ 'companies' => $companies , 'positions' => $positions ]);
    }

    public function draw(Request $request){

        //SERVER SIDE RENDERING HANDLE FOR data table
        $search = $request->query('search')['value'];
        $draw = $request->query('draw', 1);
        $start = $request->query('start', 0);
        $length = $request->query('length', 10);
        $totalEmployees =   Employee::count();
        $arrayColumns = ['', 'company_name', 'branch', 'name', 'position', 'dob', 'email', 'phone', 'address', 'account_no'];
        $arr = array();

        //checking if dropdown filter is filled
        if(is_null($search)){
            for ($x = 0; $x <= 9; $x++) {
                if(!is_null($request->query('columns')[$x]['search']['value'])){
                    $arr[$x] = $request->query('columns')[$x]['search']['value'];
                };
            }
        }

         $employees = Employee::select('employees.*' , 'companies.name as company_name' ,'companies.branch', 'companies.deleted_at as company_deleted_at' , 'bank_accounts.account_no')
                ->join('companies', 'employees.company_id', '=', 'companies.id')
                ->join('bank_accounts', 'employees.id', '=', 'bank_accounts.employee_id');

        //dropdown filter not null
        if(!empty($arr)){
            $searchPosition = empty($arr) ? $search : (array_key_exists(4, $arr) ? $arr[4] : null);
            $searchCompany = empty($arr) ? $search : (array_key_exists(1, $arr) ? $arr[1] : null);
            $employees
                ->where('employees.position', 'like', "%" . $searchPosition . "%")
                ->where('companies.name', 'like', "%" . $searchCompany . "%")
                ->whereHas('company', function ($q) use($searchCompany){
                    $q->withTrashed();
                });
            }//dropdown filter null
            else{
            $employees
                ->where('employees.name', 'like', "%" . $search . "%")
                ->orWhere('employees.position', 'like', "%" . $search . "%")
                ->orWhere('employees.email', 'like', "%" . $search . "%")
                ->orWhere('employees.address', 'like', "%" . $search . "%")
                ->orWhere('employees.dob', 'like', "%" . $search . "%")
                ->orWhere('employees.phone', 'like', "%" . $search . "%")
                ->orWhereHas(
                    'bankAccount',
                    function ($q) use ($search) {
                        $q->where('account_no', 'like', "%" . $search . "%")->select('branch');
                    }
                )
                ->orWhereHas('company', function ($q) use ($search) {
                    $q->withTrashed()
                        ->where('companies.name', 'like', "%" . $search . "%")
                        ->orWhere('companies.branch', 'like', "%" . $search . "%");
                });
        }

        #column ordering
        if (!is_null($request->query('order'))) {
            $num = $request->query('order')['0']['column'];
            $orderDir = $request->query('order')['0']['dir'];
            if(!$num == 0){
                $employees = ($orderDir == 'desc') ? $employees->orderBy($arrayColumns[$num], $orderDir) : $employees->orderBy($arrayColumns[$num], $orderDir);
            }
        };

        $filteredEmployees = $search ? $employees->count() : $totalEmployees;
        $employees = $employees->skip($start)
                                ->take($length)
                                ->get();

        $response = [
            'draw' => intval($draw),
            'recordsTotal' => intval($totalEmployees),
            'recordsFiltered' => $filteredEmployees,
            'data' => $employees
        ];

        return Response::json($response);
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
