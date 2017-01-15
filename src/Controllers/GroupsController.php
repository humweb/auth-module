<?php

namespace Humweb\Auth\Controllers;

use Humweb\Auth\Groups\Group;
use Humweb\Auth\Permissions\PermissionsPresenter;
use Humweb\Auth\Requests\GroupSaveRequest;
use Humweb\Core\Http\Controllers\AdminController;

class GroupsController extends AdminController
{
    protected $layout = 'layouts.admin';

    /**
     * Holds the Sentinel Roles repository.
     *
     * @var Humweb\Auth\Groups\Group
     */
    protected $groups;

    /**
     * @var PermissionsPresenter
     */
    protected $permissions;


    /**
     * Constructor.
     *
     * @param PermissionsPresenter $permissions
     */
    public function __construct(Group $group, PermissionsPresenter $permissions)
    {
        parent::__construct();

        $this->groups      = $group;
        $this->permissions = $permissions;

        $this->viewShare('title', 'Groups Management');
        $this->crumb('Groups', route('get.groups'));
    }


    /**
     * Display a listing of groups.
     *
     * @return \Illuminate\View\View
     */
    public function getIndex()
    {
        $this->crumb('Index');
        $groups = $this->groups->paginate();

        return $this->setContent('auth::groups.index', compact('groups'));
    }


    /**
     * Show the form for creating new group.
     *
     * @return \Illuminate\View\View
     */
    public function getCreate()
    {
        $this->crumb('Create');

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
        $permissions = $this->permissions->getPermissions();

        if ($id) {
            if ( ! $group = $this->groups->find($id)) {
                return redirect()->route('get.groups');
            }
        } else {
            $group = $this->groups;
        }

        return $this->setContent('auth::groups.form', compact('mode', 'group', 'permissions'));
    }


    /**
     * Handle posting of the form for creating new group.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postCreate(GroupSaveRequest $request)
    {
        $group = $this->groups->create($request->all());

        return redirect()->route('get.groups')->with('success', 'Group has been saved.');
    }


    /**
     * Show the form for updating group.
     *
     * @param int $id
     *
     * @return mixed
     */
    public function getEdit($id)
    {
        $this->crumb('Edit');

        return $this->showForm('update', $id);
    }


    /**
     * Handle posting of the form for updating group.
     *
     * @param GroupSaveRequest $request
     * @param int              $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postEdit(GroupSaveRequest $request, $id)
    {
        $group = $this->groups->find($id);
        $group->fill($request->all());
        $group->save();

        return redirect()->route('get.groups')->with('success', 'Group has been saved.');
    }


    /**
     * Remove the specified group.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getDelete($id)
    {
        if ($group = $this->groups->find($id)) {
            $group->delete();
        }

        return redirect()->route('get.groups');
    }
}
