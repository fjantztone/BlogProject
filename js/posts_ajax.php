<?php
    // Sets the proper content type for javascript
    header("Content-type: application/javascript");
    include_once('../includes/config.php');
?>

function showMsg (target, msg, state) {
    if(state === "success")
        var message = $("<p class='bg-success'>"+msg+"</p>");
    if(state === "error")
        var message = $("<p class='bg-danger'>"+msg+"</p>");

    $('html, body').animate({ scrollTop: $(target).offset().top }, 'slow');       
    $(target).prepend(message.hide().fadeIn(1000).fadeOut(1000));
}
function initMCE (target) {
    tinymce.init({
        mode: "exact",
        width: "500",
        height: "400",
        selector: target,
        convert_urls:true,
        relative_urls:false,
        remove_script_host:false,
        plugins: [
            "advlist autolink lists link image charmap preview anchor",
            "searchreplace visualblocks code fullscreen",
            "insertdatetime media contextmenu paste"
        ],
        toolbar: "styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
        menubar: false,
        file_browser_callback: imgBrowser,
        setup: function(ed) {
            ed.on('change', function(e) {
                userData.validate({content: ed.getContent()}, function (data) {
                    var data = JSON.parse(data);
                    $('.msg-container').empty();
                    if(data.status === 'invalid'){
                        $.each(data.msg, function (i, msg) {
                            $('.msg-container').append("<p class='bg-danger'>"+msg+"</p>");
                        })
                    }
                    else
                        $('.msg-container').empty();
                })
            });
        }
    });
}
function imgBrowser (field_name, url, type, win) {

    var cmsURL = 'gallery.php?field=' + field_name;

    tinymce.activeEditor.windowManager.open({
        file : cmsURL,
        title : 'Select an image',
        width : 600,  
        height : 600,
        resizable : "yes",
        inline : "yes",  
        close_previous : "yes"
    }, {
        window : win,
        input : field_name
    });
    return false;
}
function initClick(){
    if($('#edit-post .posts').find('div').length == 0){ 
        setTimeout(function(){initClick()}, 500); //Server response
    }
    $('#edit-post .posts').find('div span.btn-edit').on('click', function () {
        var scope = $(this);
        $('.edit-form').toggleClass('hidden');
        tinymce.get('edit-content').focus();
        userData.getById({id: $(this).attr('data-id')}, function (data) {
            var data = JSON.parse(data);
            tinymce.activeEditor.setContent(data[0].content);
            $('.edit-form #post_id').attr('value', scope.attr('data-id'));
        })
    });
    $('#edit-post .posts').find('div span.btn-remove').on('click', function () {
        var scope = $(this);
        var res = confirm("Do you want to remove the post?");
        if(res == true){
            userData.deleteObject({id: scope.attr('data-id')}, function (data) {
                var data = JSON.parse(data);
                if(data.status === 'success'){
                    initContent();
                    showMsg(".msg-container", "Your blog post were successfully removed!", "success");
                }
            });
        }
        else
            return false;
    });
    $('#edit-post .posts').find('div span.btn-exp').on('click', function () {
        var scope = $(this);
        userData.getById({id: $(this).attr('data-id')}, function (data) {
            var data = JSON.parse(data);
            $('#prevModal').modal();

            $('#prevModal').on('shown.bs.modal', function(){
                $('#prevModal .modal-content').html(data.content);
            });
           $('#prevModal').on('hidden.bs.modal', function(){
                $('#prevModal .modal-content').html('');
            });                    

        });


    });

}
function stripContent (data, posts) {
    $(posts).empty();
    $.each(data, function (i, item) {
        var postCount = "post-" + (i+1);

        item.shortContent = item.content.substr(0, item.content.search(/(<\/h1>)/gi)+"</h1>".length);
        if(item.shortContent.length < 5){
            item.shortContent = "";
        }
        var stripTag = /(\<([^>]+)\>)/gi;
        var cleanContent = item.content.replace(stripTag, "");
        var words = cleanContent.substr(item.shortContent.replace(stripTag, "").length).split(" ");
        item.shortContent += words.slice(0, 40).join(" ");
        if(words.length > 40){
            item.shortContent += "<span class='btn-exp' data-id="+item.id+">[..]</span>";
        }



        $(posts).append("<div id="+postCount+">"+
            "<span class='btns'>"+
            "<span class='glyphicon glyphicon-trash btn-remove' data-id="+item.id+"></span>"+
            "<span class='glyphicon glyphicon-pencil btn-edit' data-id="+item.id+"></span>"+
            "</span><div><pre>"+item.shortContent+"</pre></div></div>");
    });  
}
function initContent(){
    userData = new UserData('#edit-post .posts');
    userData.table = 'postsb';
    userData.getByUserId(<?php echo $_SESSION['user']->get_id()?>, {order: 'date', limit: 5}, function(data){
        var data = JSON.parse(data);
        stripContent(data, '#edit-post .posts');
        initCalendar(data);
          
    });
    initClick();
}

function updateContent(){
    $('form').on('submit', function (event) {
        event.preventDefault();
        tinymce.triggerSave();
        var data = $(this).serializeObject();
        
        if($(this).attr('name') == 'editForm'){
            userData.update(data, function(data){
                var data = JSON.parse(data);
                if(data.status === 'success'){
                    $('.edit-form').addClass('hidden');
                    initContent();
                    showMsg(".msg-container", "Your blog post were successfully updated!", "success");
                }
            });
        }
        if($(this).attr('name') == 'addForm'){
            userData.insertObject(data, function(data){
                var data = JSON.parse(data);
                if(data.status === 'success'){
                    tinymce.activeEditor.setContent('');
                    initContent();
                    window.location.href = '#edit-post';
                    showMsg(".msg-container", "Your blog post were successfully added!", "success");
                }
                else
                    showMsg(".msg-container", data.error, "error");
            });
        }                

    });
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
function initContentByDate(year, month, day){           
    userData.getByDate(<?php echo $_SESSION['user']->get_id()?>, {year: year, month: month, day: day, order: 'date'}, function (data) {
        var data = JSON.parse(data);
        if(data.length > 0){
            stripContent(data, '#edit-post .posts');
            initClick();
        }

    });
    
}
function setCalendar(startDate, endDate, enabledDays){
    $('#date').datepicker('remove');
    $("#date").datepicker({
        language: "pl",
        autoclose: true,
        weekStart: 1,
        startDate: startDate,
        endDate: endDate,
        format: 'yyyy-mm-dd',
        beforeShowDay: function(date){
            var formattedDate = date.toLocaleDateString('pl',{year:'numeric',month:'2-digit', day:'2-digit'});
            if ($.inArray(formattedDate.toString(), enabledDays) != -1){
                return {
                    enabled : true
                };
           }
           return false;
        }
        }).on('changeDate', function (e) {
            var date = $("#date").datepicker('getFormattedDate').split('-');
            initContentByDate(date[0], date[1], date[2]);
    });
}
function initCalendar(data){
    var endDate = data[0].date.split(' ')[0];
    var startDate = data[data.length-1].date.split(' ')[0];
    var enabledDays = [];
    $.each(data, function (i, item) {
        dateF = item.date.split(' ')[0];
        dateP = dateF.split('-').reverse();
        dateN = dateP.join('.');
        enabledDays.push(dateN);
    });

    setCalendar(startDate, endDate, enabledDays);
}
$(function(){
    window.onhashchange = function (){
        $('.msg-container').empty();
    }
    initMCE("#add-content");
    initMCE("#edit-content");
    initContent();
    updateContent();    
});
