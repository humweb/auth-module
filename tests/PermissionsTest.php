<?php

namespace Humweb\Tests\Auth;

use Humweb\Auth\Permissions\Permission;
use PHPUnit\Framework\TestCase;

class PermissionsTest extends TestCase
{

    protected $groups     = [];
    protected $user       = [];
    protected $permission = [];


    /**
     *
     */
    public function setUp()
    {
        parent::setUp();

        $this->groups = [

            'author' => $this->createDummyPermissions([
                'pages.create' => true,
                'pages.edit'   => true,
                'pages.delete' => false,
                'pages.list'   => true,

                'posts.create'  => false,
                'posts.edit'    => false,
                'posts.delete'  => false,
                'posts.list'    => false,
                'settings.edit' => false,
            ]),

            'admin' => $this->createDummyPermissions([
                'pages.create' => true,
                'pages.edit'   => true,
                'pages.delete' => false,
                'pages.list'   => true,

                'posts.create'  => true,
                'posts.edit'    => false,
                'posts.delete'  => true,
                'posts.list'    => false,
                'groups.create' => 1,
                'groups.edit'   => 1,
                'groups.delete' => 1
            ]),
        ];

        $this->user = $this->createDummyPermissions([
            'settings.edit' => true
        ]);

        //dd($this->groups, $this->user);
        $this->permission = Permission::fromPermissible($this->groups, $this->user);
    }


    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function testBasicExample()
    {

        $permissionExpected = [
            'pages.create',
            'pages.edit',
            'pages.list',
            'posts.create',
            'posts.delete',
            'groups.create',
            'groups.edit',
            'groups.delete',
            'settings.edit'
        ];
        $permissionGranted  = $this->permission->getAllocatedPermissions();

        $this->assertEquals($permissionExpected, $permissionGranted);
    }


    /**
     * Strict permissions check for single permission
     *
     * @return void
     */
    public function testHasPermission()
    {
        $this->assertEquals(true, $this->permission->hasPermission('pages.create'));
        $this->assertEquals(false, $this->permission->hasPermission('posts.edit'));
    }


    /**
     * Strict permissions check for array of permissions
     *
     * @return void
     */
    public function testHasPermissionArray()
    {

        $permissionGranted = $this->permission->hasPermission(['pages.create', 'pages.delete']);
        $this->assertEquals(false, $permissionGranted);

        $permissionGranted = $this->permission->hasPermission(['pages.create', 'pages.edit']);
        $this->assertEquals(true, $permissionGranted);
    }


    /**
     * Any permissions check for array of permissions
     *
     * @return void
     */
    public function testHasAnyPermissionArray()
    {

        $permissionGranted = $this->permission->hasAnyPermission(['pages.create', 'pages.delete']);
        $this->assertEquals(true, $permissionGranted);

        $permissionGranted = $this->permission->hasAnyPermission(['pages.create', 'pages.edit']);
        $this->assertEquals(true, $permissionGranted);
    }


    /**
     * Any permissions check for wildcard permissions
     *
     * @return void
     */
    public function testHasAnyWildcardPermissionArray()
    {

        $permissionGranted = $this->permission->hasPermission('groups.*');
        $this->assertEquals(true, $permissionGranted);

        $permissionGranted = $this->permission->hasAnyPermission('pages.*');
        $this->assertEquals(true, $permissionGranted);

        $permissionGranted = $this->permission->hasAnyPermission(['posts.*']);
        $this->assertEquals(true, $permissionGranted);

        $permissionGranted = $this->permission->hasAnyPermission(['posts.*', 'pages.*']);
        $this->assertEquals(true, $permissionGranted);
    }


    /**
     * Strict permissions check for array of permissions
     *
     * @return void
     */
    public function testHasOverridePermissions()
    {
        $permissionGranted = $this->permission->hasPermission('settings.edit');
        $this->assertEquals(true, $permissionGranted);
    }


    protected function createDummyPermissions($permissions = [])
    {
        return (object)[
            'permissions' => $permissions
        ];
    }

}
