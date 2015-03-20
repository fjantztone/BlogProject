<html>
<head><title>Database access test</title>
<script type='text/javascript' src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript" src="userdata.js"></script>
<?php 
include 'includes/config.php';

?>
<script>
var userData = null;

$(function () {
    userData = new UserData();
    userData.table = 'postsb';
    $('#addbutton').click(function () {
        userData.insertObject({content: $('#content').val()}, function(data){
            console.log(data);
        });
    });
    userData.getByAll(function(data){
        console.log(data);
    })
    userData.getByUserId({user_id: <?php echo $_SESSION['user']->get_id(); ?>}, function(data){
        console.log(data);
    })
});
</script>
</head>
<body>
  <table id="test">
  </table>
  <h3>Add A New Post</h3>
  Content: <input type="text" id="content">
  <input type="submit" value="Add" id="addbutton">
</body>
</html>