<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Plan
 * 
 * @property int $id
 * @property int $user_id
 * @property string|null $name
 * @property string|null $description
 * @property string|null $image
 * @property string|null $ext
 * @property string|null $bath
 * @property string|null $bedroom
 * @property string|null $kitchen
 * @property string|null $toilets
 * @property string|null $living_room
 * @property string|null $verandah
 * @property string|null $store
 * @property string|null $story
 * @property string|null $sqm
 * @property string|null $length
 * @property string|null $width
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property User $user
 * @property Collection|DownloadPlan[] $download_plans
 * @property Collection|FavouritePlan[] $favourite_plans
 * @property Collection|PlanInfo[] $plan_infos
 *
 * @package App\Models
 */
class Plan extends Model
{
	protected $table = 'plans';

	protected $casts = [
		'user_id' => 'int'
	];

	protected $fillable = [
		'user_id',
		'name',
		'description',
		'image',
		'ext',
		'bath',
		'bedroom',
		'kitchen',
		'toilets',
		'living_room',
		'verandah',
		'store',
		'story',
		'sqm',
		'length',
		'width',
        'drawing_list',
		'status'

	];

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function download_plans()
	{
		return $this->hasMany(DownloadPlan::class);
	}

	public function favourite_plans()
	{
		return $this->hasMany(FavouritePlan::class);
	}

	public function plan_infos()
	{
		return $this->hasMany(PlanInfo::class);
	}
}
