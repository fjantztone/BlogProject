<!DOCTYPE html>
<html>
<title>Blogg 2.0</title>
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">

	<!-- Optional theme -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap-theme.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

	<link rel="stylesheet" type="text/css" href="style/customCSS.css">
	<link rel="stylesheet" type="text/css" href="style/typeahead.css">

	<!-- Latest compiled and minified JavaScript -->

	
</head>
<body>
	<header class="navbar-default">
		<div class="container">
			<nav role="navigation">
				<div class="container-fluid">
				<!-- Brand and toggle get grouped for better mobile display -->
					<div class="navbar-header">
					  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
					    <span class="sr-only">Toggle navigation</span>
					    <span class="icon-bar"></span>
					    <span class="icon-bar"></span>
					    <span class="icon-bar"></span>
					  </button>
					  <a class="navbar-brand" href="#">Blog 2.0</a>

					</div>

					<!-- Collect the nav links, forms, and other content for toggling -->
					<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
					  <ul class="nav navbar-nav">
					  	<?php
				  		$menu_items = array('About'=>'about.php', 'Log in'=>'login.php', 'Log out'=>'logout.php', 'Controlpanel' => 'controlpanel.php'); 
				  		foreach($menu_items as $item => $link){
				  			if(isset($_SESSION['user']) && $item == 'Log in') continue;
				  			if(!isset($_SESSION['user']) && ($item == 'Log out' || $item == 'Controlpanel')) continue;
			  				echo '<li><a href="'.$link.'">'.$item.'</a></li>';
			  			}
						?>
					  </ul>
					 <form class="navbar-form navbar-left" role="search">
						<div class="input-group add-on">
								<input type="text" class="form-control" placeholder="Find blogs" name="srch-term" id="typeahead">
							<div class="input-group-btn">
								<button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
							</div>
						</div>
					 </form>
					</div><!-- /.navbar-collapse -->
				</div>
			</nav>	
		</div>
		<script src="http://localhost/Blog/js/typeahead.js"></script> 	
		<script type="text/javascript">
	 	 
		$(function($) {
		$('#typeahead').typeahead({
		  hint: true,
		  highlight: true,
		  minLength: 1
		},
		{
		  name: 'states',
		  displayKey: 'link',
		  source: function findMatches(query, cb) {
		 	$.ajax({
		 		type: 'POST',
		 		url: 'handle_search.php',
		 		data: {'query':query},
		 		dataType: 'JSON',
		 		success: function(data){
		 			cb(data);
		 		}
		 	})
		    
		  }

		});
		});
		</script>
	</header>