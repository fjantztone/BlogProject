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
<?php
include_once('includes/config.php');
include_once('includes/helper_func.php');
if(isset($_SESSION['user']))
    header('location: index.php');
?>
<body>

    <div class="container vertical-center">
        <div class="row">
            <div class="col-md-12">
                <h3 class="text-center login-title">Sign in below</h3>
                <div class="account-wall">
                	<?php include_once('handle_login.php') ?>
                    <form class="form-signin" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
                    	<input type="text" name="username" class="form-control" placeholder="Username" required>
                    	<input type="password" name="password" class="form-control" placeholder="Password" required>
    	                <input class="btn btn-lg btn-primary btn-block" type="submit" value="Sign in"></input>
                    </form>
                    <?php if(isset($error[0])) echo $error[0]; ?>
                </div>
                <a href="signup.php" class="text-center new-account">Create an account </a>
            </div>
        </div>
    </div>
</body>