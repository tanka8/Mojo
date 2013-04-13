<?php
$page_title = "Client Details";
$query = true;
require 'header.php';
$inputClientID = $_GET['id'];
if($inputClientID == '') {
	header('Location: clients.php');
}
$query = "SELECT * FROM `client_details` WHERE `client_id` = '".$inputClientID."'";
$stmt = $db->query($query);
$client_details = $stmt->fetchAll(PDO::FETCH_ASSOC);
$row_count = $stmt->rowCount();
if ($row_count == '0') {
	header('Location: clients.php');
	}
$query = "SELECT * FROM `product_details`";
$stmt = $db->query($query);
$product_details = $stmt->fetchAll(PDO::FETCH_ASSOC);

$query = "SELECT * FROM `client_product` WHERE `client_id` = '".$inputClientID."'";
$stmt = $db->query($query);
$client_product = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<div class="page-header">
	<h1>Client Details</h1>
</div>
<?php
if(isset($_GET['msg'])) {
if ($_GET['msg'] == "Update") {
	?>
<div class="alert alert-success">
	<button type="button" class="close" data-dismiss="alert">&times;</button>
	<strong>Success:</strong> User details has been updated.
</div>
<?php
}
}
?>
<div class="tabbable">
  <ul class="nav nav-tabs">
    <li class="active"><a href="#details" data-toggle="tab">Details</a></li>
    <li><a href="#products" data-toggle="tab">Products</a></li>
	<li><a href="#add_products" data-toggle="tab">Add Product</a></li>
  </ul>
  <div class="tab-content">
    <div class="tab-pane active" id="details">
    <form class="form-horizontal" action="" id="client_update">
	<input value="<?php echo $inputClientID?>" type="hidden" name="inputClientID" id="inputClientID">
	<div class="control-group">
		<label class="control-label" for="inputFirstName">First Name</label>
		<div class="controls">
			<input value="<?php echo $client_details[0]['first_name'];?>" type="text" class="input tp" name="inputFirstName" id="inputFirstName" placeholder="First Name">
		</div>
	</div>
	<div class="control-group">
		<label class="control-label" for="inputLastName">Last Name</label>
		<div class="controls">
			<input value="<?php echo $client_details[0]['last_name'];?>" type="text" class="input tp" name="inputLastName" id="inputLastName" placeholder="Last Name">
		</div>
	</div>
	<div class="control-group">
		<label class="control-label" for="inputUsername">Username</label>
		<div class="controls">
			<input value="<?php echo $client_details[0]['username'];?>" type="text" class="input tp" name="inputUsername" id="inputUsername" placeholder="Username" disabled>    
		</div>
	</div>
	<div class="form-actions">
		<div class="controls submit">
			<button type="submit" class="btn btn-primary updateloadingbtn" id="submitbutton">Update User</button>
		</div>
	</div>
	</form>
    </div>
    <div class="tab-pane" id="products">
		<h3>Products</h3>
		<?php
		foreach ($client_product as $value) {
			//Get Product details from shared_hosting table
			$query = "SELECT * FROM `shared_hosting` WHERE `client_product_id` = '".$value['client_product_id']."'";
			$stmt = $db->query($query);
			$shared_hosting = $stmt->fetchAll(PDO::FETCH_ASSOC);
			//Get Product details from product_details table
			$query = "SELECT * FROM `product_details` WHERE `product_id` = '".$value['client_product_id']."'";
			$stmt = $db->query($query);
			$client_product_id = $stmt->fetchAll(PDO::FETCH_ASSOC);
			//Get WHM Server details
			$query = "SELECT * FROM `whm_servers` WHERE `server_hostname` = '".$shared_hosting[0]['mail_server']."'";
			$stmt = $db->query($query);
			$whm_server = $stmt->fetchAll(PDO::FETCH_ASSOC);
			//Get WHM Account Summary
			require "scripts/whm_summary.php";
			//Get DNS records
			$DNS_MX = dns_get_record($shared_hosting[0]['domain'], DNS_MX);
			$DNS_Mail = dns_get_record("mail.".$shared_hosting[0]['domain'], DNS_A);
			$DNS_NS = dns_get_record($shared_hosting[0]['domain'], DNS_NS);
			$DNS_A = dns_get_record($shared_hosting[0]['domain'], DNS_A);
			//Get hostname of resolved A records
			$DNS_Mail_Host = gethostbyaddr($DNS_Mail[0]['ip']);
			$DNS_A_Host = gethostbyaddr($DNS_A[0]['ip']);
			
			?>
			<h4><?php echo $shared_hosting[0]['domain']." - ".$client_product_id[0]['product_name'];?></h4>
			<h5>DNS Records</h5>
			<table class="table table-striped table-bordered table-hover">
			<thead>
			<tr><th>Record</th><th>Target</th></tr>
			</thead>
			<tr><th>MX Record:</th><th><?php if(isset($DNS_MX[0]['target'])) {echo $DNS_MX[0]['target'];} else {echo "Not set";}?></th>
			<tr><th>Mail Record:</th><th><?php if(isset($DNS_Mail[0]['ip'])) {echo $DNS_Mail[0]['ip'];} else {echo "Not set";}?> - <?php echo $DNS_Mail_Host; ?></th>
			<tr><th>Root Record:</th><th><?php if(isset($DNS_A[0]['ip'])) {echo $DNS_A[0]['ip'];} else {echo "Not set";}?> - <?php echo $DNS_A_Host; ?></th>
			<?php foreach ($DNS_NS as $NS) {?>
			<tr><th>NS Record:</th><th><?php echo $NS['target'];?></th>
			<?php } ?>
			</table>
			
			<h5>Server login:</h5> 
			<table class="table table-striped table-bordered table-hover">
			<tr><th>CPanel</th><th><a href="https://<?php echo $shared_hosting[0]['mail_server'];?>:2083/login/?pass=<?php echo $client_product[0]['product_pass']; ?>&user=<?php echo $client_product[0]['product_user']; ?>"><i class="icon-wrench"></i></a></th></tr>
			<tr><th>WHM</th><th><a href="https://<?php echo $shared_hosting[0]['mail_server'];?>:2087/login/?pass=<?php echo $whm_server[0]['root_password']; ?>&user=root"><i class="icon-wrench"></i></a></th></tr>
			</table>
			<h5>Disk Usage:</h5>
			<div class="progress progress-striped">
				<div class="bar" style="width: <?php echo (($whm_disk_used/$whm_disk_limit)*100);?>%"></div>
			</div>
		<?php
		}
		?>
    </div>
	<div class="tab-pane" id="add_products">
		<h4>Add Product</h4>
		<form class="form-horizontal" action="" id="product_add">
			<input value="<?php echo $inputClientID?>" type="hidden" name="inputClientID" id="inputClientID">
			<div class="control-group">
				<label class="control-label" for="inputProductID">Product</label>
				<div class="controls">
				<select class="input tp" name="inputProductID" id="inputProductID">
				<?php foreach ($product_details as $value) {echo "<option value='".$value['product_id']."'>".$value['product_name']."</option>";}?>
				</select>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="inputProductUser">Product Username</label>
				<div class="controls">
					<input  type="text" class="input tp" name="inputProductUser" id="inputProductUser" placeholder="Product Username">
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="inputProductPass">Product Password</label>
				<div class="controls">
					<input  type="text" class="input tp" name="inputProductPass" id="inputProductPass" placeholder="Product Password">
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="inputDomain">Domain Name</label>
				<div class="controls">
					<input  type="text" class="input tp" name="inputDomain" id="inputDomain" placeholder="Domain Name">
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="inputHostingServer">Hosting Server</label>
				<div class="controls">
					<input  type="text" class="input tp" name="inputHostingServer" id="inputHostingServer" placeholder="Hosting Server">
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="inputMailServer">Mail Server</label>
				<div class="controls">
					<input  type="text" class="input tp" name="inputMailServer" id="inputMailServer" placeholder="Mail Server">
				</div>
			</div>
			<div class="form-actions">
				<div class="controls">
					<button class="btn btn-primary productloadingbtn" id="submitbutton">Update User</button>
				</div>
			</div>
		</form>
    </div>
  </div>
