<?php
$page_title = "Product Listing";
$query = true;
require 'header.php';
$query = "SELECT * FROM `product_details`";
$stmt = $db->query($query);
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<div class="page-header">
	<h1>Product listing</h1>
</div>
<a class="btn btn-primary" href="new_product.php">Create Product</a>
<hr>
<table class="table table-striped table-bordered table-hover">
<thead>
<tr><th>Product ID</th><th>Product Name</th><th>Product Group</th><th>Product Vendor</th><th>Created</th><th>Last edited</th><th>Edit</th></tr>
</thead>
<?php
foreach ($results as $value) {
?>
<tr>
<th><?php echo $value['product_id'];?></th>
<th><?php echo $value['product_name'];?></th>
<th><?php echo $value['product_group'];?></th>
<th><?php echo $value['product_vendor'];?></th>
<th><?php echo (date('Y-m-d - H:i:s', $value['updated_time']));?></th>
<th><?php if($value['updated_time'] == $value['created_time']) {echo "Never edited";} else {echo (date('Y-m-d - H:i:s', $value['created_time']));}?></th>
<th><a href="productdetails.php?id=<?php echo $value['product_id']; ?>"><i class="icon-edit"></i></a></th>
<?php
}
?>
</table>
<?php
$script = "
<script type='text/javascript'>
</script>";
require 'footer.php';
?>