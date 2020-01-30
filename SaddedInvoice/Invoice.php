<?php
/**
 * @file
 * Class that needs to be utilized for invoice creation using different modes (sms, email, url).
 * And Query the status of an already generated invoice
 */

namespace SaddedInvoice;
require "InvoiceNotifyMode.php";
require "Helper.php";
use DateTime;

const EPAYMENT_CREATE_URL = "api/v2/web-ven-sdd/epayment/create/";
const EPAYMENT_STATUS_URL = "api/v2/web-ven-sdd/epayment/status/";
class Invoice {

	private $url;
	private $invoiceCreateUrl;
	private $invoiceStatusUrl;
	private $apiKey;
	private $vendorId = -1, $branchId = -1, $terminalId = -1;

	public $mode;
	public $msisdn;
	public $email;
	public $customerName;
	public $amount;
	public $date;
	public $successUrl;
	public $errorUrl;
	public $externalReference;
	public $description;

	function __construct($url, $branch_id, $vendor_id, $terminal_id, $api_key) {

		$this->url = $url;
		$this->apiKey = $api_key;
		$this->invoiceCreateUrl = $this->url . EPAYMENT_CREATE_URL;
		$this->invoiceStatusUrl = $this->url . EPAYMENT_STATUS_URL;
		$this->branchId = $branch_id;
		$this->vendorId = $vendor_id;
		$this->terminalId = $terminal_id;
	}

	/**
	 * Create request using sms as notification mode.
	 *
	 * @return	object
	 *
	 */
	public function CreateSmsRequest() {
		$response = new \stdClass();
		$errors = $this->ValidateRequestParameters(InvoiceNotifyMode::SMS);
		if (count($errors) == 0) {
			$invoice = $this->setInvoiceObject(InvoiceNotifyMode::SMS);
			$response = Helper::post($this->invoiceCreateUrl, json_encode($invoice));
		} else {
			$response->{'error-message'} = implode('|', $errors);
			$response->{'error-code'} = 3;
		}
		return json_encode($response);
	}

	/**
	 * Create request using email as notification mode.
	 *
	 * @return	object
	 *
	 */
	public function CreateEmailRequest() {
		$response = new \stdClass();
		$errors = $this->ValidateRequestParameters(InvoiceNotifyMode::EMAIL);
		if (count($errors) == 0) {
			$invoice = $this->setInvoiceObject(InvoiceNotifyMode::EMAIL);
			$response = Helper::post($this->invoiceCreateUrl, json_encode($invoice));
		} else {
			$response->{'error-message'} = implode('|', $errors);
			$response->{'error-code'} = 3;
		}
		return json_encode($response);
	}

	/**
	 * Create invoice request that will generate url of payment.
	 *
	 * @return	object
	 *
	 */
	public function CreateLinkRequest() {
		$response = new \stdClass();
		$errors = $this->ValidateRequestParameters(InvoiceNotifyMode::ONLINE);
		if (count($errors) == 0) {
			$invoice = $this->setInvoiceObject(InvoiceNotifyMode::ONLINE);
			$response = Helper::post($this->invoiceCreateUrl, json_encode($invoice));
		} else {
			$response->{'error-message'} = implode('|', $errors);
			$response->{'error-code'} = 3;
		}
		return json_encode($response);
	}

	/**
	 * Sends invoice status against transaction reference passed to it that can be captured from creation response.
	 *
	 * @param   string  $transactionReference The transaction reference for which we are going to query the status of invoice
	 * @return	object
	 *
	 */
	public function SendInvoiceStatusRequest($transactionReference) {
		$invoiceStatusRequest = [];
		$invoiceStatusRequest['api-key'] = $this->apiKey;
		$invoiceStatusRequest['vendor-id'] = $this->vendorId;
		$invoiceStatusRequest['branch-id'] = $this->branchId;
		$invoiceStatusRequest['terminal-id'] = $this->terminalId;
		$invoiceStatusRequest['transaction-reference'] = $transactionReference;
		return json_encode(Helper::post($this->invoiceStatusUrl, json_encode($invoiceStatusRequest)));
	}

	/**
	 * Set invoice object that is going to be generated.
	 *
	 * @param   string  $mode The notification mode which will be used to generate the invoice
	 * @return	object
	 *
	 */
	private function setInvoiceObject($mode) {
		$invoice = [];
		$invoice['api-key'] = $this->apiKey;
		$invoice['vendor-id'] = $this->vendorId;
		$invoice['branch-id'] = $this->branchId;
		$invoice['terminal-id'] = $this->terminalId;
		$invoice['customer-name'] = $this->customerName;
		$invoice['amount'] = $this->amount;
		$invoice['date'] = $this->date;
		$invoice['notification-mode'] = $mode;
		$invoice['external-reference'] = $this->externalReference;
		$invoice['description'] = $this->description;
		if ($mode == InvoiceNotifyMode::SMS) {
			$invoice['email'] = null;
			$invoice['msisdn'] = $this->msisdn;
		}
		if ($mode == InvoiceNotifyMode::EMAIL) {
			$invoice['email'] = $this->email;
			$invoice['msisdn'] = null;
		}
		if ($mode == InvoiceNotifyMode::ONLINE) {
			$invoice['msisdn'] = $this->msisdn;
			$invoice['email'] = $this->email;
			$invoice['success-url'] = $this->successUrl;
			$invoice['error-url'] = $this->errorUrl;
		}
		return $invoice;
	}

	/**
	 * Validates request parameters according to the notification mode passed to it.
	 *
	 * @param   string  $mode The notification mode which will be used to generate the invoice
	 * @return	array
	 *
	 */
	private function ValidateRequestParameters($mode) {
		$errors = [];
		if ($this->amount <= 0) {
			array_push($errors, "Amount must be greater than zero");
		}

		if (!$this->date || $this->date == (new DateTime())->setTimestamp(0)) {
			array_push($errors, "Date is missing");
		}

		if (empty($this->email) && $mode == InvoiceNotifyMode::EMAIL) {
			array_push($errors, "Email is missing");
		}

		if (!Helper::isValidEmail($this->email) && $mode == InvoiceNotifyMode::EMAIL) {
			array_push($errors, "Email address is invalid");
		}

		if (empty($this->msisdn) && $mode == InvoiceNotifyMode::SMS) {
			array_push($errors, "Msisdn is missing");
		}

		if (!empty($this->msisdn) && (strlen($this->msisdn) != 11 || !Helper::startsWith($this->msisdn, "973"))) {
			array_push($errors, "Msisdn must be of 11 digits, starting with 973");
		}

		if ($mode == InvoiceNotifyMode::ONLINE && empty($this->msisdn) && empty($this->email)) {
			array_push($errors, "Msisdn or Email is missing");
		}

		if (empty($this->customerName)) {
			array_push($errors, "CustomerName is missing");
		}

		if ($mode == InvoiceNotifyMode::ONLINE) {
			if (empty($this->successUrl)) {
				array_push($errors, "SuccessUrl is missing");
			}

			if (empty($this->errorUrl)) {
				array_push($errors, "ErrorUrl is missing");
			}

		}
		return $errors;
	}
}

?>