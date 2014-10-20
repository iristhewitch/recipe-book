(function(){
    var app = angular.module('recipeDisplay', []);

    app.directive('recipeIngredients', function(){
        return {
            restrict: 'E',
            templateUrl: 'templates/display-recipe.html'
        };
    });
})();