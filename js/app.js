(function() {
    var app = angular.module('recipeBook', ['recipeIngredients', 'recipeDirections']);

    app.controller('StoreController', function(){
        this.products = gems;
    });
})();
