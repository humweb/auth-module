{{-- Page content --}}
@section('content')

{!! Form::open(['method'=>'post']) !!}
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4>{{ $mode == 'create' ? 'Create Group' : 'Update Group' }} <small>{{ $mode === 'update' ? $group->name : null }}</small></h4>
        </div>
        <div class="panel-body">
	<div class="form-group{{ $errors->first('name', ' has-error') }}">

		<label for="name">Name</label>

		<input type="text" class="form-control" name="name" id="name" value="{{ old('name', $group->name) }}" placeholder="Enter the group name.">

		<span class="help-block">{{{ $errors->first('name', ':message') }}}</span>

	</div>
	<div class="form-group{{ $errors->first('slug', ' has-error') }}">

		<label for="slug">Slug</label>

		<input type="text" class="form-control" name="slug" id="slug" value="{{ old('slug', $group->slug) }}" placeholder="Enter the group slug.">

		<span class="help-block">{{{ $errors->first('slug', ':message') }}}</span>

	</div>

        @include('auth::permissions.form', ['entity' => $group])
        </div>

	<div class="panel-footer">
        <button type="submit" class="btn btn-default">Save</button>
    </div>
</div>
</form>

@stop
