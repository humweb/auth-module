{{-- Page content --}}
@section('content')
    <div class="card card-default">
        <div class="card-header">
            <div class="row">
                <div class="col-sm-6"><h4>Users</h4></div>
                <div class="col-sm-6 text-right">
                    <a href="{{ route('get.users.create') }}" class="btn btn-sm btn-secondary"><i class="fa fa-plus"></i></a>
                </div>
            </div>
        </div>
        <div class="card-body">
            @if ($users->count())
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Email</th>
                        <th>First name</th>
                        <th>Last name</th>
                        <th>Updated</th>
                        <th colspan="2">Last Login</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->first_name }}</td>
                            <td>{{ $user->last_name }}</td>
                            <td>{{ $user->updated_at }}</td>
                            <td>{{ $user->last_login ? (new Carbon\Carbon($user->last_login))->diffForHumans() : '' }}</td>
                            <td class="text-right">
                                <div class="btn-group">
                                    <a class="btn btn-sm btn-secondary" href="{{ route("get.users.edit", [$user->id]) }}"><i class="fa fa-edit"></i></a>
                                    <a class="btn btn-sm btn-danger" href="{{ route('get.users.delete', [$user->id]) }}"><i class="fa fa-trash"></i></a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
        </div>
        <div class="card-footer">
            Page {{ $users->currentPage() }} of {{ $users->lastPage() }}

            <div class="pull-right">
                {!! $users->render() !!}
            </div>
        </div>
        @else
            <div class="card-body">
                Nothing to show here.
            </div>
        @endif
    </div>
@stop
