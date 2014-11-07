(function() {
    var app = angular.module('ingredients-directives', []);

    app.directive('recipeIngredients', function () {
        $("#controller-init .ingredients-display-init").html("Initiated ingredients module");

        return {
            restrict: 'E',
            transclude: true,
            templateUrl: 'templates/display-ingredients.html'
        };
    });
})();

$(document).ready(function(){
    $.fn.editable.defaults.mode = 'popup';

    $('.ingredient').editable({
        type: 'select',
        title: 'Select ingredient',
        placement: 'right',
        value: 2,
        source: [
            {value: 1, text: 'ingredient 1'},
            {value: 2, text: 'ingredient 2'},
            {value: 3, text: 'ingredient 3'}
        ]
        /*
         //uncomment these lines to send data on server
         ,pk: 1
         ,url: '/post'
         */
    });
});