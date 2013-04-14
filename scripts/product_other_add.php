<?php 
require 'sql.php';
$inputOtherClientID = $_POST['inputOtherClientID'];
$inputOtherProductID = $_POST['inputOtherProductID'];
$inputOtherProductUser = $_POST['inputOtherProductUser'];
$inputOtherProductPass = $_POST['inputOtherProductPass'];
if ($inputOtherClientID == "" or $inputOtherProductID == "" or $inputOtherProductUser == "" or $inputOtherProductPass == "") {
?>
<div class="alert">
  <button type="button" class="close" data-dismiss="alert">&times;</button>
  <strong>Error:</strong> Please refreash the page make sure all details are filled in.
</div>
<?php
	die();
}

$query = 'SELECT * FROM  `product_details` WHERE  `product_id` ='.$inputOtherProductID;
$stmt = $db->query($query);
$product_details = $stmt->fetchAll(PDO::FETCH_ASSOC);

$product_type = $product_details[0]['product_group'];

$time = time();

$query = 'INSERT INTO `client_product` (`client_product_id`, `client_id`, `product_id`, `product_type`, `product_user`, `product_pass`, `created_time`, `updated_time`) VALUES (NULL, \''.$inputOtherClientID.'\', \''.$inputOtherProductID.'\', \''.$product_type.'\', \''.$inputOtherProductUser.'\', \''.$inputOtherProductPass.'\', \''.$time.'\', \''.$time.'\')';
$result = $db->exec($query);
?>
<div class="alert alert-success">
	<button type="button" class="close" data-dismiss="alert">&times;</button>
	<strong>Product added:</strong> The product has been added to the client.
</div>