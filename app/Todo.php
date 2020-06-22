<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    /**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'title',
		'description',
	];

	/**
	 * The attributes that should be visible in arrays.
	 *
	 * @var array
	 */
	protected $visible = [
		'id',
		'title',
		'description',
	];

	/**
	 * Get the user this todo belongs to
	 */
	public function user()
	{
		return $this->belongsTo('App\User');
	}
}
