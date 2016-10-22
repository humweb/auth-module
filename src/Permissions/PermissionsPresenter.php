<?php

namespace Humweb\Auth\Permissions;

use Humweb\Modules\Module;
use Illuminate\Config\Repository as ConfigContract;

/**
 * Class PermissionsPresenter.
 */
class PermissionsPresenter
{
    /**
     * @var Config
     */
    protected $config;

    /**
     * @var array
     */
    protected $permissions = [];
    /**
     * @var Module
     */
    protected $module;


    /**
     * PermissionsPresenter constructor.
     */
    public function __construct(ConfigContract $config, Module $module)
    {
        $this->config = $config;
        $this->module = app()->make('modules');
    }


    /**
     * Get Permissions.
     *
     * @param null $key
     *
     * @return array|mixed
     */
    public function getPermissions($key = null)
    {
        $key = is_null($key) ? '' : '.'.trim($key, '.');

        if (empty($this->permissions)) {
            $this->permissions = $this->module->getAvailablePermissions();
        }

        return $this->permissions;
    }


    /**
     * Set Permissions.
     *
     * @param       $perm
     * @param array $meta
     *
     * @return $this
     */
    public function setPermission($perm, $meta = [])
    {
        $this->permissions[$perm] = $meta;

        return $this;
    }
}
