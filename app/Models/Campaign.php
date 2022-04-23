<?php

namespace App\Models;


use League\Glide\Server;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\URL;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Campaign extends Model
{
	// use HasFactory, Sluggable, Uuidfy;
	use HasFactory;


	

	/**
	 * The attributes that should be cast to native types.
	 *
	 * @var array
	 */
	protected $casts = [
		'start_date' => 'datetime',
		'end_date' => 'datetime',
	];

	public function scopeFilter($query, array $filters)
	{
		$query->when($filters['search'] ?? null, function ($query, $search) {
			$query->where('name', 'like', '%' . $search . '%');
		})->when($filters['trashed'] ?? null, function ($query, $trashed) {
			if ($trashed === 'with') {
				$query->withTrashed();
			} elseif ($trashed === 'only') {
				$query->onlyTrashed();
			}
		});
	}

	public function imageUrl(array $attributes = [])
	{
		if ($this->images) {
			return URL::to(App::make(Server::class)->fromPath($this->images, $attributes));
		}
	}

	

	
}
