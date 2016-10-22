{{-- Page content --}}
@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="row">
                <div class="col-sm-6"><h4>Users</h4></div>
                <div class="col-sm-6 text-right">
                    <a href="{{ route('get.users.create') }}" class="btn btn-sm btn-default"><i class="fa fa-plus"></i></a>
                </div>
            </div>
        </div>
        <div class="panel-body">
            @if ($users->count())
                <table class="table table-striped">
                    <thead>
                    <th class="col-lg-2">Email</th>
                    <th class="col-lg-2">First name</th>
                    <th class="col-lg-3">Last name</th>
                    <th class="col-lg-2">Updated</th>
                    <th class="col-lg-2">Last Login</th>
                    <th class="col-lg-2"></th>
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
                                <a class="btn btn-sm btn-default" href="{{ route("get.users.edit", [$user->id]) }}"><i class="fa fa-edit"></i></a>
                                <a class="btn btn-sm btn-danger" href="{{ route('get.users.delete', [$user->id]) }}"><i class="fa fa-trash"></i></a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
        </div>
        <div class="panel-footer">
            Page {{ $users->currentPage() }} of {{ $users->lastPage() }}

            <div class="pull-right">
                {!! $users->render() !!}
            </div>
        </div>
        @else
            <div class="panel-body">
                Nothing to show here.
            </div>
        @endif
    </div>
@stop
