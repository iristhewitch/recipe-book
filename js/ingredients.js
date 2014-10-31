(function() {
    var app = angular.module('ingredients-directives', []);

    app.directive('recipeIngredients', function () {
        $("#controller-init .ingredients-display-init").html("Initiated ingredients module");
        return {
            restrict: 'E',
            templateUrl: 'templates/display-ingredients.html'
        };
    });
})();