<?php

use Illuminate\Support\Facades\Cache;

function getPublicUrlById($attachment_id)
{
	$attachment = Attachment::where('id', $attachment_id)->first();
	if (!$attachment) {
		return null;
	}
	return getPublicUrl($attachment->path);
}

/**
 * Transform the resource collection into an array.
 *
 * @param string $key
 * @param callback $callback
 * @param bool $cachedEnabled
 * @param int $ttl
 * @return mixed
**/
function getFrontendCachedData($key, $callback, $cachedEnabled = true, $ttl = 60 * 30)
{
	if ($cachedEnabled === false) {
		return $callback();
	}
	$cacheValue = Cache::remember($key, $ttl, $callback);
	return $cacheValue;
}
