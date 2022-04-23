<?php

namespace App\Http\Controllers\API;

use App\Models\Campaign;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;


class ApiController extends Controller
{
	public function createCampaign(Request $request)
	{
		$inputs = $this->validate(request(), [
			'name'              => ['required', 'string', Rule::unique('campaigns', 'name')],
			'total_budget'       => ['required'],
			'daily_budget'       => ['required'],
			'start_date'         => ['required','date_format:Y-m-d'],
			'end_date'           => ['required','date_format:Y-m-d'],
			'images'             => ['nullable','image'],
		]);

		$item = Campaign::create([
			'name'            => $inputs['name'],
			'total_budget'    => $inputs['total_budget'],
			'daily_budget'    => $inputs['daily_budget'],
			'start_date'      => $inputs['start_date'],
			'end_date'        => $inputs['end_date'],
			
		]);

		if (request()->file('images')) {
			$oldFile = $item->images;
			$item->update([
				'images' => request()->file('images')->store(strtolower('campaigns'))
			]);
			if (Storage::exists($oldFile)) {
				Storage::delete($oldFile);
			}
		}
		// $item = formatCampaignResponse($item);
		return successResponse($item);
	}

	public function getAllCampaign(){
		$data = Campaign::orderBy('order_index', 'DESC')->get()
		->transform(function ($item) {
			return [
			'id'            => $item->id,
			'name'          => $item->name,
			'total_budget'  => $item->total_budget,
			'daily_budget'  => $item->daily_budget,
			'start_date'    => $item->start_date->format('d-m-Y'),
			'end_date'      => $item->end_date->format('d-m-Y'),
			'images'        => getPublicUrl($item->images),
			];
		});
		return successResponse($data);
	}
	
}