</div>
<?php
$script = "
<script type='text/javascript'>
$('#client_update').validate({  
        rules: {
			inputFirstName: {required: true, maxlength: 255},
			inputLastName: {required: true, maxlength: 255},
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
		$('.updateloadingbtn').button('loading');
		userupdatefunct();
		}
});
function userupdatefunct() {
$.ajax({
	type: \"POST\",
	url: \"scripts/client_update.php\",
	data: {inputClientID: document.getElementById(\"inputClientID\").value, inputFirstName: document.getElementById(\"inputFirstName\").value, inputLastName: document.getElementById(\"inputLastName\").value, inputUsername: document.getElementById(\"inputUsername\").value},
	success: function(response){
		$('#client_update').html(response)
        }
 });
 }
$('#product_add').validate({
        rules: {
			inputProductUser: {required: true, maxlength: 255},
			inputProductPass: {required: true, maxlength: 255},
			inputDomain: {
                required: true,
                maxlength: 255,
                remote: 'scripts/check_domain.php'
			},
			inputHostingServer: {required: true, maxlength: 255},
			inputMailServer: {required: true, maxlength: 255},
        },
		highlight: function(label) {
			$(label).closest('.control-group').addClass('error');
		},
		messages: {
            inputDomain:{
                remote: 'Domain already in database.'
            }
        },
		success: function(label) {
			label
			.addClass('valid')
			.closest('.control-group').addClass('success');
		},
		submitHandler: function(form) {
		$('.productloadingbtn').button('loading');
		addproductfunct();
		}
});
function addproductfunct() {
$.ajax({
	type: \"POST\",
	url: \"scripts/product_add.php\",
	data: {
	inputClientID: document.getElementById(\"inputClientID\").value,
	inputProductID: document.getElementById(\"inputProductID\").value,
	inputProductUser: document.getElementById(\"inputProductUser\").value,
	inputProductPass: document.getElementById(\"inputProductPass\").value,
	inputDomain: document.getElementById(\"inputDomain\").value,
	inputHostingServer: document.getElementById(\"inputHostingServer\").value,
	inputMailServer: document.getElementById(\"inputMailServer\").value
	},
	success: function(response){
		$('#product_add').html(response)
	},
 });
 }
</script>";
require 'footer.php';
?>