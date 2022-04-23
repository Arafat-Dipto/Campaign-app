<?php

use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Session;

function phoneNumberFormat($returnAsString = true)
{
	if ($returnAsString === true) {
		return "numeric|min:11,max:11|regex:/^01[3-9]\d{8}$/";
	} else {
		return ['numeric', 'regex:/^01[3-9]\d{8}$/'];
	}
}

function formatBdtPriceDecimal($amount): string
{
	list($number, $decimal) = explode('.', sprintf('%.2f', floatval($amount)));
	$sign                   = $number < 0 ? '-' : '';
	$number                 = abs($number);
	for ($i = 3; $i < strlen($number); $i += 3) {
		$number = substr_replace($number, ',', -$i, 0);
	}
	return $sign . $number . '.' . $decimal;
	// return $sign . $number;
}

function dateFormat($value)
{
	return Carbon::parse($value)->format('F j, Y, g:i a');
}

function formatTime($value)
{
	return  Carbon::parse($value)->format('g:i A');
}

function sharedFrontendData()
{
	return [
		'flash' => function () {
			return [
				'success' => Session::get('success'),
				'error'   => Session::get('error'),
				'data'    => Session::get('data'),
			];
		},
		'errors' => function () {
			return Session::get('errors')
				? Session::get('errors')->getBag('default')->getMessages()
				: (object) [];
		},
	];
}

function dateFormatForFooter($inputDate)
{
	$dt = Carbon::create($inputDate);
	return $dt->toFormattedDateString();
}

function make_slug($string)
{
	if (preg_match('/[^\x20-\x7e]/', $string)) {
		return preg_replace('/\s+/u', '-', trim($string)); // for unicode bangla
	} else {
		return  Str::slug($string);
	}
}
