<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PlanInfo
 * 
 * @property int $id
 * @property int $plan_id
 * @property string|null $gallery_images
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Plan $plan
 *
 * @package App\Models
 */
class PlanInfo extends Model
{
	protected $table = 'plan_infos';

	protected $casts = [
		'plan_id' => 'int'
	];

	protected $fillable = [
		'plan_id',
		'gallery_images'
	];

	public function plan()
	{
		return $this->belongsTo(Plan::class);
	}
}
