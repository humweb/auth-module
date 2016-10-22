<?php

namespace Humweb\Auth\Permissions;

use Humweb\Auth\Groups\Contracts\Groupable;

/**
 * Class Permissible.
 */
trait Permissible
{
    protected $permission;


    /**
     * Get permission instance.
     *
     * @return Permission
     */
    public function getPermission()
    {
        if ( ! $this->permission) {
            // We need to override group permissions with this instance permissions
            if ($this instanceof Groupable) {
                $this->permission = Permission::fromPermissible($this->groups()->get(), $this);
            } else {
                $this->permission = Permission::fromPermissible($this);
            }
        }

        return $this->permission;
    }


    /**
     * Get Permissions.
     *
     * @return array
     */
    public function getPermissions()
    {
        return $this->getPermissionsAttribute($this->permissions);
    }


    /**
     * Mutator for decoding permissions from database.
     *
     * @param mixed $permissions
     *
     * @return array
     *
     * @throws InvalidArgumentException
     */
    public function getPermissionsAttribute($permissions)
    {
        if (is_array($permissions)) {
            return $permissions;
        }

        if ( ! $permissions || ( ! $_permissions = json_decode($permissions, true))) {
            return [];
        }

        return $_permissions;
    }


    /**
     * Mutator precessing and encoding permissions before they are inserted to the database.
     *
     * @param array $permissions
     *
     * @throws InvalidArgumentException
     */
    public function setPermissionsAttribute(array $permissions)
    {
        // Merge permissions
        $permissions = array_merge($this->permissions, $permissions);

        // Loop through and adjust permissions as needed
        foreach ($permissions as $permission => $val) {
            // Remove permissions
            if ($val === 0 || $val === '0' || $val === false || $val === 'false') {
                unset($permissions[$permission]);
            } else {
                $permissions[$permission] = 1;
            }
        }

        $this->attributes['permissions'] = ( ! empty($permissions)) ? json_encode($permissions) : '';
    }
}
