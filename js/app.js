(function() {
    var app = angular.module('recipeBook', ['xeditable','piece-directives']);

    app.run(function(editableOptions, editableThemes){
        editableThemes.bs3.inputClass = 'input-sm';
        editableThemes.bs3.buttonsClass = 'btn-sm';
        editableOptions.theme = 'bs3';
    });

    app.controller('RecipeBookController', ['$scope', '$http', '$filter', function($scope, $http, $filter){
        var recipeBook = this;
        $scope.selectedIndex = 0;

        /*$http.get('services/fetch-ingredients-by-id.php?recipeID=1').success(function(data){
         recipeBook.ingredients = data;
        });*/

        $http.get('services/fetch-all-ingredients.php').success(function(data){
            recipeBook.allIngredients = data;
            //console.log(recipeBook.allIngredients);
        });

        $http.get('services/fetch-all-types.php').success(function(data){
            recipeBook.allTypes = data;
            //console.log(recipeBook.allTypes);
        });

        $http.get('services/fetch-all-measures.php').success(function(data){
           recipeBook.allMeasures = data;
        });

        $http.get('services/fetch-all-recipes.php').success(function(data){
            recipeBook.allRecipes = data;
        });

        this.showType = function(ingredientTypeID) {
            //console.dir(recipeBook.allTypes);
            var selected = $filter('filter')(recipeBook.allTypes, {id: ingredientTypeID});
            //console.log(selected);
            return (ingredientTypeID && selected.length) ? selected[0].name : 'Not set';
        };

        $scope.updateIngredientName = function(data, ingredientID){
            $http.post('services/update-ingredient-by-id.php', {id: ingredientID, name: data}).
                success(function(successData){
                    return successData === "true";
                }).
                error(function(errorData){
                    console.log("errorData: " + errorData);
                    return false;
                });
        };

        $scope.updateIngredientType = function(data, ingredientID){
            $http.post('services/update-ingredient-by-id.php', {id: ingredientID, type: data}).
                success(function(successData){
                    return successData === "true";
                }).
                error(function(errorData){
                    console.log("errorData: " + errorData);
                    return false;
                });
        };

        $scope.updateTypeName = function(data, typeID){
            console.log("new type name: " + data + "; " + typeID);
            $http.post('services/update-type-by-id.php', {id: typeID, name: data}).
                success(function(successData){
                    console.log(successData);
                    return successData === "true";
                }).
                error(function(errorData){
                    console.log("errorData: " + errorData);
                    return false;
                });
        };

        $scope.updateMeasureName = function(data, measureID){
            console.log("new type name: " + data + "; " + measureID);
            $http.post('services/update-measure-by-id.php', {id: measureID, name: data}).
                success(function(successData){
                    console.log(successData);
                    return successData === "true";
                }).
                error(function(errorData){
                    console.log("errorData: " + errorData);
                    return false;
                });
        };

        $scope.itemClicked = function ($index) {
            console.log($index);
            $scope.selectedIndex = $index;
        }
    }]);

    app.controller('TabController', function(){
        this.tab = 2;

        this.setTab = function(newValue){
            this.tab = newValue;
        };

        this.isSet = function(tabName){
            return this.tab === tabName;
        };
    });
})();

$(document).ready(function(){
    $('#errorMessageDiv').hide();
    $('#successMessageDiv').hide();
});