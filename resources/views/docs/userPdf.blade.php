<h1>{{ $title }}</h1>
<table border="1" style="border-collapse: collapse;width: 100%; text-align: left;">
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
        @foreach ( $users as $user ){
            <tr>
                <td> {{ $user->id }}</td>
                <td> {{ $user->name }}</td>
                <td> {{ $user->email }}</td>
                <td> {{ $user->status }}</td>
                <td width="40%"></td>
            </tr>
        }
        @endforeach
    </tbody>
</table>
