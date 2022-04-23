<?php

namespace App\Providers;

use League\Glide\Server;
use Carbon\CarbonImmutable;
use Illuminate\Support\Collection;
use Illuminate\Pagination\UrlWindow;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Http\Resources\Json\JsonResource;

class InertiaServiceProvider extends ServiceProvider
{
	public function boot()
	{
		Date::use(CarbonImmutable::class);
		JsonResource::withoutWrapping();
	}

	public function register()
	{
		// $this->registerInertia();
		$this->registerGlide();
		$this->registerLengthAwarePaginator();
	}

	protected function registerGlide()
	{
		$this->app->bind(Server::class, function ($app) {
			return Server::create([
				'source'       => Storage::getDriver(),
				'cache'        => Storage::getDriver(),
				'cache_folder' => '.glide-cache',
				'base_url'     => 'img',
			]);
		});
	}

	protected function registerLengthAwarePaginator()
	{
		$this->app->bind(LengthAwarePaginator::class, function ($app, $values) {
			return new class(...array_values($values)) extends LengthAwarePaginator {
				public function only(...$attributes)
				{
					return $this->transform(function ($item) use ($attributes) {
						return $item->only($attributes);
					});
				}

				public function transform($callback)
				{
					$this->items->transform($callback);

					return $this;
				}

				public function toArray()
				{
					return [
						'data'              => $this->items->toArray(),
						'links'             => $this->links(),
						'total'             => $this->total(),
						// 'current_page'      => $this->currentPage(),
						// 'per_page'          => $this->perPage(),
						// 'count'             => $this->count(),
						'from'              => $this->firstItem(),
						'to'                => $this->lastItem(),
						'prev_url'          => $this->previousPageUrl(),
						'next_url'          => $this->nextPageUrl(),
					];
				}

				public function links($view = null, $data = [])
				{
					$this->appends(Request::all());

					$window = UrlWindow::make($this);

					$elements = array_filter([
						$window['first'],
						is_array($window['slider']) ? '...' : null,
						$window['slider'],
						is_array($window['last']) ? '...' : null,
						$window['last'],
					]);

					return Collection::make($elements)->flatMap(function ($item) {
						if (is_array($item)) {
							return Collection::make($item)->map(function ($url, $page) {
								return [
									'url'    => $url,
									'label'  => $page,
									'active' => $this->currentPage() === $page,
								];
							});
						} else {
							return [
								[
									'url'    => null,
									'label'  => '...',
									'active' => false,
								],
							];
						}
					})->prepend([
						'url'    => $this->previousPageUrl(),
						'label'  => 'Previous',
						'active' => false,
					])->push([
						'url'    => $this->nextPageUrl(),
						'label'  => 'Next',
						'active' => false,
					]);
				}
			};
		});
	}
}
