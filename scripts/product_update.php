<?php 
require 'sql.php';
$inputProductID = $_POST['inputProductID'];
$inputProductName = $_POST['inputProductName'];
$inputProductGroup = $_POST['inputProductGroup'];
$inputProductVendor = $_POST['inputProductVendor'];
if ($inputProductID == "" or $inputProductName == "" or $inputProductGroup == "" or $inputProductVendor == "") {
?>
<div class="alert">
  <button type="button" class="close" data-dismiss="alert">&times;</button>
  <strong>Error:</strong> Please refreash the page make sure all details are filled in.
</div>
<?php
	die();
}
$time = time();
$query = 'UPDATE `product_details` SET `product_name` = \''.$inputProductName.'\', `product_group` = \''.$inputProductGroup.'\', `product_vendor` = \''.$inputProductVendor.'\', `updated_time` = \''.$time.'\' WHERE `product_id` = '.$inputProductID.';';
$result = $db->exec($query);
?>
<div class="alert alert-success">
	<button type="button" class="close" data-dismiss="alert">&times;</button>
	<strong>Product Update:</strong> The product details have been updated.
</div>
<p>Click <a href="productdetails.php?id=<?php echo $inputProductID;?>">here</a> to go back to the product details.</p>