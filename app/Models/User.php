<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Log;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Usermeta;
use Illuminate\Support\Str;
 

/**
 * Class User
 * 
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $phone
 * @property string|null $dob
 * @property string|null $type
 * @property string|null $profile_pic
 * @property Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|DownloadPlan[] $download_plans
 * @property Collection|FavouritePlan[] $favourite_plans
 * @property Collection|Plan[] $plans
 *
 * @package App\Models
 */
class User extends Authenticatable
{
	use HasApiTokens, HasFactory, Notifiable;
	protected $table = 'users';

	public static function boot() { 
		parent::boot();
	
		static::created(function ($model) { 
			$model->createUsermetaReferralCode();
			$model->createUsermetaDownloadAvail();
		});
	}

	protected function createUsermetaReferralCode(){
		
		do{
			$rcode = Str::random(6);  	
		}while(Usermeta::where('meta_value', '=', $rcode)->where('meta_key',"=","referral_code")->first()); 
		
		if($rcode){ 
			$Referral = new Usermeta();
			$Referral->user_id = $this->id;
			$Referral->meta_key = "referral_code";
			$Referral->meta_value = Str::upper($rcode);
			$Referral->save();
		}
		
	}

	protected function createUsermetaDownloadAvail(){
		
		$Referral = new Usermeta();
		$Referral->user_id = $this->id;
		$Referral->meta_key = "download_avail";
		$Referral->meta_value = 3;
		$Referral->save();
		
	}

	protected $dates = [
		'email_verified_at'
	];

	protected $hidden = [
		'password',
		'remember_token'
	];

	protected $fillable = [
		'name',
		'email',
		'phone',
		'dob',
		'type',
		'profile_pic',
		'email_verified_at',
		'password',
		'remember_token',
		'uid',
		'provider',
		'device_token',
		'country_code'
	];

	public function download_plans()
	{
		return $this->hasMany(DownloadPlan::class);
	}

	public function favourite_plans()
	{
		return $this->hasMany(FavouritePlan::class);
	}

	public function plans()
	{
		return $this->hasMany(Plan::class);
	}

	public function usermetas()
	{
		return $this->hasMany(Usermeta::class);
	}
}
