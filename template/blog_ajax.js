function check_image (src, i, callback) {
	var img = new Image();
	img.index = i;
	img.onload = callback;
	img.src = src;
}
function FilterByDate(post_selector, year_selector, month_selector, undefined){
	if(typeof post_selector != 'string')
		post_selector = '.post';
	if(typeof year_selector != 'string')
		year_selector = '.year';
	if(typeof month_selector != 'string')
		month_selector = '.month';

	this.set_year = function(year){
		_year = year;
		_data.year = year;
		year_slot.text(' ' + scope.get_year() + ' ');
		month.each(function (index){
			$(this).children().attr('href', scope.get_year()+'-0'+(index+1));
		});
	}
	this.get_year = function(){
		return _data.year;
	}
	this.get_data = function () {
		return _data;
	}
	this.next_year = function () {
		scope.set_year(scope.get_year()+1);
		scope.update_data();

	}
	this.prev_year = function () {
		scope.set_year(scope.get_year()-1);
		scope.update_data();
	}
	this.update_data = function (month, undefined) {
		var data = {'year':scope.get_year()};
		if(month !== undefined)
			data.month = month;
		$.get('index_ajax.php', data, function(data){
			posts.empty();
			var json = JSON.parse(data);
			if(json.length != 0){
				for(i=0; i<json.length; i++){
					posts.append('<a href="'+json[i]['id']+'"><h1>'+json[i]['title']+'</h1></a><hr><p><span class="glyphicon glyphicon-time"> '+json[i]['date']+'</span></p><hr><span class="post-img"></span><p>'+json[i]['content']+'</p><hr>');	
					
					var img = check_image(json[i]['image'], i, function () {
						var post = posts.find('.post-img:nth('+this.index+')');
						post.append('<img class="img-responsive" src="'+this.src+'" alt=""><hr>');
					});

				}
				filterByPost.set_links();

			}
			else
				posts.html('<p class="lead">No posts found</p><p>There are no posts avaiable.</p></hr>');
		});	
	}
	
	var currentTime = new Date();
	var _year;
	var _data = {};
	var posts = $(post_selector);
	var year_slot = $(year_selector);
	var month = $(month_selector);
	var scope = this;
	var filterByPost = new FilterByPost('.col-posts','h1');
	
	this.set_year(currentTime.getFullYear());
	
	month.each(function (index){
		$(this).children().attr('href', scope.get_year()+'-0'+(index+1));
		$(this).children().on('click', function(event){
			event.preventDefault();
			scope.update_data(index+1);
		});
	});
	
	this.update_data();
}

function FilterByPost (post_selector, title_selector, undefined) {
	if(typeof post_selector != 'string')
		post_selector = '.posts';
	if(typeof title_selector != 'string')
		title_selector = '.title';

	var title = $(title_selector);
	var posts = $(post_selector);
	var _data = {};
	var scope = this;

	this.set_links = function () {
		title = $(title_selector);
		title.each(function () {
			$(this).on('click', function (event) {
				event.preventDefault();
				var id = $(this).parent().attr('href');
				scope.update_data(id);
			});
		});
	}

	this.update_data = function (id) {
		_data.id = id;
		$.get('index_ajax.php', _data, function (data) {
			posts.empty();
			if(data.length > 0){
				var json = JSON.parse(data);
				if(json.post){
					$(json.post).each(function () {
						posts.append('<h1>'+this.title+'</h1><hr><p><span class="glyphicon glyphicon-time"> '+this.date+'</span></p><hr><span class="post-img"></span><p>'+this.content+'</p><hr>');
						var img = check_image(this.image, 0, function (){
							var post = posts.find('.post-img');
							post.append('<img class="img-responsive" src="'+this.src+'" alt=""><hr>');
						});
					});
					posts.append('<div class="well"><h4>Leave a comment:</h4><form role="form" class="form-comment"><div class="form-group"><input type="hidden" name="post_id" value="'+_data.id+'"></input><input type="hidden" name="user_id" value="13"></input><input type="hidden" name="username" value="Olle"></input><textarea class="form-control" name="content" rows="3"></textarea></div><button type="submit" onclick="handle_comment(event)" class="btn btn-primary btn-comment">Submit</button></form></div>')
				}
				if(json.post_comments){
					$(json.post_comments).each(function (index) {
						posts.append('<div class="media"><a class="pull-left" href="#"><span class="comment-img"></span></a><div class="media-body"><h4 class="media-heading"><a href="#">'+this.username+'</a><small> '+this.date+'</small></h4>'+this.content+'</div></div>');
						var img = check_image(this.image, index, function () {
							$('.media:nth('+this.index+') .comment-img').append('<img class="media-object" src="'+this.src+'" alt="">');
						});						
					});
				}
			}
			else
				console.log('err');
		})
	} 
	this.set_links();
}
var filter = new FilterByDate('.col-posts', "#year", 'li');

function handle_comment (ev) {
	ev.preventDefault();
	var form = $('form');
	var textarea = $('form textarea');
	var posts = $('.col-posts');
	form.find('p:first').remove();
	if(textarea.val() === "") textarea.after('<p class="text-danger">Input required</p>');
	else{
		$.post('index_ajax.php', form.serialize(), function (data) {
			if(data.length > 0){
				textarea.val('');
				var json = JSON.parse(data);
				$(json).each(function () {
					var comment = $('<div class="media"><a class="pull-left" href="#"><span class="comment-img"></span></a><div class="media-body"><h4 class="media-heading"><a href="#">'+this.username+'</a><small> '+this.date+'</small></h4>'+this.content+'</div></div>');
					if($('.media').length > 0)
						$('.media:first').before(comment);
					else
						posts.append(comment);
					var img = check_image(this.image, 0, function () {
						$('.media:first .comment-img').append('<img class="media-object" src="'+this.src+'" alt="">');
					});
				});
			}
		});
	}
}
$(".btn-min").css({'font-size': 10});

$('#btn-prev').on('click', function (event) {
	event.preventDefault();
	filter.prev_year();

});

$('#btn-next').on('click', function (event) {
	event.preventDefault();
	filter.next_year();
});