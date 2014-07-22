
function commentsController($scope, $http)
{


	var link_all = 'http://staze.org/note?method=index';

	console.log(baseUrl);
	

		function request_baza(link) {

		$http({method: 'POST', url: link }).success(function(data)
					{
						$scope.posts = data; // response data 
						var str = data;
						var res = str.substring(34, str.length-8);
						$scope.wynik = angular.fromJson(res);
				    });

    return $scope.wynik ;                
};


request_baza(link_all);


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
		 
			 request_baza(link_all);


		 });
			

    };

$scope.showPost = function(index,n){
		n = 1;
		if (n && n !== $scope.flag) {
            $scope.flag = n;
       
       $scope.no_high = 'no_hide';
       console.log($scope.wynik[index].id);
		
		$http({method: 'POST', url: 'http://staze.org/note?method=show&id='+$scope.wynik[index].id}).success(function(data)
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
        
		

		$http({method: 'POST', url: 'http://staze.org/note?method=delete&id='+$scope.wynik[index].id}).success(function(data)
		 {
			 console.log("wyslanie postu....");
			 request_baza(link_all);


		 });
			

    };
		



}


