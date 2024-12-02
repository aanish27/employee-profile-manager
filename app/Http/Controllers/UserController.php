<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Mpdf\Mpdf;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        return view('dashboard.user', ['users' => $users]);
    }


    public function draw(Request $request)
    {
        $search = $request->query('search')['value'];
        $draw = $request->query('draw', 1);
        $start = $request->query('start', 0);
        $length = $request->query('length', 10);
        $usersQuery = User::query();
        $totalusers = $usersQuery->count();

        if (!$request->dropdowns) {
            $users = $usersQuery->where('name', 'like', "%" . $search . "%")
                ->orWhere('email', 'like', "%" . $search . "%")
                ->orWhere('is_active', 'like', "%" . $search . "%");
        } else {
            $searchUser = $request->dropdowns['user'] ?? null;
            $users = $usersQuery->whereIn('user', $searchUser);
        }

        if ($order = $request->query('order')[0] ?? null) {
            $orderDir = $order['dir'] ?? 'asc';
            $users->orderBy($order['name'], $orderDir);
        }

        $filteredusers = $search ? $users->count() : $totalusers;
        $users = $users->skip($start)
            ->take($length)
            ->get();

        return Response::json([
            'draw' => intval($draw),
            'recordsTotal' => intval($totalusers),
            'recordsFiltered' => $filteredusers,
            'data' => $users
        ]);
    }

    public function createPDF(){
        $document = new Mpdf();
        $users = User::all();

        $rows = '';
        foreach ($users as $user) {
            $is_active = ($user->is_active == 1) ? 'Active' : 'Not Active';
            $rows .= '<tr>';
            $rows .= '<td>' . $user->id . '</td>';
            $rows .= '<td>' . $user->name . '</td>';
            $rows .= '<td>' . $user->email . '</td>';
            $rows .= '<td>' . $is_active . '</td>';
            $rows .= '<td  style="width: 25%"> </td>';
            $rows .= '</tr>';
        }

            $tableHTML = '
            <h1>User Manager</h1>
            <table border="1" style="border-collapse: collapse; width: 100%; text-align: left;">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Remark</th>
                    </tr>
                </thead>
                <tbody>
                    ' . $rows . '
                </tbody>
            </table>
            ';


        $document->WriteHTML($tableHTML);
        Storage::put('pdfs/user_information.pdf', $document->Output('user_information.pdf', "S"));
        $document->Output('user_information.pdf', "I");
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
