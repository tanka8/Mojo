<?php
$page_title = "Client Details";
$query = true;
require 'header.php';
$inputClientID = $_GET['id'];
if($inputClientID == '') {
	header('Location: clients.php');
}
//Get Client Details
$query = "SELECT * FROM `client_details` WHERE `client_id` = '".$inputClientID."'";
$stmt = $db->query($query);
$client_details = $stmt->fetchAll(PDO::FETCH_ASSOC);
//Check if result is empty and send back to clients page if true
$row_count = $stmt->rowCount();
if ($row_count == '0') {
	header('Location: clients.php');
	}
//Get list of hosting products for adding hosting product page
$query = "SELECT * FROM `product_details` WHERE `product_group` = 'shared_hosting'";
$stmt = $db->query($query);
$hosting_list = $stmt->fetchAll(PDO::FETCH_ASSOC);
//Get list of other products for adding other product page
$query = "SELECT * FROM `product_details` WHERE `product_group` != 'shared_hosting'";
$stmt = $db->query($query);
$other_list = $stmt->fetchAll(PDO::FETCH_ASSOC);
//Get hosting products for this client
$query = "SELECT * FROM `client_product` WHERE `client_id` = '".$inputClientID."' AND `product_type` = 'shared_hosting'";
$stmt = $db->query($query);
$hosting_product = $stmt->fetchAll(PDO::FETCH_ASSOC);
//Get other products for this client
$query = "SELECT * FROM `client_product` WHERE `client_id` = '".$inputClientID."' AND `product_type` != 'shared_hosting'";
$stmt = $db->query($query);
$other_product = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
    <li><a href="#hosting_products" data-toggle="tab">Hosting Products</a></li>
	<li><a href="#other_product" data-toggle="tab">Other Products</a></li>
	<li><a href="#add_hosting" data-toggle="tab">Add Hosting</a></li>
	<li><a href="#add_other" data-toggle="tab">Add Other</a></li>
  </ul>
  <div class="tab-content">
    <div class="tab-pane active" id="details">
    <form class="form-horizontal" action="#" id="client_update">
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
    <div class="tab-pane" id="hosting_products">
		<?php
		if((empty($hosting_product)) == 1){echo "<p><strong>Client does not have any hosting products.</strong></p>";}else {
		foreach ($hosting_product as $value) {
			//Get Product details from shared_hosting table
			$query = "SELECT * FROM `shared_hosting` WHERE `client_product_id` = '".$value['client_product_id']."'";
			$stmt = $db->query($query);
			$shared_hosting = $stmt->fetchAll(PDO::FETCH_ASSOC);
			//Get Product details from product_details table
			$query = "SELECT * FROM `product_details` WHERE `product_id` = '".$value['product_id']."'";
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
			//Get domain details
			require "scripts/uniforum_summary.php";
			
			?>
			<button type="button" class="btn <?php if ($whm_suspended == true or $whm_statusmsg == "Account does not exist") {echo "btn-danger";} else {echo "btn-info";}?> btn-block" data-toggle="collapse" data-target="#<?php echo $value['product_user']; ?>"><strong><?php echo $shared_hosting[0]['domain']." - ".$client_product_id[0]['product_name'];?></strong></button>
			<div id="<?php echo $value['product_user']; ?>" class="collapse">
			<?php if ($whm_suspended == true) {?>
			<!-- Suspended Alert -->
			<div class="alert alert-error">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
				<strong>Suspended:</strong> Domain suspended on <?php echo $shared_hosting[0]['mail_server'];?> with reason: "<?php echo $whm_suspendreason; ?>" at <?php echo (date('Y-m-d - H:i:s', $whm_suspendtime));?>
			</div>
			<?php } ?>
			<?php if ($whm_statusmsg == "Account does not exist") {?>
			<!-- Not on server Alert -->
			<div class="alert alert-error">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
				<strong>Not on Server:</strong> Domain could not be found on <?php echo $shared_hosting[0]['mail_server'];?> reason returned by server was "<?php echo $whm_statusmsg; ?>"
			</div>
			<?php } ?>
			<!-- DNS Details -->
			<h4>DNS Records</h4>
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
			<!-- CPanel and WHM login -->
			<h4>Server login:</h4> 
			<table class="table table-striped table-bordered table-hover">
			<tr><th>CPanel</th><th><a href="https://<?php echo $shared_hosting[0]['mail_server'];?>:2083/login/?pass=<?php echo $value['product_pass']; ?>&amp;user=<?php echo $value['product_user']; ?>" target="_blank"><i class="icon-wrench"></i></a></th></tr>
			<tr><th>WHM</th><th><a href="https://<?php echo $shared_hosting[0]['mail_server'];?>:2087/login/?pass=<?php echo $whm_server[0]['root_password']; ?>&amp;user=root" target="_blank"><i class="icon-wrench"></i></a></th></tr>
			</table>
			<!-- Disk Usage -->
			<?php if ($whm_statusmsg !== "Account does not exist") {?>
			<h4>Server details:</h4>
			<p><strong>WHM Server:</strong> <?php echo $shared_hosting[0]['mail_server']; ?></p>
			<p><strong>Disk Usage:</strong> <?php echo $whm_disk_used;?>MB / <?php echo $whm_disk_limit;?>MB</p>
			<div class="progress progress-striped <?php if ($whm_disk_used >= $whm_disk_limit){echo "progress-danger";}else{if(($whm_disk_used+100) >= $whm_disk_limit){echo "progress-warning";}}?>">
				<div class="bar" style="width: <?php echo (($whm_disk_used/$whm_disk_limit)*100);?>%"></div>
			</div>
			<p><strong>Hosting package:</strong> <?php echo $whm_plan; ?></p>
			<p><strong>Date added:</strong> <?php echo date('Y-m-d | H:i:s',$whm_added) ?></p>
			<?php } ?>
			<!-- Domain details -->
			<h4>Domain:</h4> 
			<?php if(isset($domain_blockedip)) {?>
			<p>Currenly unable to check. We are currently blocked at registry.net.za from IP <?php echo $domain_blockedip; ?> for another <?php echo $domain_timeout; ?>.</p>
			<?php } else { ?>
			<table class="table table-striped table-bordered table-hover">
			<tr><th>Domain renewal</th><th><?php echo $domain_renewal; ?></th></tr>
			<tr><th>Domain registrar</th><th><?php echo $domain_registrar; ?></th></tr>
			<tr><th>Domain status</th><th><?php echo $domain_status; ?></th></tr>
			<?php $i=1; foreach ($domain_nameservers as $value) {?>
			<tr><th>Name server <?php echo $i; ?></th><th><?php echo $value; ?></th></tr>
			<?php $i++; } ?>
			</table>
			<?php } ?>
			</div>
		<?php
		}
		}
		?>
    </div>
	<div class="tab-pane" id="other_product">
	<?php if((empty($other_product)) == 1){echo "<p><strong>Client does not have any other products.</strong></p>";}else {
		foreach ($other_product as $value) { 
		//Get Product details from product_details table
		$query = "SELECT * FROM `product_details` WHERE `product_id` = '".$value['product_id']."'";
		$stmt = $db->query($query);
		$client_product_id = $stmt->fetchAll(PDO::FETCH_ASSOC);
		?>
		<button type="button" class="btn btn-block btn-primary" data-toggle="collapse" data-target="#<?php echo $value['product_user']; ?>"><strong><?php echo $client_product_id[0]['product_name']." - ".$value['product_user'];?></strong></button>
		<div id="<?php echo $value['product_user']; ?>" class="collapse">
		<table class="table table-hover">
		<tr><th><strong>Username</strong></th><th><?php echo $value['product_user']; ?></th></tr>
		<tr><th><strong>Password:</strong></th><th><?php echo $value['product_pass']; ?></th></tr>
		</table>
		</div>
		
	<?php } } ?>
	</div>
	<div class="tab-pane" id="add_hosting">
		<h4>Add Hosting Product</h4>
		<form class="form-horizontal" action="#" id="product_add">
			<input value="<?php echo $inputClientID?>" type="hidden" name="inputHostClientID" id="inputHostClientID">
			<div class="control-group">
				<label class="control-label" for="inputProductID">Product</label>
				<div class="controls">
				<select class="input tp" name="inputProductID" id="inputProductID">
				<?php foreach ($hosting_list as $value) {echo "<option value='".$value['product_id']."'>".$value['product_name']."</option>";}?>
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
					<button class="btn btn-primary productloadingbtn" id="productsubmitbutton">Add Hosting Product</button>
				</div>
			</div>
		</form>
    </div>
	<div class="tab-pane" id="add_other">
		<h4>Add Other Product</h4>
		<form class="form-horizontal" action="#" id="other_add">
			<input value="<?php echo $inputClientID?>" type="hidden" name="inputOtherClientID" id="inputOtherClientID">
			<div class="control-group">
				<label class="control-label" for="inputOtherProductID">Product</label>
				<div class="controls">
				<select class="input tp" name="inputOtherProductID" id="inputOtherProductID">
				<?php foreach ($other_list as $value) {echo "<option value='".$value['product_id']."'>".$value['product_name']."</option>";}?>
				</select>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="inputOtherProductUser">Product Username</label>
				<div class="controls">
					<input type="text" class="input tp" name="inputOtherProductUser" id="inputOtherProductUser" placeholder="Product Username">
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="inputOtherProductPass">Product Password</label>
				<div class="controls">
					<input type="text" class="input tp" name="inputOtherProductPass" id="inputOtherProductPass" placeholder="Product Password">
				</div>
			</div>
			<div class="form-actions">
				<div class="controls">
					<button class="btn btn-primary otherproductloadingbtn" id="otherproductsubmitbutton">Add Other Product</button>
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
	inputHostClientID: document.getElementById(\"inputHostClientID\").value,
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
$('#other_add').validate({
        rules: {
			inputOtherProductUser: {required: true, maxlength: 255},
			inputOtherProductPass: {required: true, maxlength: 255}
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
		$('.otherproductloadingbtn').button('loading');
		addotherfunct();
		}
});
function addotherfunct() {
$.ajax({
	type: \"POST\",
	url: \"scripts/product_other_add.php\",
	data: {inputOtherClientID: document.getElementById(\"inputOtherClientID\").value, inputOtherProductID: document.getElementById(\"inputOtherProductID\").value, inputOtherProductUser: document.getElementById(\"inputOtherProductUser\").value, inputOtherProductPass: document.getElementById(\"inputOtherProductPass\").value},
	success: function(response){
		$('#other_add').html(response)
        }
 });
 }
</script>";
require 'footer.php';
?>