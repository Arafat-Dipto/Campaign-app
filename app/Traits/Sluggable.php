<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait Sluggable
{
	abstract public function sluggable(): array;

	public static function bootSluggable()
	{
		static::creating(function ($model) {
			$settings = $model->sluggable($model);
			$source = $model->{$settings['sourceColumn']};
			$slugColumn = $settings['slugColumn'];
			$currentSlug = $model->{$slugColumn};

			if (empty($currentSlug)) {
				$slug = $model->createSlug($source, $slugColumn);
			} else {
				$slug = $currentSlug;
			}

			$model->{$slugColumn} = $slug;
		});

		static::updating(function ($model) {
			$settings = $model->sluggable($model);
			$source = $model->{$settings['sourceColumn']};
			$slugColumn = $settings['slugColumn'];

			$model->{$slugColumn} = $model->createSlug($source, $slugColumn, $model->id);
		});
	}

	public function createSlug($title, $slugColumn = 'slug', $id = 0)
	{
		$slug     = Str::slug($title);
		$allSlugs = $this->getRelatedSlugs($slug, $id, $slugColumn);
		if (!$allSlugs->contains($slugColumn, $slug)) {
			return $slug;
		}

		$i          = 1;
		$is_contain = true;
		do {
			$newSlug = $slug . '-' . $i;
			if (!$allSlugs->contains($slugColumn, $newSlug)) {
				$is_contain = false;
				return $newSlug;
			}
			$i++;
		} while ($is_contain);
	}

	protected function getRelatedSlugs($slug, $id = 0, $slugColumn = 'slug')
	{
		return static::withoutGlobalScope('currentOrganization')->select($slugColumn)->where($slugColumn, 'like', $slug . '%')
			->where('id', '<>', $id)
			->get();
	}
}
