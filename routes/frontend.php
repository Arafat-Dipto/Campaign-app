<?php

use Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'Frontend', 'middleware' => 'auth'], function ($router) {
	// Auth
});

Route::group(['namespace' => 'Frontend'], function ($router) {
	// Campaigns
	Route::get('/')->name('frontend.campaigns')->uses('CampaignController@index');
	Route::get('campaigns/create')->name('frontend.campaigns.create')->uses('CampaignController@create');
	Route::post('campaigns')->name('frontend.campaigns.store')->uses('CampaignController@store');
	Route::get('campaigns/{item}/edit')->name('frontend.campaigns.edit')->uses('CampaignController@edit');
	Route::put('campaigns/{item}')->name('frontend.campaigns.update')->uses('CampaignController@update');
	Route::delete('campaigns/{item}')->name('frontend.campaigns.destroy')->uses('CampaignController@destroy');
});
