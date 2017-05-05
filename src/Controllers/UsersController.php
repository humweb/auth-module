<?php

namespace Humweb\Auth\Controllers;

use Humweb\Auth\Groups\Group;
use Humweb\Auth\Permissions\PermissionsPresenter;
use Humweb\Auth\Requests\UserSaveRequest;
use Humweb\Auth\Users\User;
use Humweb\Core\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Hash;

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
     *
     * @param \Humweb\Auth\Users\User                       $user
     * @param \Humweb\Auth\Groups\Group                     $group
     * @param \Humweb\Auth\Permissions\PermissionsPresenter $permissions
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
     * Shows the form.
     *
     * @param string $mode
     * @param int    $id
     *
     * @return mixed
     */
    protected function showForm($mode, $id = null)
    {
        $groups      = $this->groups->select('id', 'name')->pluck('name', 'id');
        $permissions = $this->permissions->getPermissions();

        if ($id && ! ($user = $this->users->find($id))) {
            return redirect()->route('get.users')->with('error', 'User not found.');
        } else {
            $user = $this->users;
        }

        return $this->setContent('auth::users.form', compact('mode', 'user', 'groups', 'permissions'));
    }


    /**
     * Handle posting of the form for creating new user.
     *
     * @param \Humweb\Auth\Requests\UserSaveRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postCreate(UserSaveRequest $request)
    {
        $input = $request->except(['_token', 'groups']);

        $input['password']    = Hash::make($input['password']);
        $input['permissions'] = isset($input['permissions']) && is_array($input['permissions']) ? $input['permissions'] : [];
        $user                 = User::create($input);

        // Ensure we don't save blank password
        if (isset($input['password']) && empty($input['password'])) {
            unset($input['password']);
        }

        // Sync user groups
        if ($request->exists('groups')) {
            $user->groups()->sync($request->get('groups'));
        }

        return redirect()->route('get.users')->with('success', 'User has been created.');
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
        $input = $request->except(['_token', 'groups']);

        $user = $this->users->find($id);

        // Sync user groups
        if ($request->exists('groups')) {
            $user->groups()->sync($request->get('groups'));
        }

        $user->fill($input)->save();

        return redirect()->route('get.users')->with('success', 'User has been saved.');
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

            return redirect()->route('get.users')->with('info', 'User deleted.');
        }

        return redirect()->route('get.users')->with('warning', 'User not deleted.');
    }
}
