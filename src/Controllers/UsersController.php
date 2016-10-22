<?php

namespace Humweb\Auth\Controllers;

use Humweb\Auth\Permissions\PermissionsPresenter;
use Humweb\Auth\Requests\UserSaveRequest;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Redirect;
use Humweb\Auth\Groups\Group;
use Humweb\Auth\Users\User;

class UsersController extends AdminController
{
    protected $layout = 'layouts.admin';

    /**
     * Holds the User repository.
     *
     * @var \Users\User
     */
    protected $users;
    protected $groups;
    /**
     * @var PermissionsPresenter
     */
    protected $permissions;


    /**
     * Constructor.
     */
    public function __construct(User $user, Group $group, PermissionsPresenter $permissions)
    {
        parent::__construct();

        $this->users  = $user;
        $this->groups = $group;

        $this->viewShare('title', 'User Management');
        $this->crumb('Users', route('get.users'));
        $this->permissions = $permissions;
    }


    /**
     * Display a listing of users.
     *
     * @return \Illuminate\View\View
     */
    public function getIndex()
    {
        $this->crumb('Index');
        $users = $this->users->paginate();

        return $this->setContent('auth::users.index', compact('users'));
    }


    /**
     * Show the form for creating new user.
     *
     * @return \Illuminate\View\View
     */
    public function getCreate()
    {
        return $this->showForm('create');
    }


    /**
     * Handle posting of the form for creating new user.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postCreate(UserSaveRequest $request)
    {
        $input = $request->except('_token');
        $user  = $this->users->create($input);

        //Ensure we don't save blank password
        if (isset($input['password']) && empty($input['password'])) {
            unset($input['password']);
        }

        // Sync Roles
        if (isset($input['groups'])) {
            $user->groups()->sync($input['groups']);
            unset($input['groups']);
        }

        $code = Activation::create($user);
        Activation::complete($user, $code);

        return redirect('get.users')->with('success', 'User has been saved.');
    }


    /**
     * Show the form for updating user.
     *
     * @param int $id
     *
     * @return mixed
     */
    public function getEdit($id)
    {
        return $this->showForm('update', $id);
    }


    /**
     * Handle posting of the form for updating user.
     *
     * @param UserSaveRequest $request
     * @param int             $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postEdit(UserSaveRequest $request, $id)
    {
        $input = $request->except('_token');

        $user = $this->users->find($id);

        // Sync Roles
        if (isset($input['groups'])) {
            $user->groups()->sync((array)$input['groups']);
            unset($input['groups']);
        }

        $user->fill($input)->save();

        return redirect()->route('get.users');
    }


    /**
     * Remove the specified user.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getDelete($id)
    {
        if ($user = $this->users->find($id)) {
            $user->delete();

            return Redirect::to('users');
        }

        return Redirect::to('users');
    }


    /**
     * Shows the form.
     *
     * @param string $mode
     * @param int    $id
     *
     * @return mixed
     */
    protected function showForm($mode, $id = null)
    {
        $groups      = $this->groups->select('id', 'name')->lists('name');
        $permissions = $this->permissions->getPermissions();

        if ($id) {
            if ( ! $user = $this->users->find($id)) {
                return Redirect::to('users');
            }
        } else {
            $user = $this->users;
        }

        return $this->setContent('auth::users.form', compact('mode', 'user', 'groups', 'permissions'));
    }
}
