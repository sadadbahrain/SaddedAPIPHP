# SaddedInvoice

Project provides methods to generate sadded invoice and a method to check status of an already generated invoice.

Invoice can be generated using three different notification types i.e. Email, Sms and Online.

## Getting Started

### How to use

After adding SaddedInvoice folder to your project add this line inorder to use the invoice class to initialize its object

```
use SaddedInvoice\Invoice;
```

#### Guide to Generate invoice

Pass these variables as parameters into constructor:

* URL
* Branch Id
* Vendor Id
* Terminal Id
* Api Key


```
$invoice = new Invoice("<URL>","<BRANCH ID>", "<VENDOR ID>", "<TERMINAL ID>", "<API KEY>");
```
Set these attributes of invoice to generate a new invoice successfully

```
$invoice->amount = <decimal>; // Required, decimal e.g. 5
$invoice->email = <email>; // Required, a valid email address e.g. domain@domain.com
$invoice->msisdn = <string>; // Required, 11 digit phone number
$invoice->date = <string>; // Required, a valid date e.g. 2050-01-14 07:29:30
$invoice->description = <string>; // Optional, a short description
$invoice->customerName = <string>; // Required, customer name e.g. jhon
$invoice->successUrl = <url>; // success callback e.g. 'https://www.domain.com/success'
$invoice->errorUrl = <url>; // error callback e.g. 'https://www.domain.com/error'
$invoice->mode = <string>; // Required, e.g. sms, email & online
$invoice->externalReference = <string>; //Optional, Reference to your order
```

After setting the invoice attributes add this line to generate invoice using sms as notification mode

```
$response = $invoice.CreateSmsRequest();
```

To generate invoice using email as notification mode

```
$response = $invoice.CreateEmailRequest();
```

To generate invoice using online as notification mode

```
$response = $invoice.CreateLinkRequest();
```

#### Guide to check invoice status

Create instance of invoice class as we did above. After that call *SendInvoiceStatusRequest* method with transaction reference (can be captured in the response of generate invoice method) to get the status of an invoice


```
$invoice = new Invoice("<URL>","<BRANCH ID>", "<VENDOR ID>", "<TERMINAL ID>", "<API KEY>");

$response = $invoice.SendInvoiceStatusRequest("<pass-transaction-reference-here>");
```

## Built With

* PHP 7.2
* Sublime Text 3
