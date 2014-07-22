function commentsController($scope, $http)
{


	var link_all = baseUrl+'note?method=index';

	console.log(baseUrl);

		function data_cut(dana) {
			var dana;
			var str = dana;
			var res = str.substring(34, str.length-8);
			return res ;
		} ;





	
	


		function request_baza(link) {

		$http({method: 'POST', url: link }).success(function(data)
					{
						$scope.posts = data;
						var res = data_cut(data);
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

		$http({method: 'POST', url: baseUrl+'note?method=add&title='+formData.title+'&content='+formData.content}).success(function(data)
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

		$http({method: 'POST', url: baseUrl+'note?method=show&id='+$scope.wynik[index].id}).success(function(data)
			{
				$scope.posts = data; // response data 
				var res = data_cut(data);
				$scope.wynik = angular.fromJson(res);
				$scope.wynik.splice(index,1);


		    });
 };

};

$scope.removePost = function(index)
	{
        


		$http({method: 'POST', url: baseUrl+'note?method=delete&id='+$scope.wynik[index].id}).success(function(data)
		 {
			 console.log("wyslanie postu....");
			 request_baza(link_all);


		 });


    };




}
