<ul id="list">
    <?php 
    foreach(glob('users/'.$_SESSION['user']->get_username().'/img/*') as $filename){
        echo "<li><img src=".$filename." alt=".$filename."></img></li>";
    }
    ?>                
</ul> 
