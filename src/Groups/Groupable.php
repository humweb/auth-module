<?php

namespace Humweb\Auth\Groups;

/**
 * Groupable Trait
 *
 */
trait Groupable
{
    /**
     * Returns the relationship between users and groups.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function groups()
    {
        return $this->belongsToMany('Humweb\Auth\Groups\Group', 'user_groups');
    }
}
