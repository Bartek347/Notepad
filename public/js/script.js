

function commentsController($scope, $http)
{

$http({method: 'POST', url: 'http://projekt1.com/note?method=index'}).success(function(data)
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

		$http({method: 'POST', url: 'http://projekt1.com/note?method=add&title='+formData.title+'&content='+formData.content}).success(function(data)
		 {
			 console.log("wyslanie postu....");
			 $scope.form = "";
		 

			 $http({method: 'POST', url: 'http://projekt1.com/note?method=index'}).success(function(data)
			{
				$scope.posts = data; // response data 
				var str = data;
				var res = str.substring(25, str.length-5);
				$scope.wynik = angular.fromJson(res);
				console.log("odbieranie bazy....");
		    });


		 });
			

    };

$scope.showPost = function(index,n){
		n = 1;
		if (n && n !== $scope.flag) {
            $scope.flag = n;
       
       $scope.no_high = 'no_hide';
       console.log($scope.wynik[index].id);
		
		$http({method: 'POST', url: 'http://projekt1.com/note?method=show&id='+$scope.wynik[index].id}).success(function(data)
			{
				$scope.posts = data; // response data 
				var str = data;
				var res = str.substring(25, str.length-5);
				$scope.wynik = angular.fromJson(res);
				$scope.wynik.splice(index,1);


		    });
 };

};

$scope.removePost = function(index)
	{
        
		

		$http({method: 'POST', url: 'http://projekt1.com/note?method=delete&id='+$scope.wynik[index].id}).success(function(data)
		 {
			 console.log("wyslanie postu....");
			 
		 

			 $http({method: 'POST', url: 'http://projekt1.com/note?method=index'}).success(function(data)
			{
				$scope.posts = data; // response data 
				var str = data;
				var res = str.substring(25, str.length-5);
				$scope.wynik = angular.fromJson(res);
				console.log("odbieranie bazy....");
		    });


		 });
			

    };
		



}


