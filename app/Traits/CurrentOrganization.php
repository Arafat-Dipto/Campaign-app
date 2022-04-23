<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait CurrentOrganization
{
	public static function bootCurrentOrganization()
	{
		// Current Organization as Global Scope
		static::addGlobalScope('currentOrganization', function (Builder $builder) {
			$orgId = getCurrentOrganization(true);
			if (!is_null($orgId)) {
				$builder->where('organization_id', $orgId);
			}
		});

		static::creating(function ($model) {
			// Organization Adding while creating
			$orgId = getCurrentOrganization(true);
			if (empty($model->organization_id) && !is_null($orgId)) {
				$model->organization_id = $orgId;
			}
		});
	}

	public function scopeCurrentOrganization($query)
	{
		$orgId = getCurrentOrganization(true);
		if (!is_null($orgId)) {
			return null;
		}

		return $query->where('organization_id', $orgId);
	}
}
