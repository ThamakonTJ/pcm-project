@php
    use Illuminate\Foundation\Auth\AuthenticatesUsers;
@endphp 

@extends(((Auth()->user()->role == 2) ? 'dashboards.admins.layouts.admin-dash-layout' : 'dashboards.users.layouts.user-dash-layout'))
       

@section('title', 'Manage user')
@section('content')

    <head>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.1/css/bootstrap.min.css">
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.1/js/bootstrap.min.js"></script>
        <meta name="csrf-token" content="{{ csrf_token() }}">
    </head>

    <h1>User</h1>
    <div class="mb-2">
        <a href="{{ route('manage_user.create') }}" role="button" class="btn btn-sm btn-success">Add User</a>
    </div>
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
    
    <div>
        <table id="tbContent" class="table table-bordered">
            <tr>
                <th>No.</th>
                <th>ชื่อ</th>
                <th>อีเมล</th>
                <th>ตำแหน่ง</th>
                <th style="width: 200px"></th>

            </tr>
     
      
            @foreach ($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                     @if($user->role == '2')
                        @php echo'Admin' @endphp
                        @elseif($user->role == '1')
                        @php echo'Warehouse staff' @endphp
                        @else
                        @php echo'Purchasing Officer' @endphp
                    @endif
                    </td>
                    <td>
                        <form action="{{ route('manage_user.destroy', $user->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">ลบ</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </table>
     
        {!! $users->links('pagination::bootstrap-5') !!}
    </div>
@endsection
