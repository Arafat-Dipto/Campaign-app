<?php

namespace App\Models;

use Shanmuga\LaravelEntrust\Models\EntrustRole;

class Role extends EntrustRole
{
	protected $fillable = ['name', 'display_name', 'description'];

	public function scopeFilter($query, array $filters)
	{
		$query->when($filters['search'] ?? null, function ($query, $search) {
			$query->where(function ($query) use ($search) {
				$query->where('name', 'like', '%' . $search . '%')
					->orWhere('display_name', 'like', '%' . $search . '%');
			});
		});
	}
}
