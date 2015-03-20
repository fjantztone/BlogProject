<?php 
include_once('includes/config.php');
include_once('includes/helper_func.php');
if(!isset($_SESSION['user'])) die('404 not found');
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8"> 
        <meta charset="utf-8">
        <title>Bootply.com - Bootstrap Bootstrap 3 Admin</title>
        <meta name="generator" content="Bootply" />
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="style/gallery.css">
        <link rel="stylesheet" href="style/datepicker3.css">
        <script src="http://localhost/blog/js/tinymce/tinymce.min.js"></script>
  		
<style type="text/css">
.navbar-static-top {
	margin-bottom:20px;
}

i {
  font-size:16px;
}

.nav > li > a {
  color:#787878;
}
  
footer {
  margin-top:20px;
  padding-top:20px;
  padding-bottom:20px;
  background-color:#efefef;
}

/* count indicator near icons */
.nav>li .count {
  position: absolute;
  bottom: 12px;
  right: 6px;
  font-size: 9px;
  background: rgba(51,200,51,0.55);
  color: rgba(255,255,255,0.9);
  line-height: 1em;
  padding: 2px 4px;
  -webkit-border-radius: 10px;
  -moz-border-radius: 10px;
  -ms-border-radius: 10px;
  -o-border-radius: 10px;
  border-radius: 10px;
}

/* indent 2nd level */
.list-unstyled li > ul > li {
   margin-left:10px;
   padding:8px;
}
#content > div {
	display: none;
}
#content > div:target {
	display: block;
}
</style>
    </head>
    
    <!-- HTML code from Bootply.com editor -->
    
    <body  >
        
        <!-- Header -->
<div id="top-nav" class="navbar navbar-inverse navbar-static-top">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">Dashboard</a>
    </div>
    <div class="navbar-collapse collapse">
      <ul class="nav navbar-nav navbar-right">
        
        <li class="dropdown">
          <a class="dropdown-toggle" role="button" data-toggle="dropdown" href="#"><i class="glyphicon glyphicon-user"></i> <?php echo $_SESSION['user']->get_username(); ?> <span class="caret"></span></a>
          <ul id="g-account-menu" class="dropdown-menu" role="menu">
            <li><a href="#">My Profile</a></li>
          </ul>
        </li>
        <li><a href="logout.php"><i class="glyphicon glyphicon-lock"></i> Logout</a></li>
      </ul>
    </div>
  </div><!-- /container -->
</div>
<!-- /Header -->

