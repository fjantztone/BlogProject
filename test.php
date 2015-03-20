<?php
include_once('includes/config.php');

if(count(glob('users/'.$_SESSION['user']->get_username().'/img/*')) > 0){
    echo '<ul id="img-list">';
    foreach(glob('users/'.$_SESSION['user']->get_username().'/img/*') as $filename){
        echo "<li><img src=".$filename." alt=".$filename."/></li>";
    }
    echo '</ul>'; 
} 
?>



               
