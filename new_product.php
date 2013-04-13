<?php
$page_title = "New Product";
require 'header.php';
?>
<div class="page-header">
	<h1>New Product</h1>
</div>
<form class="form-horizontal" action="" id="product_insert">
	<div class="control-group">
		<label class="control-label" for="inputProductName">Product Name</label>
		<div class="controls">
			<input type="text" class="input tp" name="inputProductName" id="inputProductName" placeholder="Product Name">
		</div>
	</div>
	<div class="control-group">
		<label class="control-label" for="inputProductGroup">Product Group</label>
		<div class="controls">
			<input type="text" class="input tp" name="inputProductGroup" id="inputProductGroup" placeholder="Product Group">
		</div>
	</div>
	<div class="control-group">
		<label class="control-label" for="inputProductVendor">Product Vendor</label>
		<div class="controls">
			<input type="text" class="input tp" name="inputProductVendor" id="inputProductVendor" placeholder="Product Vendor">
		</div>
	</div>
	<div class="form-actions">
		<div class="controls submit">
			<button type="submit" class="btn btn-primary loadingbtn" id="submitbutton">Create Product</button>
		</div>
	</div>
</form>
<?php
$script = "
<script type='text/javascript'>
$('#product_insert').validate({  
        rules: {
			inputProductName: {required: true, maxlength: 255},
			inputProductGroup: {required: true, maxlength: 255},
			inputProductVendor: {required: true, maxlength: 255},
        },
		highlight: function(label) {
			$(label).closest('.control-group').addClass('error');
		},
		success: function(label) {
			label
			.addClass('valid')
			.closest('.control-group').addClass('success');
		},
		submitHandler: function(form) {
		$('.loadingbtn').button('loading');
		productcreatefunct();
		}
		

});
function productcreatefunct() {
$.ajax({
	type: \"POST\",
	url: \"scripts/product_insert.php\",
	data: {inputProductName: document.getElementById(\"inputProductName\").value, inputProductGroup: document.getElementById(\"inputProductGroup\").value, inputProductVendor: document.getElementById(\"inputProductVendor\").value},
	success: function(response){
		$('#product_insert').html(response)
        }
 });
 }
</script>";
require 'footer.php';
?>