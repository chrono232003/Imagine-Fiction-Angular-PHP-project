(function() {
	var app = angular.module('home', ['ngCookies']);

	app.controller('StoryController', ['$scope', '$http', function($scope, $http) {
		$http.get('../php/story.php').then(function(response) {
				$scope.storyList = response;
			}).catch(function(e) {
					console.log("Error: " + e);
			});
	}]);

	app.controller('CategoryController', ['$scope', '$http', function($scope, $http) {
		$http.get('../php/categoryList.php').then(function(response) {
			$scope.catList = response;
		}).catch(function(e) {
				console.log("Error: " + e);
		});
		$scope.getCatDetails = function(category) {
			$http.get('../php/categoryRes.php?CatID=' + category).then(function(response) {
				$scope.catRes = response;
			}).catch(function(e) {
					console.log("Error: " + e);
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
			$http.get('../php/loginProc.php?User=' + $scope.username + "&Pass=" + $scope.pass).then(function(response) {
				$scope.catRes = response;
				$cookies.session = "session";
				$scope.isSession = $cookie.session;
			});
		};
	}]);
})();
