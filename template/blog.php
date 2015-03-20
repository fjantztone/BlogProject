
<html>
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap-theme.min.css">
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="http://localhost/Blog/style/custom_blog.css">
	<link rel="stylesheet" href="http://localhost/Blog/style/datepicker3.css">
	<link rel="stylesheet" href="http://localhost/Blog/style/star-rating.css">
	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>		
	<script src="http://localhost/Blog/userdata.js"></script>
	<script src="http://localhost/Blog/js/bootstrap.js"></script>
	<script src="http://localhost/Blog/js/bootbox.min.js"></script>
	<script src="http://localhost/Blog/js/bootstrap-datepicker.js"></script>		
	<script src="http://localhost/Blog/js/star-rating.js"></script>		
		
</head>
<body>
	<div class="container">

	    <div class="row">

	        <!-- Blog Post Content Column -->
	        <div class="col-lg-8">
		        <div id="posts"></div>
		        <div id="commentForm" class="hidden">
		        	<?php
		        	if(isset($_SESSION['user'])){
						echo '<div class="well">'.
							'<h4>Leave a comment:</h4>'.
							'<form role="form">'.
							'<div class="form-group">'.
							'<input type="hidden" name="post_id" value=""></input>'.
							'<input type="hidden" name="user_id" value="'.$_SESSION['user']->get_id().'"></input>'.
							'<textarea class="form-control" name="content" rows="3"></textarea>'.
							'</div>'.
							'<button type="submit" class="btn btn-primary btn-comment">Submit</button>'.
							'</form>'.
							'</div>';						

						 
						echo '<form class="editForm hidden">'.
							'<input type="hidden" name="id" value="">'.
							'<input type="hidden" name="user_id" value="'.$_SESSION['user']->get_id().'">'.
							'<textarea name="content" rows="3"></textarea>'.
							'</form>';
		        		
		        	}
		        	?>		        	
		        </div>
		        <div id="comments">
		        	
		        </div>
	        </div>





	        <!-- Blog Sidebar Widgets Column -->
	        <div class="col-md-4">


	            <!-- Blog Categories Well -->
				<div class="well" id="rate">
					<ul class="list-unstyled">
						<li><a id="latestPosts"><span class="glyphicon glyphicon-home" aria-hidden="true"></span> Latest posts</a></li>
						<?php 
						if(isset($_SESSION['user'])){
							echo 
							'<li><a id="subscribeBlog"><span class="glyphicon glyphicon-heart" aria-hidden="true"></span> Subscribe blog</a></li>';
						} ?>
						<li><strong>Rate this blog</strong><input id="input-id" type="number" min=0 max=5 step=1 data-size="xs" ></li>						
						
					</ul>
				</div>
	            <div class="well" id="calendar">
	            	<div id="date"></div>
	                
	                <!-- /.row -->
	            </div>
	            
	            <!-- Side Widget Well -->
	            <div class="well" id="wall">
asdada	            		
	            </div>

	    </div>


	</div>

<script type="text/javascript">
var UserInfo = {
	config:
	{
		id: <?php echo user_id;?>
	}
	
}
var GuestInfo = {
	config:
		{
			id: <?php if(isset($_SESSION['user'])) echo $_SESSION['user']->get_id();
				else echo -1;?>
		}
}


$.fn.serializeObject = function()
{
    var o = {};
    var a = this.serializeArray();
    $.each(a, function() {
        if (o[this.name] !== undefined) {
            if (!o[this.name].push) {
                o[this.name] = [o[this.name]];
            }
            o[this.name].push(this.value || '');
        } else {
            o[this.name] = this.value || '';
        }
    });
    return o;
};
$(function () {

	blog = new Blog('#posts', '#calendar', '#wall', '#comments', '#input-id');
	
});
</script>
<script src="http://localhost/Blog/template/js/blog_data.php"></script>	
</body>