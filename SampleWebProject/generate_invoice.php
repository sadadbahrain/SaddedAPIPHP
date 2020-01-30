<?php

include "../SaddedInvoice/Invoice.php";

use SaddedInvoice\Invoice;

$invoice = new Invoice($_POST['url'], $_POST['branch_id'], $_POST['vendor_id'], $_POST['terminal_id'], $_POST['api_key']);
$invoice->amount = $_POST['amount'];
$invoice->email = $_POST['email'];
$invoice->msisdn = $_POST['msisdn'];
$invoice->date = (new DateTime($_POST['date']))->format("Y-m-d H:i:s");
$invoice->description = $_POST['description'];
$invoice->customerName = $_POST['customer_name'];
$invoice->successUrl = $_POST['success_url'];
$invoice->errorUrl = $_POST['error_url'];
$invoice->mode = $_POST['mode'];
$invoice->externalReference = $_POST['external_reference'];

$response = null;
if (strtolower($invoice->mode) == "online") {
	$response = $invoice->CreateLinkRequest();
} else if (strtolower($invoice->mode) == "sms") {
	$response = $invoice->CreateSmsRequest();
} else if (strtolower($invoice->mode) == "email") {
	$response = $invoice->CreateEmailRequest();
}

print_r($response);
?>