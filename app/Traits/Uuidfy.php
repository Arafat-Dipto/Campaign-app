<?php

namespace App\Traits;

use Webpatser\Uuid\Uuid;

trait Uuidfy
{
	abstract public function Uuidfy(): array;

	public static function bootUuidfy()
	{
		static::creating(function ($model) {
			$settings = $model->Uuidfy($model);
			$uuidColumn = $settings['uuidColumn'];
			$currentValue = $model->{$uuidColumn};

			if (empty($currentValue)) {
				$currentValue = Uuid::generate(4)->string;
			}

			$model->uid = $currentValue;
		});
	}
}
