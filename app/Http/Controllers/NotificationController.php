<?php

namespace App\Http\Controllers;

class NotificationController extends Controller
{
	// private $otpCodeModel;

	public function __construct()
	{
		// $this->middleware('auth:api');
		// $this->otpCodeModel = $otpCodeModel;
	}

	public function sendNotification($receiver, $medium = 'sms', $messageType = null, $data = [])
	{
		$smsData = [];
		$params  = [];

		switch ($messageType) {
			case 'ORDER_PLACED':
					$params['orderId']   = $data['orderId'];
					break;
			default:
				break;
		}

		if ($medium == 'sms') {
			$smsData = [
				'msisdn'  => "88{$receiver}",
				'sms'     => $this->messageContents($messageType, $params),
				'csms_id' => "MSG_{$receiver}_" . mt_rand(1000, 9999)
			];

			// dd($smsData);

			$response = sendSms($smsData);

			//

			if ($response && $response['status_code'] == '200' && $response['status'] == 'SUCCESS') {
				return [
					'status' => true,
					'data'   => $response
				];
			} else {
				return [
					'status' => false,
					'data'   => $response
				];
			}
		} elseif ($medium == 'email') {
			$emailData = [
				'email'    => $receiver,
				'otp_code' => $data['orderId'],
				'activity' => $this->emailMessageTypes($messageType),
				'validity' => '15',
			];

			$response = sendEmail($emailData);

			return [
				'status' => true,
				'data'   => $response
			];
		}

		return [
			'status' => false,
			'data'   => []
		];
	}

	public function notify($otpCode, $medium = 'sms', $messageType = null)
	{
		$smsData = [];
		$params  = [];

		switch ($messageType) {
			case 'LOGIN_OTP':
				$params['otpCode']   = $otpCode->otp_code;
				$params['regardsBy'] = 'Mavengers';
				break;
			case 'REGISTRATION_OTP':
				$params['otpCode']   = $otpCode->otp_code;
				$params['regardsBy'] = 'Mavengers';
				break;
			case 'RESET_PASSWORD_OTP':
				$params['otpCode']   = $otpCode->otp_code;
				$params['regardsBy'] = 'Mavengers';
				break;
			case 'ORDER_PLACED':
					$params['orderId']   = $otpCode->otp_code;
					$params['regardsBy'] = 'Mavengers';
					break;
			default:
				break;
		}

		if ($medium == 'sms') {
			/* For Ezze SMS Gateway */

			/*
			$smsData = [
				'phone_number' => "{$otpCode->phone_number}",
				'message'      => $this->messageContents($messageType, $params),
			];

			$response = sendSmsEzze($smsData);

			if ($response && $response['status'] == 'SUCCESS' && $response['code'] == '200') {
				return [
					'status' => true,
					'data'   => $response
				];
			} else {
				return [
					'status' => false,
					'data'   => $response
				];
			}
			*/

			$smsData = [
				'msisdn'  => "88{$otpCode->phone_number}",
				'sms'     => $this->messageContents($messageType, $params),
				'csms_id' => "OTP_{$otpCode->id}"
			];

			// dd($smsData);

			$response = sendSms($smsData);

			//

			if ($response && $response['status_code'] == '200' && $response['status'] == 'SUCCESS') {
				return [
					'status' => true,
					'data'   => $response
				];
			} else {
				return [
					'status' => false,
					'data'   => $response
				];
			}
		} elseif ($medium == 'email') {
			$emailData = [
				'email'    => $otpCode->email,
				'otp_code' => $otpCode->otp_code,
				'activity' => $this->emailMessageTypes($messageType),
				'validity' => '15',
			];

			$response = sendEmail($emailData);

			return [
				'status' => true,
				'data'   => $response
			];
		}

		return [
			'status' => false,
			'data'   => []
		];
	}

	public function emailMessageTypes($messageType)
	{
		$message = null;
		switch ($messageType) {
			case 'LOGIN_OTP':
				$message = 'Login';
				break;
			case 'REGISTRATION_OTP':
				$message = 'Registration';
				break;
			case 'RESET_PASSWORD_OTP':
				$message = 'Login';
				break;
			default:
				break;
		}

		return $message;
	}

	public function messageContents($messageType, $params = [])
	{
		$message = null;
		switch ($messageType) {
			case 'LOGIN_OTP':
				// $message = "Dear visitor, your OTP code is {$params['otpCode']} for login. Please do not share this PIN with anyone.";
				$message = "Dear Participant, Your Login OTP code is {$params['otpCode']}, Please keep this information private.";
				break;
			case 'REGISTRATION_OTP':
				// $message = "Dear visitor, your OTP code is {$params['otpCode']} for registration. Please do not share this PIN with anyone.";
				// $message = "Dear Participant, Your Registration OTP code is {$params['otpCode']}, Please keep this information private.";
				$message = "One step away from setting up your account.\nTo complete sign up process, please enter this verification code:\n{$params['otpCode']}";
				break;
			case 'RESET_PASSWORD_OTP':
				// $message = "Dear visitor, your OTP code is {$params['otpCode']} for password reset. Please do not share this PIN with anyone.";
				$message = "One step away from setting up your account.\nTo activate new password, please enter this verification code:\n{$params['otpCode']}";
				break;

			case 'ORDER_PLACED':
				$message = "Thank you for placing order at Buy Here Now. Your order ID is {$params['orderId']}, please call 01701039999 for any queries or support.";
				break;

			default:
				break;
		}

		return $message;
	}
}
