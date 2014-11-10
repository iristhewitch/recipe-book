(function() {
    var app = angular.module('recipeBook', ['xeditable','ingredients-directives']);

    app.run(function(editableOptions, editableThemes){
        editableThemes.bs3.inputClass = 'input-sm';
        editableThemes.bs3.buttonsClass = 'btn-sm';
        editableOptions.theme = 'bs3';
    });

    app.controller('RecipeBookController', ['$http', function($http){
        var recipeBook = this;

        /*$http.get('services/fetch-ingredients-by-id.php?recipeID=1').success(function(data){
         recipeBook.ingredients = data;
        });*/

        $http.get('services/fetch-all-ingredients.php').success(function(data){
            recipeBook.allIngredients = data;
            console.log(allIngredients);
        });

        $http.get('services/fetch-all-types.php').success(function(data){
            recipeBook.allTypes = data;
        })
    }]);

    app.controller('TabController', function(){
        this.tab = 3;

        this.setTab = function(newValue){
            //console.log('setting tab to ' + newValue);
            this.tab = newValue;
        };

        this.isSet = function(tabName){
            //console.log('checking ' + tabName + ' = ' + this.tab);
            return this.tab === tabName;
        };
    });
})();
