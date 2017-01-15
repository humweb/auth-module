@section('content')

    <div class="panel panel-default">
        <div class="panel-heading">
            <span class="pull-right"><a href="{{ route('get.groups.create') }}" class="btn btn-sm btn-default"><i class="fa fa-plus"></i></a></span>
            <h4>Groups </h4>
        </div>
            @if ($groups->count())
            <div class="panel-body">

                <table class="table table-striped">
                    <thead>
                    <th class="col-lg-6">Name</th>
                    <th class="col-lg-4">Slugs</th>
                    <th class="col-lg-2"></th>
                    </thead>
                    <tbody>
                    @foreach ($groups as $group)
                        <tr>
                            <td>{{ $group->name }}</td>
                            <td>{{ $group->slug }}</td>
                            <td class="text-right">
                                <a class="btn btn-sm btn-default" href="{{ route('get.groups.edit', [$group->id]) }}"><i class="fa fa-edit"></i></a>
                                <a class="btn btn-sm btn-danger" href="{{ route('get.groups.delete', [$group->id]) }}"><i class="fa fa-trash"></i></a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="panel-footer">
                Page {{ $groups->currentPage() }} of {{ $groups->lastPage() }}
                <div class="pull-right">
                    {{ $groups->render() }}
                </div>
            </div>
        @else
            <div class="panel-body">
            <div class="well">
                Nothing to show here.
            </div>
            </div>
        @endif
    </div>
@stop
