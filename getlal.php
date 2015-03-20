<script type='text/javascript' src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript" src="userdata.js"></script>


<script type="text/javascript">
userData = new UserData('#content');
userData.table = 'postsb';

userData.getByUserId(33, {limit: 1}, function (data) {
	console.log(data);
}, {});

</script>
<div id="content"></div>
<?php 

?>