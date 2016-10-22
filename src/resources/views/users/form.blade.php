{{-- Page content --}}
@section('content')

    @if ($mode == 'create')
        {!! Form::open(['route' => 'post.users.create', 'method' => 'post']) !!}
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-sm-6"><h4>Create User</h4></div>
                    <div class="col-sm-6 text-right">
                        <button type="submit" class="btn btn-default" data-toggle="tooltip" title="Save"><i class="fa fa-check"></i></button>
                    </div>
                </div>
            </div>

    @else
        {!! Form::open(['route' => ['post.users.edit', $user->id], 'method' => 'post']) !!}
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-sm-6"><h4>Update User <small>{{$user->username}}</small></h4></div>
                    <div class="col-sm-6 text-right">
                        <button type="submit" class="btn btn-sm btn-default" data-toggle="tooltip" title="Save"><i class="fa fa-check"></i></button>
                    </div>
                </div>
            </div>

    @endif

    <div class="panel-body">

	<div class="form-group{{ $errors->first('first_name', ' has-error') }}">
		<label for="first_name">First name</label>
		<input type="text" class="form-control" name="first_name" id="first_name" value="{{ Input::old('first_name', $user->first_name) }}" placeholder="Enter the user first name.">
		<span class="help-block">{{{ $errors->first('first_name', ':message') }}}</span>
	</div>

	<div class="form-group{{ $errors->first('last_name', ' has-error') }}">
		<label for="last_name">Last name</label>
		<input type="text" class="form-control" name="last_name" id="last_name" value="{{ Input::old('last_name', $user->last_name) }}" placeholder="Enter the user first name.">
		<span class="help-block">{{{ $errors->first('last_name', ':message') }}}</span>
	</div>

	<div class="form-group{{ $errors->first('email', ' has-error') }}">
		<label for="email">Email</label>
		<input type="text" class="form-control" name="email" id="email" value="{{ Input::old('email', $user->email) }}" placeholder="Enter the user email.">
		<span class="help-block">{{{ $errors->first('email', ':message') }}}</span>
	</div>

	<div class="form-group{{ $errors->first('password', ' has-error') }}">
		<label for="password">Password</label>
		<input type="password" class="form-control" name="password" id="password" value="" placeholder="Enter the user password (only if you want to modify it).">
		<span class="help-block">{{{ $errors->first('password', ':message') }}}</span>
	</div>

    <div class="form-group{{ $errors->first('role', ' has-error') }}">
        <label for="role">User Role</label>
        {!! Form::select('groups[]', $groups, Input::old('role', $user->groups()->lists('id')), ['class' => 'select', 'id' => 'role',  'multiple'=>'multiple']) !!}
        <span class="help-block">{{{ $errors->first('role', ':message') }}}</span>
    </div>

    @include('auth::permissions.form', ['entity' => $user])

    </div>
    <div class="panel-footer">
        <button type="submit" class="btn btn-default">Save</button>
    </div>
    </div>
{!! Form::close() !!}

@endsection
