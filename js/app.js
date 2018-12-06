(function() {
	var app = angular.module('home', ['ngCookies', 'ngSanitize']);

	//directives
	app.directive('header', function() {
		return {
			restrict:"E",
			templateUrl:"directives/header.html"
		}
	});

	app.directive('footer', function() {
		return {
			restrict:"E",
			templateUrl:"directives/footer.html"
		}
	});

//controllers
	app.controller('StoryController', ['$scope', '$http', function($scope, $http) {
		function conditionStoryHomePage(data) {
			for (var i = 0; i < data.length; i++) {
				data[i].Story = data[i].Story.substring(0,500) + "<a href = 'story.html?ID=" + data[i].ID + "'> ... Read More</a>";
			}
			return data;
		}
		$http.get('php/story.php').then(function(response) {
				var storyData = conditionStoryHomePage(response.data);
				$scope.storyList = storyData;
			}).catch(function(e) {
					console.log("Error: " + e);
			});
	}]);

	app.controller('CategoryController', ['$scope', '$http', function($scope, $http) {
		function conditionStoryHomePage(data) {
			for (var i = 0; i < data.length; i++) {
				data[i].Story = data[i].Story.substring(0,300) + "<a href = 'story.html?ID=" + data[i].ID + "'> ... Read More</a>";
			}
			return data;
		}
		$http.get('php/categoryList.php').then(function(response) {
			$scope.catList = response.data;
		}).catch(function(e) {
				console.log("Error: " + e);
		});

		//function that gets called when a category is chosen. Returns a list of stories in that category.
		$scope.getCatDetails = function(category) {

			var request = $http({
				method: "post",
				url: "php/categoryRes.php",
				data: {
					category:category
				},
				headers: {'Content-Type': 'application/x-www-form-urlencoded' }
			})

			request.then(function(response) {
					var storyData = conditionStoryHomePage(response.data);
					$scope.catRes = storyData;
			}).catch(function(e) {
					console.log("Error: " + e);
			});
		};
	}]);

	app.controller('WriteController', ['$scope', '$http', function($scope, $http) {

		$http.get('php/categoryList.php').then(function(response) {
			$scope.catList = response.data;
		}).catch(function(e) {
				console.log("Error: " + e);
		});

		$scope.submitStory = () => {

			var request = $http({
				method: "post",
				url: "php/submitStory.php",
				data: {
					//imageFile: $scope.storyImageFile,
					title:$scope.storyTitle,
					genre: $scope.storyGenre,
					content: $scope.storyContent
				},
				headers: {'Content-Type': 'application/x-www-form-urlencoded' }
			})

			request.then(function(response) {
					console.log(response);
			}).catch(function(e) {
					console.log("Error: " + e);
			});
		};
	}]);

	app.controller('UserAuthController', ['$scope', '$http', '$cookies', function($scope, $http, $cookies) {
		$scope.getUserInfo = () => {

			var request = $http({
				method: "post",
				url: "php/loginProc.php",
				data: {
					user: $scope.username,
					pass: $scope.pass
				},
				headers: {'Content-Type': 'application/x-www-form-urlencoded' }
			})

			request.then(function(response) {
				 	$scope.catRes = response;
					$cookies.session = "session";
					$scope.isSession = $cookie.session;
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

	app.controller('GetStoryController', ['$scope', '$http', function($scope, $http) {
		function getStoryID() {
			var IDString = window.location.search;
			return IDString.substring(IDString.indexOf("=")+1);
		}
		var request = $http({
			method: "post",
			url: "php/getStory.php",
			data: {
				storyID: getStoryID()
			},
			headers: {'Content-Type': 'application/x-www-form-urlencoded' }
		})

		request.then(function(response) {
				$scope.story = response.data[0];
		}).catch(function(e) {
				console.log("Error: " + e);
		});
	}]);

	app.controller('RegistrationController', ['$scope', '$http', function($scope, $http) {
		$scope.setRegistration = () => {
		var request = $http({
			method: "post",
			url: "php/register.php",
			data: {
				user: $scope.username,
				email: $scope.email,
				password: $scope.psw
			},
			headers: {'Content-Type': 'application/x-www-form-urlencoded' }
		})

		request.then(function(response) {
				$scope.story = response.data[0];
		}).catch(function(e) {
				console.log("Error: " + e);
		});
	};
	}]);

})();
