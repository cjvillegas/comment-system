<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PostComment extends Model
{
    use SoftDeletes;

    /**
     * Specify attribute here if you want it to not be mass 
     * assinable. By default all attributes are mass assinable.
     *
     * @var <array>
     */
    protected $guarded = [];

    /**
	 * Appends the show_reply column in every model retrieval
     */
    protected $appends = ['show_reply'];

    /**
	 * Retrieve comments' children
	 *
	 * @return HasMany
     */
    public function children()
    {
    	return $this->hasMany(self::class, 'parent_id', 'id');
    }

    /**
	 * Custom accessor column show_reply. This will be used to check if to show the comment form
	 * 
	 * @return <boolean>
     */
    public function getShowReplyAttribute()
    {
        return false;
    }
}