<!-- Main -->
<div class="container-fluid">
<div class="row">
	<div class="col-sm-3">
      <!-- Left column -->
      <a href="#"><strong><i class="glyphicon glyphicon-wrench"></i> Tools</strong></a>  
      
      <hr>
      
      <ul class="list-unstyled">
        <li class="nav-header"> <a href="#" data-toggle="collapse" data-target="#userMenu">
          <h5>Settings <i class="glyphicon glyphicon-chevron-down"></i></h5>
          </a>
            <ul class="list-unstyled collapse in" id="userMenu">
                <li><a href="#add-img"><i class="glyphicon glyphicon-camera"></i> Blog gallery</a></li>
                <li><a href="#add-post"><i class="glyphicon glyphicon-envelope"></i> Add blog post</a></li>
                <li><a href="#edit-post"><i class="glyphicon glyphicon-edit"></i> Manage blog posts</a></li>
                <li><a href="#edit-wall"><i class="glyphicon glyphicon-home"></i> Manage wall</a></li>
                <li><a href="#"><i class="glyphicon glyphicon-heart-empty"></i> Subscribers <span class="badge badge-info">4</span></a></li>
                <li><a href="#"><i class="glyphicon glyphicon-user"></i> Blogs I subscribed</a></li>
                <li><a href="#"><i class="glyphicon glyphicon-off"></i> Logout</a></li>
            </ul>
        </li>      
      
  	</div><!-- /col-3 -->
    <div class="col-sm-9">
      	
      <!-- column 2 -->	
      <ul class="list-inline pull-right">
         <li><a href="#"><i class="glyphicon glyphicon-cog"></i></a></li>
         <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="glyphicon glyphicon-comment"></i><span class="count">3</span></a><ul class="dropdown-menu" role="menu"><li><a href="#">1. Is there a way..</a></li><li><a href="#">2. Hello, admin. I would..</a></li><li><a href="#"><strong>All messages</strong></a></li></ul></li>
         <li><a href="#"><i class="glyphicon glyphicon-user"></i></a></li>
         <li><a title="Add Widget" data-toggle="modal" href="#addWidgetModal"><span class="glyphicon glyphicon-plus-sign"></span> Add Widget</a></li>
      </ul>
      <a href="#"><strong><i class="glyphicon glyphicon-dashboard"></i> My Dashboard</strong></a>  
      
      	<hr>

		<div id="content">
            <span class="msg-container"></span>
            <!-- center left-->
            <div id="add-img">

                <div class="dropzone" id="dropzone-add">Drag the files you want to upload here. </div>

                <div class="dropzone" id="dropzone-del">Drag the file you want to delete here</div>

                <div id="uploads">
                    <ul id="list">
                        <?php 
                        foreach(glob('users/'.$_SESSION['user']->get_username().'/img/*') as $filename){
                            echo "<li><img src=".$filename." alt=".$filename."></img></li>";
                        }
                        ?>                
                    </ul>                    
                </div>
                <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">         
                            <div class="modal-body">               
                            </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->
            </div> <!--/add-img -->
			
            <div id="add-post">
                <span class="msg-post"></span>
                <form method="POST" name="addForm">
                    <input type="hidden" name="user_id" value="<?php echo $_SESSION['user']->get_id();?>"/>
                    <textarea name="content" id="add-content" style="width:100%"></textarea>
                    <button type="submit" class="btn btn-lg btn-primary">Post</button>
                </form>
            </div>

            <div id="edit-post">

                <span class="msg-post"></span>

                <div class="edit-form hidden">
                    <form method="POST" name="editForm">
                        <input type="hidden" name="id" id="post_id"/>
                        <textarea name="content" id="edit-content" style="width:100%"></textarea>
                        <button type="submit" class="btn btn-lg btn-primary">Post</button>
                    </form>
                </div>
                <div class="posts col-sm-10">
                </div>
                <div class="calendar col-sm-2">
                    <div id="date">
                        
                    </div>
                </div>
                <div class="modal fade" id="prevModal" tabindex="-1" role="dialog" aria-labelledby="prevLargeModal" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            ...
                        </div>
                    </div>
                </div>
			</div>
            <div id="edit-wall">
                <div id="addWall">
                    <form name="addWall">
                        <div class="form-group">
                            <label for="name">Your name</label>
                            <input type="text" class="form-control" name="blog_name" id="blog_name" placeholder="Enter name">
                        </div>
                        <div class="form-group">
                            <label for="textarea">Description about you</label>
                            <textarea class="form-control" name="content" id="content" placeholder="Enter description"></textarea>
                        </div>
                        <div class="form-group">
                            <button type="button" class="btn btn-default btn-block btn-img">Image</button>
                            <input type="hidden" name="image" id="img">
                        </div>
                        <input type="submit" name="submit" class="btn btn-primary" value="Submit"></input>
                    </form>
                </div>
                <div id="editWall" class="hidden">
                    <form name="editWall">
                        <div class="form-group">
                            <label for="name">Your name</label>
                            <input type="text" class="form-control" name="blog_name" id="blog_name" placeholder="Enter name" required>
                            <input type="hidden" class="form-control" name="id" id="id">
                        </div>
                        <div class="form-group">
                            <label for="textarea">Description about you</label>
                            <textarea class="form-control" name="content" id="content" placeholder="Enter description" required></textarea>
                        </div>
                        <div>
                            <button type="button" name="image" class="btn btn-default btn-block btn-img">Image</button>
                            <input type="hidden" name="image" id="img">
                        </div>
                        <div class="btn-group">
                            <input type="submit" name="submit" class="btn btn-primary" value="Save"></input>      
                        </div>
                    </form>
                </div>
                <div id="prev-wall">
                    
                </div>  
                <div class="modal fade" id="imgModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">         
                            <div class="modal-body">               
                            </div>
                        </div>
                    </div>
                </div>
            </div>              
            </div>

		</div> 
</div><!-- /.modal -->
</div>



  
        
        <script type='text/javascript' src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
        <script type='text/javascript' src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="http://localhost/Blog/js/gallery_ajax.js"></script>
        <script type="text/javascript" src="userdata.js"></script>
        <script type="text/javascript" src="js/posts_ajax.php"></script>
        <script type="text/javascript" src="js/wall_ajax.php"></script>
        <script src="js/bootstrap-datepicker.js"></script>
        
        <script type='text/javascript'>

        $(function() {
            new Wall('#edit-wall form[name="addWall"]', '#edit-wall form[name="editWall"]', '#edit-wall');
            $('[data-toggle=collapse]').click(function(){
              	// toggle icon
              	$(this).find("i").toggleClass("glyphicon-chevron-right glyphicon-chevron-down");
            });
        
        });
        
        </script>          
    </body>
</html>
