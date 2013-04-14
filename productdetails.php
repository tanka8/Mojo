<?php
$page_title = "Product Details";
$query = true;
require 'header.php';
$product_id = $_GET['id'];
if($product_id == '') {
	header('Location: products.php');
}
$query = "SELECT * FROM `product_details` WHERE `product_id` = '".$product_id."'";
$stmt = $db->query($query);
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
$row_count = $stmt->rowCount();
if ($row_count == '0') {
	header('Location: products.php');
	}
?>
<div class="page-header">
	<h1>Product Details</h1>
</div>
<?php
if(isset($_GET['msg'])) {
if ($_GET['msg'] == "Update") {
	?>
<div class="alert alert-success">
	<button type="button" class="close" data-dismiss="alert">&times;</button>
	<strong>Success:</strong> Product details has been updated.
</div>
<?php
}
}
?>
<form class="form-horizontal" action="#" id="product_update">
	<input value="<?php echo $product_id?>" type="hidden" name="inputProductID" id="inputProductID">
	<div class="control-group">
		<label class="control-label" for="inputProductName">Product Name</label>
		<div class="controls">
			<input value="<?php echo $results[0]['product_name'];?>" type="text" class="input tp" name="inputProductName" id="inputProductName" placeholder="Product Name">
		</div>
	</div>
	<div class="control-group">
		<label class="control-label" for="inputProductGroup">Product Group</label>
		<div class="controls">
			<input value="<?php echo $results[0]['product_group'];?>" type="text" class="input tp" name="inputProductGroup" id="inputProductGroup" placeholder="Product Group">
		</div>
	</div>
	<div class="control-group">
		<label class="control-label" for="inputProductVendor">Product Vendor</label>
		<div class="controls">
			<input value="<?php echo $results[0]['product_vendor'];?>" type="text" class="input tp" name="inputProductVendor" id="inputProductVendor" placeholder="Product Vendor">    
		</div>
	</div>
	<div class="form-actions">
		<div class="controls submit">
			<button type="submit" class="btn btn-primary loadingbtn" id="submitbutton">Update Product</button>
		</div>
	</div>
</form>
<?php
$script = "
<script type='text/javascript'>
$('#product_update').validate({  
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
		userupdatefunct();
		}
		

});
function userupdatefunct() {
$.ajax({
	type: \"POST\",
	url: \"scripts/product_update.php\",
	data: {inputProductID: document.getElementById(\"inputProductID\").value, inputProductName: document.getElementById(\"inputProductName\").value, inputProductGroup: document.getElementById(\"inputProductGroup\").value, inputProductVendor: document.getElementById(\"inputProductVendor\").value},
	success: function(response){
		$('#product_update').html(response)
        }
 });
 }
</script>";
require 'footer.php';
?>