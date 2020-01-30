<?php
/**
 * @file
 * Helpers that need to be utilized for invoice creation.
 */
namespace SaddedInvoice;

class Helper {

	/**
	 * Validates email.
	 */
	public static function isValidEmail($email) {
		return filter_var($email, FILTER_VALIDATE_EMAIL);
	}

	/**
	 * Check if string starts with a particular pattern.
	 */
	public static function startsWith($string, $startString) {
		$len = strlen($startString);
		return (substr($string, 0, $len) === $startString);
	}

	/**
	 * Send post request to given url with some data as json and returns response as json.
	 */
	public static function post($url, $data) {
		$ch = curl_init($url);
		$payload = $data;
		curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$result = curl_exec($ch);
		curl_close($ch);
		return json_decode($result, true);
	}
}

?>