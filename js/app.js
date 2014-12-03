(function() {
    var app = angular.module('recipeBook', ['xeditable','piece-directives']);
    var MENU_TAB = 1;
    var RECIPE_TAB = 2;
    var INGREDIENT_TAB = 3;
    var MEASURE_TAB = 4;
    var TYPE_TAB = 5;

    app.run(function(editableOptions, editableThemes){
        editableThemes.bs3.inputClass = 'input-sm';
        editableThemes.bs3.buttonsClass = 'btn-sm';
        editableOptions.theme = 'bs3';
    });

    app.controller('RecipeBookController', ['$scope', '$http', '$filter', function($scope, $http, $filter){
        var recipeBook = this;
        $scope.selectedRecipeIndex = 0;
        $scope.selectedMenuIndex = 0;
        recipeBook.newTypeName = " ";

        $http.get('services/fetch-all-ingredients.php').success(function(data){
            recipeBook.allIngredients = data;
        });

        $http.get('services/fetch-all-types.php').success(function(data){
            recipeBook.allTypes = data;
        });

        $http.get('services/fetch-all-measures.php').success(function(data){
           recipeBook.allMeasures = data;
        });

        $http.get('services/fetch-all-recipes.php').success(function(data){
            recipeBook.allRecipes = data;
        });

        this.showType = function(ingredientTypeID) {
            var selected = $filter('filter')(recipeBook.allTypes, {id: ingredientTypeID});
            return (ingredientTypeID && selected.length) ? selected[0].name : 'Not set';
        };

        // Add functionality
        $scope.addType = function() {
            var newID = 9999999;
            console.log("adding new type with id " + newID);
            if(recipeBook.newTypeName != " ") {
                recipeBook.allTypes.push(
                    {
                        name: recipeBook.newTypeName,
                        id: newID
                    });

                recipeBook.newTypeName = " ";
                $('#newTypeNameInput').focus();
                $('#errorMessageDiv').html("").hide();
                return true;
            } else {
                $('#newTypeNameInput').focus();
                $('#errorMessageDiv').html("Please enter a valid type name.").show();
                return false;
            }
        };

        // Update functionality
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

        // Remove functionality
        $scope.removeTypeByID = function(typeID) {
            console.log("removing type of id " + typeID);

            $http.post('services/delete-type-by-id.php', {id:typeID}).
                success(function(successData){
                    console.log(successData);
                    $( "[data-type-id=" + typeID + "]").remove();
                    return true;
                }).
                error(function(errorData){
                    console.log("errorData: " + errorData);
                    return false;
                });
        };

        // Menu and recipe click highlighting
        $scope.recipeClicked = function ($index) {
            $scope.selectedRecipeIndex = $index;
        }

        $scope.menuClicked = function($index) {
            $scope.selectedMenuIndex = $index;
        }
    }]);

    app.controller('TabController', function(){
        this.tab = TYPE_TAB;

        this.setTab = function(newValue){
            this.tab = newValue;
            $('#errorMessageDiv').html("").hide();
        };

        this.isSet = function(tabName){
            return this.tab === tabName;
        };
    });
})();

$(document).ready(function(){
    $('#errorMessageDiv').html("").hide();
    $('#successMessageDiv').html("").hide();
});