

function commentsController($scope, $http)
{

$http({method: 'POST', url: 'http://staze.org/note?method=index'}).success(function(data)
			{
				$scope.posts = data; // response data 
				var str = data;
				var res = str.substring(25, str.length-5);
				$scope.wynik = angular.fromJson(res);
		    });

$scope.submitForm = function()
	{
        console.log("posting data....");
        formData = $scope.form;
        console.log(formData);
    	console.log(formData.title);
		var inde = 'index';

		$http({method: 'POST', url: 'http://staze.org/note?method=add&title='+formData.title+'&content='+formData.content}).success(function(data)
		 {
			 console.log("wyslany ajzol....");
			 $scope.form = "";
		 

			 $http({method: 'POST', url: 'http://staze.org/note?method=index'}).success(function(data)
			{
				$scope.posts = data; // response data 
				var str = data;
				var res = str.substring(25, str.length-5);
				$scope.wynik = angular.fromJson(res);
				console.log("odbierany ajzol....");
		    });


		 });
			

    };

// index : index of global DOM
$scope.deleteComment = function(index){
// Angular AJAX call
$http({
method : "GET",
url : "index.php?action=delete&id="+$scope.comments[index].id,
}).success(function(data){
// Removing Data from Global DOM
$scope.comments.splice(index,1);
});
}
}



//var demo = angular.module('demo',[]);



/*demo.controller('PostsCtrlAjax',

function($scope, $http){

$http({method: 'POST', url: 'http://staze.org/note?method=index'}).success(function(data)
			{
				$scope.posts = data; // response data 
				var str = data;
				var res = str.substring(25, str.length-5);
				$scope.wynik = angular.fromJson(res);
		    });





});

demo.controller('FormCtrl',function($scope, $http){

		$scope.submitForm = function() {
        console.log("posting data....");
        formData = $scope.form;
        console.log(formData);
    	console.log(formData.title);
		var inde = 'index';

$http({method: 'POST', url: 'http://staze.org/note?method=add&title='+formData.title+'&content='+formData.content}).success(function(data)
{
 console.log("wyslany ajzol....");
 });


    };


});
*/