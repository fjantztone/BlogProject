(function () {
	var dropzoneAdd = document.getElementById('dropzone-add');
	var dropzoneDel = document.getElementById('dropzone-del');
	var draggedItem;

	var updateLinks = function () {
		$('li img').on('click',function(){
            var src = $(this).attr('src');
            var img = '<img src="' + src + '" class="img-responsive"/>';
            $('#myModal').modal();
            $('#myModal').on('shown.bs.modal', function(){
                $('#myModal .modal-body').html(img);
            });
            $('#myModal').on('hidden.bs.modal', function(){
                $('#myModal .modal-body').html('');
            });
        });  		
	}

	var removeElement = function (element) {
		var tmp = element.parentNode;
		tmp.removeChild(element);
	}
	var drag = function (e) {
		e.dataTransfer.setData('text/plain', e.target.alt);
		draggedItem = e.target;	
	}
	var displayUploads = function (data) {
		var uploads = document.getElementById('list');
		var length = Object.keys(data).length;
		for(index=0; index<length-1; index+=1){
			var li = document.createElement('li');
			var image = document.createElement('img');
			image.src = data[index].file;
			image.alt = data[index].name;
			li.appendChild(image);
			image.setAttribute('draggable', true);
			image.ondragstart = function(event) {drag(event)}; //This is the elment that will be draggable.
			
			uploads.insertBefore(li, uploads.firstChild);
			updateLinks();
		}

		if(length > 2) showMsg(".msg-container", "Images successfully uploaded", "success");
		else showMsg(".msg-container", "Image successfully uploaded", "success");
	}
	var upload = function (files) {
		var formData = new FormData(), 
		xhr = new XMLHttpRequest(),
		index;
		for(index=0; index<files.length; index+=1){
			formData.append('file[]', files[index]);
		}
		xhr.onload = function () {
			var data = JSON.parse(this.responseText);
			if(data.status == 'success') displayUploads(data);
			else if(data.status == 'error') showMsg(".msg-container", "Error uploading image", "error");
		}
		xhr.open('post', 'handle_gallery_add.php');
		xhr.send(formData);


	}
	var removeFile = function(src){
		xhr = new XMLHttpRequest();
		xhr.onload = function () {
			var data = JSON.parse(this.responseText);
			if (data.status == 'success') {
				var div = draggedItem.parentNode;
				removeElement(div);
				showMsg(".msg-container", "Image successfully removed", "success");
	      	} 
	      	else if(data.status == 'error') {
				showMsg(".msg-container", "Error removing image", "error");
	      	}
		}

		xhr.open('post', 'handle_gallery_delete.php', false);
		xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xhr.send("file="+src);
	}

	dropzoneAdd.ondrop = function (e) {
		e.preventDefault();
		this.className = 'dropzone';
		if(e.dataTransfer.files.length < 1){
			showMsg(".msg-container", "Something went wrong, try again", "error");
			return false;
		}
		else
			upload(e.dataTransfer.files);
	}
	dropzoneAdd.ondragover = function () {
		this.className = 'dropzone dragover';
		return false;
	}
	dropzoneAdd.ondragleave = function () {
		this.className = 'dropzone';
		return false;
	}
	dropzoneDel.ondrop = function (e) {
		e.preventDefault();
		this.className = 'dropzone';
		var data = e.dataTransfer.getData('text');
		if(typeof data == 'string') removeFile(data);
	}
	dropzoneDel.ondragleave = function () {
		this.className = 'dropzone';
		return false;
	}
	dropzoneDel.ondragover = function () {
		this.className = 'dropzone dragover-danger';
		return false;
	}
	updateLinks();
	var images = document.querySelectorAll('#list img');
	for(i=0; i<images.length; i++){
		images[i].setAttribute('draggable', true);
		images[i].ondragstart = function(event) {drag(event)};
	}
}());