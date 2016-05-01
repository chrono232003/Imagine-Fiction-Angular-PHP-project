(function() {
	var app = angular.module('home', ['ngCookies']);
	
	app.controller('StoryController', ['$scope', '$http', function($scope, $http) {
		$http.get('../php/story.php').success(function(response) {
				$scope.storyList = response;
			});
	}]);
	
	app.controller('CategoryController', ['$scope', '$http', function($scope, $http) {
		$http.get('../php/categoryList.php').success(function(response) {
			$scope.catList = response;
			
		});
		$scope.getCatDetails = function(category) {
			$http.get('../php/categoryRes.php?CatID=' + category).success(function(response) {
				$scope.catRes = response;
			});
		};
	}]);
	
	app.directive('header', function() {
		return {
			restrict:"E",
			templateUrl:"..//pages/header.html"
		}
	});
	app.controller('UserAuthController', ['$scope', '$http', '$cookies', function($scope, $http, $cookies) {
		$scope.getUserInfo = function(user, pass) {
			$http.get('../php/loginProc.php?User=' + $scope.username + "&Pass=" + $scope.pass).success(function(response) {
				$scope.catRes = response;
				$cookies.session = "session";
				$scope.isSession = $cookie.session;  
			});
		};
	}]);
})();