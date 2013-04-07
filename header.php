<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Mojo - <?php echo $page_title;?></title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="Mojo">
		<!--[if lt IE 9]>
			<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
		<link href="css/bootstrap.min.css" rel="stylesheet">
		<style>body {padding-top: 60px;}</style>
		<link href="css/bootstrap-responsive.min.css" rel="stylesheet">
	</head>
	<body>
    <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="brand" href="#">Mojo</a>
          <div class="nav-collapse collapse">
            <ul class="nav">
              <li class="active"><a href="#">Home</a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
	<div class="container">
<?php
if (isset($query)) {
	if ($query == TRUE) {
		require 'scripts/sql.php';
	}
}