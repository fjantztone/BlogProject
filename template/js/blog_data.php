<?php
    // Sets the proper content type for javascript
    header("Content-type: application/javascript");
?>
function Blog (postsSelector, calendarSelector, wallSelector, commentsSelector, rateSelector) {
	if(typeof postsSelector != 'string')
		postSelector = '#posts';
	if(typeof calendarSelector != 'string')
		calendarSelector = '#calendar';
	if(typeof wallSelector != 'string')
		calendarSelector = '#wall';
	if(typeof commentsSelector != 'string')
		commentsSelector = '#comments';	
	if(typeof rateSelector != 'string')
		commentsSelector = '#rate';
	
	var posts = $(postsSelector);
	var calendar = $(calendarSelector);
	var wall = $(wallSelector);
	var comments = $(commentsSelector);
	var rate = $(rateSelector);
	
	var scope = this;
	
	var endDate;
	var startDate;
	var enabledDays = [];
	var postChanges = [];
	
	userData = new UserData(postsSelector);
	
	this.initPosts = function (table) {

		userData.table = table;
		userData.getByUserId(UserInfo.config.id, {limit: 5, order: 'date'}, function(data){
			var data = JSON.parse(data);
			if(Object.keys(data).length){
				posts.html('');
				comments.html('');
				$('#commentForm').addClass('hidden');				
				$.each(data, function (i, item) {
					var sContent = scope.stripPost(item.content, item.id);
					$.each(sContent, function(i, item){
						posts.append(item);
					});
					
				});
			}
			return;

		});
	}
	this.initDates = function (table){
		userData.table = table;
		userData.getByUserId(UserInfo.config.id, {order: 'date'}, function(data){
			var data = JSON.parse(data);
			if(Object.keys(data).length){
				
				endDate = data[0].date.split(' ')[0];
				startDate = data[data.length-1].date.split(' ')[0];
				
				var res = false;
				$.each(data, function(i, item){

					if($.inArray(item.date, postChanges) == -1){ //Post changes should be looked for, when users are visiting the page.
						postChanges.push(item.date);
						res = true;

					}

					item.date = item.date.split(' ')[0].split('-').reverse();
					item.date = item.date.join('.');
					enabledDays.push(item.date);


				});

				if(res){
					enabledDays = [];
					scope.initDates('postsb');
				}
				scope.setCalendar();
				scope.initPosts('postsb');
				scope.initWall('walls');
				scope.initRating('ratings');
				scope.checkRating('ratings');
				scope.checkSub('subscribers');
			}
			return;
		});

	}
	this.initWall = function (table) { //Its ok to let wall changes be available on page reload.
		userData.table = table;
		userData.getByUserId(UserInfo.config.id, {}, function(data){
			var data = JSON.parse(data);
			if(Object.keys(data).length){
				wall.html("<h3>"+data[0].blog_name+"</h3>"+
					"<img class='img-responsive' src="+data[0].image+"></img>"+
					"<p class='text-justify'>"+data[0].content+"</p>");
			}
			return;
		});
	}
	this.initComments = function (postId){
		userData.getComments({post_id: postId}, function(data){
			var data = JSON.parse(data);
			if(Object.keys(data).length){
				if(data.error){
					bootbox.alert(data.error);
				}
				else{
					comments.html('');
					var str = "";
					$.each(data, function(i, item){
						if(item.user_id == GuestInfo.config.id){
							btnEdit = ' <a href="#" data-action="edit" data-id="'+item.id+'"><span class="glyphicon glyphicon-pencil" id="btn-edit"  aria-hidden="true"></span></a>';
							btnDel = ' <a href="#" data-action="remove" data-id="'+item.id+'" class="btn-danger"><span class="glyphicon glyphicon-remove" id="btn-del" data-id="'+item.id+'" aria-hidden="true"></span></a>';
						}
						comments.append('<div class="media">'+
							'<a class="pull-left" href="#">'+
							'<span class="comment-img"></span>'+
							'</a>'+
							'<div class="media-body">'+
							'<h4 class="media-heading">'+
							'<a href="'+item.url+'">'+item.username+'</a>'+
							'<small> '+item.date+'</small>'+btnEdit+btnDel+'</h4>'+
							'<p>'+item.content+'</p>'+
							'</div></div>');
						
					});			
				}
						
			}
			return;							
		})
	}

	this.insertComment = function (data, table){
		userData.table = table;
		var id = data.post_id;
		userData.insertObject(data, function(data){
			var data = JSON.parse(data);
			if(Object.keys(data).length){
				if(data.status == 'success'){
					scope.initComments(id);
				}
				
			}
		});
	}
	this.filterByDate = function (year, month, day, table) {

		userData.table = table;
		userData.getByDate(UserInfo.config.id, {year: year, month: month, day: day, order: 'date'}, function(data){
			var data = JSON.parse(data);
			if(Object.keys(data).length){
				posts.html('');
				comments.html('');
				$('#commentForm').addClass('hidden');				
				$.each(data, function (i, item) {
					var sContent = scope.stripPost(item.content, item.id);
					$.each(sContent, function(i, item){
						posts.append(item);
					});
					
				});					
			}
			return;
		})
	}
	this.filterById = function (postId, table) {
		
		userData.table = table;
		userData.getById({id: postId}, function (data) {
			var data = JSON.parse(data);

			if(Object.keys(data).length){
				posts.html('');
				$.each(data, function(i, item){
					posts.append(item.content);
				})
				scope.initComments(postId, 'comments');
				$('#commentForm').removeClass('hidden');
				$('#commentForm').find('input[name="post_id"]').val(postId);
						
			}
			return;			
		})
	}
	this.setCalendar = function () {
		$("#date").datepicker('remove');
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
	        });
	}
	this.initRating = function() {
		userData.getRating({rated_user: UserInfo.config.id}, function (data) {
			var data = JSON.parse(data);
			if(Object.keys(data).length){
				rate.rating('update', data.rating);
			}		
		});
		
	}
	this.checkRating = function(table) {
		userData.table = table;
		userData.getById({rated_by_user: GuestInfo.config.id}, function(data){
			var data = JSON.parse(data);
			if(Object.keys(data).length || (GuestInfo.config.id == UserInfo.config.id)){
				rate.rating('refresh', {disabled: true});
			}
			else{
				rate.rating('refresh', {disabled: false});
			}

		});		

	}
	this.setRating = function(value) {
		userData.insertObject({rated_by_user: GuestInfo.config.id, rated_user: UserInfo.config.id, rating: value}, function(data){
			var data = JSON.parse(data);
			if(data.status == 'success')
				scope.initRating();
			else
				alert(data.error);
		});
		
	}
	this.subBlog = function(table){
		userData.table = table;
		userData.insertObject({sub_by_user: GuestInfo.config.id, sub_user: UserInfo.config.id}, function (data) {
			var data = JSON.parse(data);
			if(data.status == 'success')
				$('#subscribeBlog').contents().last().replaceWith(' Unsubscribe blog');
		});
	}	
	this.unsubBlog = function(table){
		userData.table = table;
		userData.deleteObject({sub_by_user: GuestInfo.config.id, sub_user: UserInfo.config.id}, function (data) {
			var data = JSON.parse(data);
			if(data.status == 'success')
				$('#subscribeBlog').contents().last().replaceWith(' Subscribe blog');
		});
	}
	this.checkSub = function (table) {
		if(GuestInfo.config.id == UserInfo.config.id){
			$('#subscribeBlog').off('click').on('click', function(data){
				bootbox.alert('You cant subscribe your own blog!');
			});
		}
		userData.table = table;
		userData.getById({sub_by_user: GuestInfo.config.id, sub_user: UserInfo.config.id}, function (data) {
			var data = JSON.parse(data);
			if(Object.keys(data).length){
				$('#subscribeBlog').contents().last().replaceWith(' Unsubscribe blog');
			}

		});
	}

	this.stripPost = function (content, id){
		var elements = $("<div>" + content + "</div>");
		var words = [];
		var obj = {};

		header = $('h1', elements).wrap('<a href="#" data-id="'+id+'"></a>').parent().append('<hr>');
		img = $('img', elements).append('<hr>');


		$(elements).find('p').each(function(){
			words.push($(this).text());
		});

		words = words.join(' ').split(/\s+/);
		
		var sWords = words.slice(0, 40).join(' '); // 40 words shown
		var sContent = "<p>" + sWords;
		var btnExp = "";
		var dots = "";
		if(words.length > 40){
			btnExp = " <a class='btn btn-primary' data-id="+id+">Read more</a>";
			dots = "...";
		}
		sContent += dots + "</p>"+btnExp+"<hr>";

		obj.header = header.prop('outerHTML');
		obj.img = img.prop('outerHTML');
		obj.sContent = sContent;
		
		$.map(obj, function(v, k){
			if(typeof v == 'undefined' || v.length == 0){
				delete obj[k];
			}
		})
		return obj;

	}
	rate.rating({showClear:false, showCaption:false}).on('rating.change', function(event, value) {
		scope.setRating(value);
		rate.rating('refresh', {disabled: true});
	});

	this.initDates('postsb');
	
	posts.on("click", "a", function (event) {
		scope.filterById($(this).attr('data-id'), 'postsb');

	});
	
	$('form').on('submit', function(event){
		var data = $(this).serializeObject();
		scope.insertComment(data, 'comments');
		$(this).find('textarea').val('');
		event.preventDefault();
	})
	
	$('#date').on('changeDate', function (e) {
        var date = $("#date").datepicker('getFormattedDate').split('-');
        scope.filterByDate(date[0], date[1], date[2], 'postsb');
	});
	
	$('#latestPosts').on('click', function(){
		scope.initPosts('postsb');
	});	


	$('#subscribeBlog').on('click', function(e){
		var text = $(this).text();
		var msg = "Do you want to" + text + "?";
		bootbox.confirm(msg, function(res){
			if(res == true){
				console.log(text, res);
				if(text == ' Subscribe blog'){
					scope.subBlog('subscribers');
				}
				else if(text == ' Unsubscribe blog')
					scope.unsubBlog('subscribers');
			}
			else{
				return;
			}
			
		});
	});	
	var actions = {
		edit: function(){
			var textElement = $(this).closest('div').find('p');
			if(textElement.hasClass('editable')){
				userData.table = "comments";
			}
			var $text = textElement, isEditable=$text.is('.editable');
			textElement.prop('contenteditable', !isEditable).toggleClass('editable');


		},
		remove: function(){}
	}
	comments.on("click", 'a[data-action]', function(event){
		var link = $(this);
		action = link.data("action");
		event.preventDefault();

		if(typeof actions[action] === "function"){
			actions[action].call(this, event);
		}
	})
	setInterval(function(){
		scope.initDates('postsb');
	}, 1000*60*3);

}