<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Campaign;
use Inertia\Inertia;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Redirect;

class CampaignController extends Controller
{
	protected $modelDisplayName = 'Campaigns';
	protected $modelName        = 'Campaign';
	protected $modelNamePlural  = 'Campaigns';
	protected $routeName        = 'frontend.campaigns';
	protected $tableName        = 'campaigns';
	protected $model;

	public function __construct(Campaign $model)
	{
		$this->model = $model;
	}

	public function recursiveTransform($item)
	{
		return [
			'id'            => $item->id,
			'name'          => $item->name,
			'total_budget'  => $item->total_budget,
			'daily_budget'  => $item->daily_budget,
			'start_date'    => $item->start_date->format('d-m-Y'),
			'end_date'      => $item->end_date->format('d-m-Y'),
			'images'        => getPublicUrl($item->images),
			'order_index'   => $item->order_index,
		];
	}

	public function index()
	{
		$items = [
			'filters' => Request::all('search'),
			'items'   => $this->model
				->orderBy('order_index', 'ASC')
				->filter(Request::only('search'))
				->paginate()
				->transform(function ($item) {
					return $this->recursiveTransform($item);
				}),
			'modelName'        => $this->modelName,
			'modelNamePlural'  => $this->modelNamePlural,
			'routeName'        => $this->routeName,
			'modelDisplayName' => $this->modelDisplayName,
		];

		// return $items;
		return Inertia::render($this->modelNamePlural . '/Index', $items);
	}

	public function create()
	{
		return Inertia::render($this->modelNamePlural . '/Create', [
			'modelName'        => $this->modelName,
			'modelNamePlural'  => $this->modelNamePlural,
			'routeName'        => $this->routeName,
			'modelDisplayName' => $this->modelDisplayName,
			'formToken' => csrf_token(),
		]);
	}

	public function store()
	{
		// dd(Request::all());
		Request::validate([
			'name'              => ['required', 'string', Rule::unique($this->tableName, 'name')],
			'total_budget'       => ['required'],
			'daily_budget'       => ['required'],
			'start_date'         => ['required'],
			'end_date'           => ['required'],
			'images'             => ['nullable'],
			'order_index'        => ['nullable', 'numeric'],
			
		]);

		$item = $this->model->create([
			'name'             => Request::get('name'),
			'total_budget'     => Request::get('total_budget'),
			'daily_budget'     => Request::get('daily_budget'),
			'start_date'       => Request::get('start_date'),
			'end_date'         => Request::get('end_date'),
			'order_index'      => Request::get('order_index'),
			]);

		if (Request::file('images')) {
					$item->update([
						'images' => Request::file('images')
						->store(strtolower($this->modelNamePlural))
					]);
				}
		

		return Redirect::route($this->routeName)->with('success', 'Item created.');
	}

	public function edit(Campaign $item)
	{
		return Inertia::render($this->modelNamePlural . '/Edit', [
			'item' => [
				'id'                   => $item->id,
				'name'                 => $item->name,
				'images'              => getPublicUrl($item->images),
				'total_budget'         => $item->total_budget,
				'daily_budget'         => $item->daily_budget,
				'start_date'           => $item->start_date,
				'end_date'             => $item->end_date,
				'order_index'          => $item->order_index,
				
			],
			'modelName'        => $this->modelName,
			'modelNamePlural'  => $this->modelNamePlural,
			'routeName'        => $this->routeName,
			'modelDisplayName' => $this->modelDisplayName,
			'formToken'        => csrf_token(),
		]);
	}

	public function update(Campaign $item)
	{
		Request::validate([
			'name'              => ['nullable', 'string', Rule::unique($this->tableName, 'name')],
			'total_budget'       => ['nullable'],
			'daily_budget'       => ['nullable'],
			'start_date'         => ['nullable'],
			'end_date'           => ['nullable'],
			'images'             => ['nullable'],
			'order_index'        => ['nullable', 'numeric'],
			
		]);

		$item->update([
			'name'             => Request::get('name'),
			'total_budget'     => Request::get('total_budget'),
			'daily_budget'     => Request::get('daily_budget'),
			'start_date'       => Request::get('start_date'),
			'end_date'         => Request::get('end_date'),
			'order_index'      => Request::get('order_index'),
		]);

		if (Request::file('images')) {
			$oldFile = $item->images;
			$item->update([
				'images' => Request::file('images')->store(strtolower($this->modelNamePlural))
			]);
			if (Storage::exists($oldFile)) {
				Storage::delete($oldFile);
			}
		}

		
		return Redirect::back()->with('success', 'Item updated.');
	}

	public function destroy(Campaign $item)
	{
		$oldFile = $item->images;

		if (Storage::exists($oldFile)) {
			Storage::delete($oldFile);
		}
		$item->delete();
		return Redirect::route($this->routeName)->with('success', 'Item deleted.');
	}
}
