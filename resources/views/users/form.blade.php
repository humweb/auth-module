{{-- Page content --}}
@section('content')

    @if ($mode == 'create')
        {!! Form::open(['route' => 'post.users.create', 'method' => 'post']) !!}
        <div class="card card-default">
            <div class="card-header">
                <div class="row">
                    <div class="col-sm-6"><h4>Create User</h4></div>
                    <div class="col-sm-6 text-right">
                        <button type="submit" class="btn btn-secondary" data-toggle="tooltip" title="Save"><i class="fa fa-check"></i></button>
                    </div>
                </div>
            </div>

            @else
                {!! Form::open(['route' => ['post.users.edit', $user->id], 'method' => 'post']) !!}
                <div class="card card-default">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-sm-6">
                                <h4>Update User
                                    <small>{{$user->username}}</small>
                                </h4>
                            </div>
                            <div class="col-sm-6 text-right">
                                <button type="submit" class="btn btn-sm btn-secondary" data-toggle="tooltip" title="Save"><i class="fa fa-check"></i></button>
                            </div>
                        </div>
                    </div>

                    @endif

                    <div class="card-body">

                        <div class="form-group{{ $errors->first('first_name', ' has-error') }}">
                            <label for="first_name">First name</label>
                            <input type="text" class="form-control" name="first_name" id="first_name" value="{{ old('first_name', $user->first_name) }}" placeholder="Enter the user first name.">
                            <span class="help-block">{{{ $errors->first('first_name', ':message') }}}</span>
                        </div>

                        <div class="form-group{{ $errors->first('last_name', ' has-error') }}">
                            <label for="last_name">Last name</label>
                            <input type="text" class="form-control" name="last_name" id="last_name" value="{{ old('last_name', $user->last_name) }}" placeholder="Enter the user first name.">
                            <span class="help-block">{{{ $errors->first('last_name', ':message') }}}</span>
                        </div>

                        <div class="form-group{{ $errors->first('email', ' has-error') }}">
                            <label for="email">Email</label>
                            <input type="text" class="form-control" name="email" id="email" value="{{ old('email', $user->email) }}" placeholder="Enter the user email.">
                            <span class="help-block">{{{ $errors->first('email', ':message') }}}</span>
                        </div>

                        <div class="form-group{{ $errors->first('password', ' has-error') }}">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" name="password" id="password" value="" placeholder="Enter the user password (only if you want to modify it).">
                            <span class="help-block">{{{ $errors->first('password', ':message') }}}</span>
                        </div>

                        <div class="form-group{{ $errors->first('role', ' has-error') }}">
                            <label for="role">User Roles</label>
                            {!! Form::select('groups[]', $groups, old('role', $user->groups()->pluck('id')), ['class' => 'select', 'id' => 'role',  'multiple'=>'multiple']) !!}
                            <span class="help-block">{{{ $errors->first('role', ':message') }}}</span>
                        </div>

                        @include('auth::permissions.form', ['entity' => $user])

                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-secondary">Save</button>
                    </div>
                </div>
        {!! Form::close() !!}

@endsection
