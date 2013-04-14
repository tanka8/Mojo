</div>
<footer class="footer">
	<div class="container">
		<hr>
		<?php
		$mtime = microtime(); 
		$mtime = explode(" ",$mtime); 
		$mtime = $mtime[1] + $mtime[0]; 
		$endtime = $mtime; 
		$totaltime = round(($endtime - $starttime), 4);
		?>
		<p>&copy;<?php echo date("Y"); ?> - All rights reserved<span class="pull-right">Page created in <?php echo $totaltime;?> seconds.</span></p>
	</div>
</footer>
<script src="js/jquery-1.8.3.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery.validate.min.js"></script>
<?php
if (isset($script)) {
    echo $script;
}
?>
</body>
</html>