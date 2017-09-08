@section('content')

    <div class="card card-default">
        <div class="card-header">
            <span class="pull-right"><a href="{{ route('get.groups.create') }}" class="btn btn-sm btn-secondary"><i class="fa fa-plus"></i></a></span>
            <h4>Groups </h4>
        </div>
        @if ($groups->count())
            <div class="card-body">

                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th colspan="2">Slug</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($groups as $group)
                        <tr>
                            <td>{{ $group->name }}</td>
                            <td>{{ $group->slug }}</td>
                            <td class="text-right">
                                <div class="btn-group">
                                    <a class="btn btn-sm btn-secondary" href="{{ route('get.groups.edit', [$group->id]) }}"><i class="fa fa-edit"></i></a>
                                    <a class="btn btn-sm btn-danger" href="{{ route('get.groups.delete', [$group->id]) }}"><i class="fa fa-trash"></i></a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                Page {{ $groups->currentPage() }} of {{ $groups->lastPage() }}
                <div class="pull-right">
                    {{ $groups->render() }}
                </div>
            </div>
        @else
            <div class="card-body">
                <div class="text-muted">
                    Nothing to show here.
                </div>
            </div>
        @endif
    </div>
@stop
