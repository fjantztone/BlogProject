<html>
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap-theme.min.css">
	<link rel="stylesheet" type="text/css" href="style/loginForm.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
</head>
<body>


	<div class="container vertical-center">
	    <div class="row">
	        <div class="col-md-12">
	            <h3 class="text-center login-title">Sign up below</h3>
	            <div class="account-wall">
	            <?php include_once('handle_signup.php') ?>
	                <form class="form-signin" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
		                <div class="form-group">
			                <input type="text" name="username" class="form-control" placeholder="Username" required>
			                <span class="form-control-feedback" aria-hidden="true"></span>
			                <?php if(isset($error[0])) echo $error[0]; ?>
			            </div>
			            <div class="form-group">
		                	<input type="text" name="email" class="form-control" placeholder="Email" required>
		                	<span class="form-control-feedback" aria-hidden="true"></span>
		                	<?php if(isset($error[1])) echo $error[1]; ?>
		                </div>
		                <div class="form-group">
			                <input type="password" name="password" class="form-control" placeholder="Password" required>
			                <span class="form-control-feedback" aria-hidden="true"></span>
			            </div>
			                <input class="btn btn-lg btn-primary btn-block" type="submit" value="Sign up"></input>
	                </form>
	                <a href="login.php">Back to log in </a>
	            </div>
	        </div>
	    </div>
	</div>
	<script type="text/javascript">

	function verify_input (event) {
		event.preventDefault();
		var data = $(this).serialize();
		var inputField = $(this);
		var inputName = $(this).attr('name');
		var inputDiv = $(this).parent('div');
		var inputSpan = $(this).next('span');

		$.post('handle_signup.php', data, function(data){
			if(inputField.val().length == 0){
				clear(inputField, inputDiv, inputSpan);
			}
			else{
				clear(inputField, inputDiv, inputSpan); 		
				var json = JSON.parse(data);
				if(json[inputName] == false){
					inputDiv.addClass('has-error has-feedback');
					inputField.attr('id', 'inputError2');
					inputSpan.addClass('glyphicon glyphicon-remove');
				}
				else if(json[inputName] == true) {
					inputDiv.addClass('has-success has-feedback');
					inputField.attr('id', 'inputSuccess2');
					inputSpan.addClass('glyphicon glyphicon-ok');				
				}
			}
		});
		

		// body...
	}
	$("input").not(":input[type=submit]").keyup(verify_input).change(verify_input);
	function clear (inputField, inputDiv, inputSpan){
		inputField.removeAttr('id');
		inputDiv.removeClass().addClass('form-group');
		inputSpan.removeClass().addClass('form-control-feedback');	
	}
	</script>
</body>