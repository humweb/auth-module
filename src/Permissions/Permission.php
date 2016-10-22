<?php

namespace Humweb\Auth\Permissions;

use Illuminate\Database\Eloquent\Collection;

/**
 * Permission.
 */
class Permission
{
    protected $mergedPermissions    = [];
    protected $allocatedPermissions = [];


    /**
     * Permission constructor.
     *
     * @param array      $entities
     * @param array|null $overrideEntities
     */
    public function __construct($entities = [], $overrideEntities = null)
    {
        $this->cachePermissions($entities);

        if ($overrideEntities) {
            $this->cachePermissions($overrideEntities, true);
        }
    }


    protected function cachePermissions($entities, $override = false)
    {
        if ( ! is_array($entities) && ! ($entities instanceof Collection)) {
            $entities = [$entities];
        }

        foreach ($entities as $entity) {
            // Skip if group has no permissions
            if ( ! $this->entityHasPermissions($entity)) {
                continue;
            }

            // Loop through group permissions
            foreach ($entity->permissions as $perm => $status) {
                // Skip if we already have permissions granted (true)
                if (isset($this->allocatedPermissions[$perm]) && $override == false) {
                    continue;
                }

                // Cache permissions bool value
                $this->mergedPermissions[$perm] = $status;

                if ($this->isTrue($status) && ! in_array($perm, $this->allocatedPermissions)) {
                    $this->allocatedPermissions[] = $perm;
                } elseif ($override && ! $this->isTrue($status) && ($this->isTrue($index = array_search($perm, $this->allocatedPermissions)))) {
                    unset($this->allocatedPermissions[$index]);
                }
            }
        }
    }


    /**
     * Create Permission instance from permissible entities.
     *
     * @param      $entities
     * @param null $overrideEntities
     *
     * @return Permission
     */
    public static function fromPermissible($entities, $overrideEntities = null)
    {
        return new static($entities, $overrideEntities);
    }


    /**
     * Check permissions.
     *
     * @param string|array $perm
     * @param bool         $strictCheck
     *
     * @return bool
     */
    public function hasPermission($perm, $strictCheck = true)
    {
        if (is_array($perm)) {
            foreach ($perm as $p) {
                $hasPermission = $this->hasMatchingPermission($p);

                if ($strictCheck === true && $hasPermission === false) {
                    return false;
                } elseif ($strictCheck === false && $hasPermission === true) {
                    return true;
                }
            }

            if ($strictCheck === false) {
                return false;
            }

            return true;
        }

        return $this->hasMatchingPermission($perm);
    }


    /**
     * Check Permissions (non-strict).
     *
     * @param $perm
     *
     * @return bool
     */
    public function hasAnyPermission($perm)
    {
        return $this->hasPermission($perm, false);
    }


    /**
     * Get merged permissions.
     *
     * @return array
     */
    public function getMergedPermissions()
    {
        return $this->mergedPermissions;
    }


    /**
     * Get allocated permissions (permissions granted).
     *
     * @return array
     */
    public function getAllocatedPermissions()
    {
        return $this->allocatedPermissions;
    }


    /**
     * Match wildcard permissions.
     *
     * @param $permission
     *
     * @return bool
     */
    protected function matchWildcardPermission($permission)
    {
        foreach ($this->allocatedPermissions as $mergedPermission) {
            if (str_is($permission, $mergedPermission)) {
                return true;
            }
        }

        return false;
    }


    /**
     * Check if entity has any permissions property.
     *
     * @param $entity
     *
     * @return bool
     */
    protected function entityHasPermissions($entity)
    {
        return isset($entity->permissions) && is_array($entity->permissions);
    }


    /**
     * Check if processed and true.
     *
     * @param $perm
     *
     * @return bool
     */
    protected function isCachedAndTrue($perm)
    {
        return isset($this->mergedPermissions[$perm]) && $this->isTrue($this->mergedPermissions[$perm]);
    }


    /**
     * Check if processed and false.
     *
     * @param $perm
     *
     * @return bool
     */
    protected function isCachedAndFalse($perm)
    {
        return isset($this->mergedPermissions[$perm]) && ! $this->isTrue($this->mergedPermissions[$perm]);
    }


    /**
     * Internal boolean check.
     *
     * @param $val
     *
     * @return bool
     */
    protected function isTrue($val)
    {
        if ($val === 1 || $val === '1' || $val === true || $val === 'true') {
            return true;
        }

        return false;
    }


    /**
     * Check for matching permissions.
     *
     * @param $p
     *
     * @return bool
     */
    protected function hasMatchingPermission($p)
    {
        if (ends_with($p, '*')) {
            $hasPermission = $this->matchWildcardPermission($p);

            return $hasPermission;
        } else {
            $hasPermission = in_array($p, $this->allocatedPermissions);

            return $hasPermission;
        }
    }
}
