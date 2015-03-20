
<?php 
$paths = glob('users/crille/img/*');
if(!empty($paths)){
	foreach($paths as $file){
		echo '<img src="'.$file.'" width="20%"/>';
	}
}
else
	echo 'No images available. Please add images to your gallery first.';

?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script type="text/javascript">
$(function () {
	$('img').on('click', function (event) {
		var args = top.tinymce.activeEditor.windowManager.getParams();
		win = (args.window);
		input = (args.input);
		win.document.getElementById(input).value = 'http://' + location.hostname + '/blog/' + $(this).attr('src');
		top.tinymce.activeEditor.windowManager.close();
	});
	// body...
})

</script>