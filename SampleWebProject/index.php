<!DOCTYPE html>
<html>
	<head>
		<title>Generate Sadded Invoice - Demo Preview</title>
		<meta content="noindex, nofollow" name="robots">

		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
		<script src="https://cdn.jsdelivr.net/momentjs/2.14.1/moment.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
		<link href='css/redirect_form.css' rel='stylesheet' type='text/css'>
	</head>
	<body>
	<div class="">
		<div class="first col-md-7">
			<h2>Fill Form to Generate Sadded Invoice</h2>
			<form action="generate_invoice.php" id="create_form" method="post" name="create_form">
				<div class="form-group">
					<label>URL *:</label>
					<input id="url" name="url" placeholder='URL' type='text' class="form-control" required="" value="https://eps-net-uat.sadadbh.com/">
				</div>
				<div class="form-group">
					<label>Branch ID *:</label>
					<input id="branch_id" name="branch_id" placeholder='Branch Key' type='text' class="form-control" required="" value="Enter your Branch Id received from Sadad">
				</div>
				<div class="form-group">
					<label>Vendor ID *:</label>
					<input id="vendor_id" name="vendor_id" placeholder='Vendor Key' type='text' class="form-control" required="" value="Enter your vendor Id received from Sadad">
				</div>
				<div class="form-group">
					<label>Terminal ID *:</label>
					<input id="terminal_id" name="terminal_id" placeholder='Terminal Key' type='text' class="form-control" required="" value="Enter your Terminal Id received from Sadad">
				</div>
				<div class="form-group">
					<label>API Key *:</label>
					<input id="api_key" name="api_key" placeholder='API Key' type='text' class="form-control" required="" value="Enter your API key received from Sadad">
				</div>
				<div class="form-group">
					<label>Mode *:</label>
					<select onchange="getval(this);" class="form-control" id="mode" required="" name="mode">
					    <option value="">Select mode</option>
					    <option value="sms">Sms</option>
					    <option value="email">Email</option>
					    <option value="online">Online</option>
					</select>
				</div>
				<div class="form-group">
					<label>Customer Name *:</label>
					<input id="name" name="customer_name" placeholder='Customer Name' type='text' class="form-control" required="">
				</div>
				<div class="form-group">
					<label>Email :</label>
					<input id="email" name="email" placeholder='Valid Email Address' type='email' class="form-control">
				</div>
				<div class="form-group">
					<label>Msisdn :</label>
					<input id="msisdn" name="msisdn" placeholder='Msisdn' type='text' class="form-control">
				</div>
				<div class="form-group">
					<label>Amount *:</label>
					<input id="amount" name="amount" placeholder='Amount' type='number' value="" class="form-control" required="">
				</div>
				<div class="form-group">
					<label>Description :</label>
					<input id="description" name="description" placeholder='Description' type='text' class="form-control" value="">
				</div>
				<div class="form-group">
                  <label class="control-label">Date *:</label>
                  <div class='input-group date' id='date'>
                     <input type='text' class="form-control" name="date" />
                     <span class="input-group-addon">
                     <span class="glyphicon glyphicon-calendar"></span>
                     </span>
                  </div>
               </div>
               <div class="form-group" id="external_reference">
					<label>External Reference :</label>
					<input id="external_reference" name="external_reference" placeholder='External Reference' type='text' class="form-control" value="">
				</div>
				<div class="form-group" id="success_url_fg">
					<label>Success URL :</label>
					<input id="success_url" name="success_url" placeholder='Success URL' type='text' class="form-control" value="">
				</div>
				<div class="form-group" id="error_url_fg">
					<label>Error URL :</label>
					<input id="error_url" name="error_url" placeholder='Error URL' type='text' class="form-control" value="">
				</div>
				<input id='btn' name="submit" type='submit' value='Submit' class="btn btn-primary">
			</form>

			<p style="padding: 5px 5px 5px 0px;"><a id="payment_href">Click here to make payment</a></p>
		</div>

		<div class="first col-md-4">
			<h2>Fill Form to Get Sadded Invoice Status</h2>
			<form action="get_invoice_status.php" id="get_form" method="post" name="get_form">
				<div class="form-group">
					<label>URL *:</label>
					<input id="url" name="url" placeholder='URL' type='text' class="form-control" required="" value="https://eps-net-uat.sadadbh.com/">
				</div>
				<div class="form-group">
					<label>Branch ID *:</label>
					<input id="branch_id" name="branch_id" placeholder='Branch Key' type='text' class="form-control" required="" value="">
				</div>
				<div class="form-group">
					<label>Vendor ID *:</label>
					<input id="vendor_id" name="vendor_id" placeholder='Vendor Key' type='text' class="form-control" required="" value="">
				</div>
				<div class="form-group">
					<label>Terminal ID *:</label>
					<input id="terminal_id" name="terminal_id" placeholder='Terminal Key' type='text' class="form-control" required="" value="">
				</div>
				<div class="form-group">
					<label>API Key *:</label>
					<input id="api_key" name="api_key" placeholder='API Key' type='text' class="form-control" required="" value="">
				</div>
				<div class="form-group">
					<label>Transaction Reference :</label>
					<input id="transaction_reference" name="transaction_reference" placeholder='Transaction Reference' type='text' class="form-control" value="">
				</div>
				<input id='btn' name="submit" type='submit' value='Submit' class="btn btn-primary">
			</form>
			<p style="padding: 5px 5px 5px 0px;"><a></a></p>
		</div>
	</div>

	<script type="text/javascript">
	    $('#date').datetimepicker();
	    var href = $('#payment_href');
   	   	if(href){
       	   	href.hide();
   	   	}
	</script>

	  <script>
	  	function getval(sel)
		{
			$('#success_url_fg').hide();
    		$('#error_url_fg').hide();
	    	$('#success_url').removeAttr('required');
	    	$('#error_url').removeAttr('required');
		    if(sel.value == "sms"){
		    	$("#msisdn").attr("required", "true");
		    	$('#email').removeAttr('required');
		    }
		    else if(sel.value == "email"){
		    	$("#email").attr("required", "true");
		    	$('#msisdn').removeAttr('required');
		    }
		    else if(sel.value == "online"){
		    	$('#success_url_fg').show();
	    		$('#error_url_fg').show();
		    	$("#success_url").attr("required", "true");
		    	$("#error_url").attr("required", "true");
		    }
		}
	      $(document).ready(function(){
	      	$('#success_url_fg').hide();
	    	$('#error_url_fg').hide();
	        var create_form = $('#create_form');
	        create_form.submit(function(event){
		        event.preventDefault();
	        	var url = create_form.attr('action');
			    $.ajax({
		           type: "POST",
		           url: url,
		           dataType: 'json',
		           data: create_form.serialize(),
		           success: function(data)
		           {
		           	   // data = JSON.parse(data);
		           	   if(data['error-code'] && data['error-code'] > 0){
		           	   	var href = $('#payment_href');
		           	   	if(href){
		           	   		href.hide();
		           	   	}
		           		alert(data['error-message']);
		           	   }
		           	   if((data['error-code'] == 0) && data['payment-url']){
		           	   	var href = $('#payment_href');
		           	   	if(href){
			           	   	href.show();
							href.attr("href", data['payment-url']);
							href.attr("target","_blank");
		           	   	}
		           	   }
		           }
		         });
	        });

	        var get_form = $('#get_form');
	        get_form.submit(function(event){
		        event.preventDefault();
	        	var url = get_form.attr('action');
			    $.ajax({
		           type: "POST",
		           url: url,
		           data: get_form.serialize(),
		           dataType: 'json',
		           success: function(data)
		           {
		           	   // data = JSON.parse(data);
		           	   if(data['error-message']){
		           	   	alert(data['error-message']);
		           	   }
		           }
		         });
	        });
	      });
	    </script>
	</body>

</html>