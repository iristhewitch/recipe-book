(function() {
    var app = angular.module('recipeBook', ['ingredients-directives']);

    app.controller('RecipeController', ['$http', function($http){
        $("#controller-init .RecipeController-init").html("Initiated RecipeController");

        var recipe = this;

        $http.get('services/fetch-ingredients-by-id.php?recipeID=1').success(function(data){
            recipe.ingredients = data;
        });

        /*app.directive('recipeIngredients', function(){
            return {
                restrict: 'E',
                templateUrl: 'templates/display-ingredients.html'
            };
        });*/
    }]);
})();
