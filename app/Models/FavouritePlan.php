<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class FavouritePlan
 * 
 * @property int $id
 * @property int $user_id
 * @property int $plan_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Plan $plan
 * @property User $user
 *
 * @package App\Models
 */
class FavouritePlan extends Model
{
	protected $table = 'favourite_plans';

	protected $casts = [
		'user_id' => 'int',
		'plan_id' => 'int'
	];

	protected $fillable = [
		'user_id',
		'plan_id'
	];

	public function plan()
	{
		return $this->belongsTo(Plan::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class);
	}
}
