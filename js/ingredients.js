(function() {
    var app = angular.module('ingredients-directives', []);

    app.directive('recipeIngredients', function () {
        return {
            restrict: 'E',
            templateUrl: '<p>This is a template</p>'//'templates/display-ingredients.html'
        };
    });

    app.directive('allIngredients', function () {
        return {
            restrict: 'E',
            templateUrl: 'templates/all-ingredients.html'
        };
    });

    app.directive('allTypes', function(){
       return {
         restrict: 'E',
         templateUrl: 'templates/all-types.html'
       };
    });
})();