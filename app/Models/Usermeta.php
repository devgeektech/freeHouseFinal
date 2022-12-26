<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usermeta extends Model
{
    use HasFactory;
	protected $table = 'user_meta';

    protected $casts = [
		'user_id' => 'int'
	];

    protected $fillable = [
		'user_id',
		'meta_key',
		'meta_value'
	];

    public function user()
	{
		return $this->belongsTo(User::class);
	}

}
