(function() {
    var app = angular.module('piece-directives', []);

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

    app.directive('allMeasures', function(){
       return {
           restrict: 'E',
           templateUrl: 'templates/all-measures.html'
       };
    });

    /*app.directive('allRecipes', function(){
        return {
            restrict: 'E',
            templateUrl: 'templates/all-recipes.html'
        };
    });

    app.directive('allMenus', function(){
        return {
            restrict: 'E',
            templateUrl: 'templates/all-menus.html'
        };
    });*/
})();