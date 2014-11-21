(function() {
    var app = angular.module('piece-directives', []);

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

    app.directive('allRecipes', function(){
        return {
            restrict: 'E',
            templateUrl: 'templates/all-recipes.html'
        };
    });

    /*app.directive('allMenus', function(){
        return {
            restrict: 'E',
            templateUrl: 'templates/all-menus.html'
        };
    });*/

    app.directive('icNavAutoclose', function () {
        console.log("icNavAutoclose");
        return function (scope, elm, attrs) {
            var collapsible = $(elm).find(".navbar-collapse");
            var visible = false;

            collapsible.on("show.bs.collapse", function () {
                visible = true;
            });

            collapsible.on("hide.bs.collapse", function () {
                visible = false;
            });

            $(elm).find("a").each(function (index, element) {
                $(element).click(function (e) {
                    if (visible && "auto" == collapsible.css("overflow-y")) {
                        collapsible.collapse("hide");
                    }
                });
            });
        };
    });
})();