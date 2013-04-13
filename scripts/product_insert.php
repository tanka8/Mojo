<?php 
require 'sql.php';
$inputProductName = $_POST['inputProductName'];
$inputProductGroup = $_POST['inputProductGroup'];
$inputProductVendor = $_POST['inputProductVendor'];
if ($inputProductName == "" or $inputProductGroup == "" or $inputProductVendor == "") {
?>
<div class="alert">
  <button type="button" class="close" data-dismiss="alert">&times;</button>
  <strong>Error:</strong> Please refreash the page make sure all details are filled in.
</div>
<?php
	die();
}
$time = time();

$query = 'INSERT INTO `product_details` (`product_id`, `product_name`, `product_group`, `product_vendor`, `created_time`, `updated_time`) VALUES (NULL, \''.$inputProductName.'\', \''.$inputProductGroup.'\', \''.$inputProductVendor.'\', \''.$time.'\', \''.$time.'\')';
$result = $db->exec($query);
?>
<div class="alert alert-success">
	<button type="button" class="close" data-dismiss="alert">&times;</button>
	<strong>Product created:</strong> The product has been created with the submitted details.
</div>
<p>Click <a href="new_product.php">here</a> to create a new product.</p>