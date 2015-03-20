function UserData(postSelector){
	var table = '';
	$(postSelector).empty(); 
		
	this.insertObject = function (params, callback) {
		params.table = this.table;
		params.method = 'insert';
		$.get('http://localhost/Blog/api_driver.php', params, callback);
	}
	this.getByAll = function (callback, params) {
		if(params == null) params={};
		params.table = this.table;
		params.method = 'getByAll';
		$.get('http://localhost/Blog/api_driver.php', params, callback);
	}
	this.getByUserId = function (user_id, params, callback) {
		params.table = this.table;
		params.user_id = user_id;
		params.method = 'getByUserId';
		$.get('http://localhost/Blog/api_driver.php', params, callback);
	}		
	this.getById = function (params, callback) {
		params.table = this.table;
		params.method = 'getById';
		$.get('http://localhost/Blog/api_driver.php', params, callback);
	}
	this.getByDate = function (user_id, params, callback) {
		params.table = this.table;
		params.user_id = user_id;
		params.method = 'getByDate';
		$.get('http://localhost/Blog/api_driver.php', params, callback);
	}	
	this.getComments = function (params, callback) {
		params.method = 'getComments';
		$.get('http://localhost/Blog/api_driver.php', params, callback);
	}	
	this.getRating = function (params, callback) {
		params.method = 'getRating';
		$.get('http://localhost/Blog/api_driver.php', params, callback);
	}
	this.update = function (params, callback) {
		params.table = this.table;
		params.method = 'update';
		$.get('http://localhost/Blog/api_driver.php', params, callback);
	}
	this.deleteObject = function (params, callback) {
		params.table = this.table;
		params.method = 'delete';
		$.get('http://localhost/Blog/api_driver.php', params, callback);
	}	
	this.validate = function (params, callback) {
		params.table = this.table;
		params.method = 'validate';
		$.get('http://localhost/Blog/api_driver.php', params, callback);
	}
	
}
