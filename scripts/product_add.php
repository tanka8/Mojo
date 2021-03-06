<?php 
require 'sql.php';
$inputHostClientID = $_POST['inputHostClientID'];
$inputProductID = $_POST['inputProductID'];
$inputProductUser = $_POST['inputProductUser'];
$inputProductPass = $_POST['inputProductPass'];
$inputDomain = $_POST['inputDomain'];
$inputHostingServer = $_POST['inputHostingServer'];
$inputMailServer = $_POST['inputMailServer'];

if ($inputHostClientID == "" or $inputProductID == "" or $inputProductUser == "" or $inputProductPass == "" or $inputDomain == "" or $inputHostingServer == "" or $inputMailServer == "") {
?>
<div class="alert">
  <button type="button" class="close" data-dismiss="alert">&times;</button>
  <strong>Error:</strong> Please refreash the page make sure all details are filled in.
</div>
<?php
	die();
}

$query = 'SELECT * FROM  `product_details` WHERE  `product_id` ='.$inputProductID;
$stmt = $db->query($query);
$product_details = $stmt->fetchAll(PDO::FETCH_ASSOC);

$product_type = $product_details[0]['product_group'];
$time = time();

$query = 'INSERT INTO `client_product` (`client_product_id`, `client_id`, `product_id`, `product_type`, `product_user`, `product_pass`, `created_time`, `updated_time`) VALUES (NULL, \''.$inputHostClientID.'\', \''.$inputProductID.'\', \''.$product_type.'\', \''.$inputProductUser.'\', \''.$inputProductPass.'\', \''.$time.'\', \''.$time.'\')';
$result = $db->exec($query);
$insertId = $db->lastInsertId();

$query = 'INSERT INTO `shared_hosting` (`hosting_id`, `client_product_id`, `domain`, `web_server`, `mail_server`) VALUES (NULL, \''.$insertId.'\', \''.$inputDomain.'\', \''.$inputHostingServer.'\', \''.$inputHostingServer.'\')';
$result = $db->exec($query);
?>
<div class="alert alert-success">
	<button type="button" class="close" data-dismiss="alert">&times;</button>
	<strong>Product added:</strong> The product has been added to the client.
</div>