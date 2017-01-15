<?php

namespace Humweb\Auth\Groups;

use Humweb\Auth\Contracts\Permissible as PermissibleContract;
use Humweb\Auth\Permissions\Permissible;
use Illuminate\Database\Eloquent\Model;

/**
 * Group.
 */
class Group extends Model implements PermissibleContract
{
    use Permissible;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'groups';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'slug', 'permissions'];


    /**
     * Delete the group.
     *
     * @return bool
     */
    public function delete()
    {
        $this->users()->detach();

        return parent::delete();
    }


    /**
     * Returns the relationship between groups and users.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany('Humweb\Auth\Users\User', 'user_groups');
    }
}
