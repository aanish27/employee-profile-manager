<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Validation\ValidationException;

class CompanyController extends Controller
{
    public function index()
    {
        $companys = Company::all();
        $countries = Company::pluck('country');
        return view('company.index', ['companys' => $companys , 'countries' => $countries]);
    }

    public function draw(Request $request){
        $search = $request->query('search')['value'];
        $draw = $request->query('draw', 1);
        $start = $request->query('start', 0);
        $length = $request->query('length', 10);
        $totalCompanys =   Company::count();
        $dTcolumns = $request->query('columns');;
        $filterDropDownValues = array();

        if (is_null($search)) {
            for ($x = 0; $x <= 6; $x++) {
                if (!is_null($dTcolumns[$x]['search']['value'])) {
                    $filterDropDownValues[$dTcolumns[$x]['data']] = $dTcolumns[$x]['search']['value'];
                };
            }
        }

        if(!empty($filterDropDownValues)){
            $searchCountry = array_key_exists('country', $filterDropDownValues) ? $filterDropDownValues['country'] : null;
            $companys = Company::where('country', 'like', "%" . $searchCountry . "%");

        }else{
            $companys = Company::where('name', 'like', "%" . $search . "%")
                ->orWhere('country', 'like', "%" . $search . "%")
                ->orWhere('branch', 'like', "%" . $search . "%")
                ->orWhere('address', 'like', "%" . $search . "%");
        }

        if (!is_null($request->query('order'))) {
            $num = $request->query('order')['0']['column'];
            $orderDir = $request->query('order')['0']['dir'];
            if (!$num == 0) {
                $companys = ($orderDir == 'desc')
                        ? $companys->orderBy($dTcolumns[$num]['data'], $orderDir)
                        : $companys->orderBy($dTcolumns[$num]['data'], $orderDir);
            }
        };

        $filteredCompanys = $search ? $companys->count() : $totalCompanys;
        $companys = $companys->skip($start)
                                ->take($length)
                                ->withCount('employees','projects')->get();

        $response = [
            'draw' => intval($draw),
            'recordsTotal' => intval($totalCompanys),
            'recordsFiltered' => $filteredCompanys,
            'data' => $companys

        ];
        return Response::json($response);
    }

    public function store(Request $request)
    {
        try{
            $companyValidated = $request->validate([
                'name' => 'required',
                'branch' => 'required',
                'country' => 'required',
                'address' => 'required',

            ]);
            Company::create($companyValidated);
            return Response::json("A New Company ". $companyValidated['name'] . " Recored Added");

        }catch (ValidationException $e) {
            return Response::json($e->errors(), 422);
        }
    }

    public function show(string $id)
    {
        $company = Company::find($id);
        $companyEmployees = $company->employees;
        return view('company.show' , ['companyEmployees' => $companyEmployees , 'company' => $company ]);
    }

    public function edit(string $id)
    {
        $company = Company::find($id);
        $company->projects_count = $company->projects()->count();
        $company->employees_count = $company->employees()->count();
        return Response::json($company);
    }

    public function update(Request $request)
    {
        try{
            $companyValidated = $request->validate([
                'name' => 'required',
                'branch' => 'required',
                'country' => 'required',
                'address' => 'required',
                'company_id' => 'required',

            ]);

            $company_id = $companyValidated['company_id'];
            unset($companyValidated['company_id']);
            Company::find($company_id)->update($companyValidated);
            return Response::json("Company ". $companyValidated['name'] . " Recored Updated");
        }catch (ValidationException $e) {
            return Response::json($e->errors(), 422);
        }
    }

    public function destroy(string $id)
    {
        $company = Company::find($id);
        $projects = $company->projects()->count();
        Company::destroy($id);
        return Response::json( "The Company " . $company->name . ", and ". $projects ." related project records Were Deleted");
    }
}
