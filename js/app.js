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

	//form validation directives
	app.directive('valueMatches', ['$parse', function ($parse) {
    return {
      require: 'ngModel',
        link: function (scope, elm, attrs, ngModel) {
          var originalModel = $parse(attrs.valueMatches),
              secondModel = $parse(attrs.ngModel);
          // Watch for changes to this input
          scope.$watch(attrs.ngModel, function (newValue) {
            ngModel.$setValidity(attrs.name, newValue === originalModel(scope));
          });
          // Watch for changes to the value-matches model's value
          scope.$watch(attrs.valueMatches, function (newValue) {
            ngModel.$setValidity(attrs.name, newValue === secondModel(scope));
          });
        }
      };
    }]);

 app.controller('UserAuthController', ['$scope', '$http', '$cookies', function($scope, $http, $cookies) {

	 $scope.isSession = $cookies.get('session');
	 $scope.username = $cookies.get('username');

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
				 $scope.userResponse = response.data;
				 //$cookies.session = response.data[0].Username;
				 $cookies.put('username', response.data[0].Username)
				 $cookies.put('session', true)
				 $scope.isSession = $cookies.get('session');
				 $scope.username = $cookies.get('username');
		 }).catch(function(e) {
				 console.log("Error: " + e);
		 });
	 };

	 $scope.logout = () => {
		 $cookies.remove('username');
		 $cookies.remove('session');
		 location.reload();
	 }

 }]);

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
				email: $scope.email,
				user: $scope.username,
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

	app.controller('UserVerificationController', ['$scope', '$http', function($scope, $http) {
		function getKey() {
			var IDString = window.location.search;
			return IDString.substring(IDString.indexOf("=")+1);
		}
		$scope.setRegistration = () => {
		var request = $http({
			method: "post",
			url: "php/verifyUser.php",
			data: {
				key: getKey()
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
