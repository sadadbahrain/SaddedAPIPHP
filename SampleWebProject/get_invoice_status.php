<?php

include "../SaddedInvoice/Invoice.php";

use SaddedInvoice\Invoice;
$invoice = new Invoice($_POST['url'], $_POST['branch_id'], $_POST['vendor_id'], $_POST['terminal_id'], $_POST['api_key']);
$response = null;
$response = $invoice->SendInvoiceStatusRequest($_POST['TransactionIdentifier']);
print_r($response);
?>
