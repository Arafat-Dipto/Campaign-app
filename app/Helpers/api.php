<?php

use App\Models\User;
use App\Models\OtpCode;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\NotificationController;

function statusCodes($code)
{
	// 800200 : Success
	// 800300 : Unprocessable Request / Validation Error
	// 800400 : Bad Request / Server Error / API error
	// 800500 : Unauthorized / Token Expired
	// 800600 : OTP expired
	$codes = [
		200 => 800200,
		422 => 800300,
		400 => 800400,
		404 => 800400,
		401 => 800500,
		402 => 800600,
	];

	return $codes[$code];
}

function errorResponse($data = null, $message = null, $code = 400)
{
	return response()->json([
		'statusCode' => statusCodes($code),
		'message'    => $message,
		'data'       => $data
	], $code);
}

function successResponse($data = null, $message = null, $code = 200)
{
	return response()->json([
		'statusCode' => statusCodes($code),
		'message'    => $message,
		'data'       => $data
	], $code);
}

function sendNotification($receiver, $medium = 'sms', $messageType = 'REGISTRATION_OTP', $data = [])
{
	// if ($medium == 'sms') {
	// 	$otp = OtpCode::create([
	// 		'phone_number' => $receiver,
	// 		'medium'       => $medium,
	// 	]);
	// } elseif ($medium == 'email') {
	// 	$otp = OtpCode::create([
	// 		'email'        => $receiver,
	// 		'medium'       => $medium,
	// 	]);
	// }

	// if (!$otp) {
	// 	return null;
	// }

	$notificationController = new NotificationController();

	$response = $notificationController->sendNotification($receiver, $medium, $messageType, $data);

	if ($response['status'] === true) {
		return $response;
	} else {
		return null;
	}
}

function sendOtpCode($receiver, $medium = 'sms', $messageType = 'REGISTRATION_OTP')
{
	if ($medium == 'sms') {
		$otp = OtpCode::create([
			'phone_number' => $receiver,
			'medium'       => $medium,
		]);
	} elseif ($medium == 'email') {
		$otp = OtpCode::create([
			'email'        => $receiver,
			'medium'       => $medium,
		]);
	}

	if (!$otp) {
		return null;
	}

	return [
		'token'      => $otp->token,
		'receiver'   => $receiver,
		'medium'     => $otp->medium,
		'expires_at' => (string) $otp->expired_at,
	];

	/*

	$notificationController = new NotificationController();

	$response = $notificationController->notify($otp, $medium, $messageType);

	$otp->response_data = $response['data'];
	$otp->update();

	if ($response['status'] === true) {
		return [
			'token'      => $otp->token,
			'receiver'   => $receiver,
			'medium'     => $otp->medium,
			'expires_at' => (string) $otp->expired_at,
		];
	} else {
		return null;
	}
	*/
}

function sendSms($data)
{
	// dd(env('SMS_GW_ENDPOINT'), env('SMS_GW_USER'), env('SMS_GW_PASS'), env('SMS_GW_SID'), $data);
	$response = Http::asJSON()->post(env('SMS_GW_ENDPOINT'), [
		'api_token' => env('SMS_GW_TOKEN'),
		'sid'       => env('SMS_GW_SID'),
		'msisdn'    => $data['msisdn'],
		'sms'       => $data['sms'],
		'csms_id'   => $data['csms_id'],
	]);

	if ($response->status() == 200) {
		$responseData = $response->json();
		return $responseData;
	} else {
		return null;
	}
}

function sendSmsV1($data)
{
	// dd(env('SMS_GW_ENDPOINT'), env('SMS_GW_USER'), env('SMS_GW_PASS'), env('SMS_GW_SID'), $data);
	$response = Http::asForm()->post(env('SMS_GW_ENDPOINT'), [
		'user' => env('SMS_GW_USER'),
		'pass' => env('SMS_GW_PASS'),
		'sid'  => env('SMS_GW_SID'),
		'sms'  => $data
	]);

	if ($response->status() == 200) {
		$xml   = simplexml_load_string($response->body());
		$json  = json_encode($xml);
		$array = json_decode($json, true);

		return $array;
	} else {
		return null;
	}
}

function sendSmsEzze($data)
{
	// dd(env('SMS_GW_ENDPOINT'), env('SMS_GW_USER'), env('SMS_GW_PASS'), env('SMS_GW_SID'));
	$formData = [
		'sender'  => env('SMS_GW_USER'),
		'secret'  => env('SMS_GW_PASS'),
		'number'  => $data['phone_number'],
		'message' => $data['message']
	];
	// dump($formData);
	$response = Http::asJSON()->post(env('SMS_GW_ENDPOINT'), $formData);

	if ($response->status() == 200) {
		return $response->json();
	} else {
		return null;
	}
}

function sendEmail($data, $template = 'emails.otp_code', $subject = 'BHN OTP (One Time Password)')
{
	$response = Mail::send($template, $data, function ($message) use ($data, $subject) {
		$message->from('support@buyherenow.com.bd', env('MAIL_FROM_NAME', 'BHN'));
		$message->to($data['email']);
		$message->subject($subject);
	});

	return $response;
}

function formatUserResponse($user)
{
	$user = User::whereId($user->id)
		->first();
	return [
		'id'                   => $user->id,
		'name'                 => $user->name,
		'phone_number'         => $user->phone_number,
		'email'                => $user->email,
		'profile_picture'      => $user->photoUrl(),
		'registered_at'        => $user->created_at->toDateTimeString()
	];
}

function getStorageUrl($path)
{
	if (filter_var($path, FILTER_VALIDATE_URL) === false) {
		if (is_null($path)) {
			return null;
		} else {
			return Storage::url($path);
		}
	} else {
		return $path;
	}
}

function getPublicUrl($path)
{
	if (filter_var($path, FILTER_VALIDATE_URL) === false) {
		if (is_null($path)) {
			return null;
		} else {
			return asset('storage/' . $path);
		}
	} else {
		return $path;
	}
}
 