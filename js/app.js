(function() {
	var app = angular.module('home', ['ngCookies']);

	//directives
	app.directive('header', function() {
		return {
			restrict:"E",
			templateUrl:"../directives/header.html"
		}
	});

//controllers
	app.controller('StoryController', ['$scope', '$http', function($scope, $http) {
		$http.get('../php/story.php').then(function(response) {
				$scope.storyList = response.data;
			}).catch(function(e) {
					console.log("Error: " + e);
			});
	}]);

	app.controller('CategoryController', ['$scope', '$http', function($scope, $http) {
		$http.get('../php/categoryList.php').then(function(response) {
			$scope.catList = response.data;
		}).catch(function(e) {
				console.log("Error: " + e);
		});
		$scope.getCatDetails = function(category) {
			// $http.get('../php/categoryRes.php?CatID=' + category).then(function(response) {
			// 	$scope.catRes = response;
			// }).catch(function(e) {
			// 		console.log("Error: " + e);
			// });
		};
	}]);

	app.controller('UserAuthController', ['$scope', '$http', '$cookies', function($scope, $http, $cookies) {
		$scope.getUserInfo = () => {

			var request = $http({
				method: "post",
				url: "../php/loginProc.php",
				data: {
					user: $scope.username,
					pass: $scope.pass
				},
				headers: {'Content-Type': 'application/x-www-form-urlencoded' }
			})

			request.then(function(response) {
					console.log("Response: " + response);
			}).catch(function(e) {
					console.log("Error: " + e);
			});

			// $http.get('../php/loginProc.php?User=' + $scope.username + "&Pass=" + $scope.pass).then(function(response) {
			// 	$scope.catRes = response;
			// 	$cookies.session = "session";
			// 	$scope.isSession = $cookie.session;
			// });
		};
	}]);
})();
