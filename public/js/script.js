

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
        
        formData = $scope.form;
        console.log(formData);
    	console.log(formData.title);
		var inde = 'index';

		$http({method: 'POST', url: 'http://staze.org/note?method=add&title='+formData.title+'&content='+formData.content}).success(function(data)
		 {
			 console.log("wyslanie postu....");
			 $scope.form = "";
		 

			 $http({method: 'POST', url: 'http://staze.org/note?method=index'}).success(function(data)
			{
				$scope.posts = data; // response data 
				var str = data;
				var res = str.substring(25, str.length-5);
				$scope.wynik = angular.fromJson(res);
				console.log("odbieranie bazy....");
		    });


		 });
			

    };

// index : index of global DOM
$scope.deleteComment = function(index){
// Angular AJAX call
/*method : "POST",
url : 'http://staze.org/note?method=index'+$scope.wynik[index].id,
}).success(function(data){
	console.log("klikanie postu....");
// Removing Data from Global DOM
$scope.wynik.splice(index,1);
});
*/
var test = $scope.wynik[index].id;
console.log(test);
$http({method: 'POST', url: 'http://staze.org/note?method=show&id='+$scope.wynik[index].id}).success(function(data)
			{
				$scope.posts = data; // response data 
				var str = data;
				var res = str.substring(25, str.length-5);
				$scope.wynik = angular.fromJson(res);

				console.log("klikanie postu....");
				console.log(data);
				$scope.wynik.splice(index,1);
		    });


}
}


