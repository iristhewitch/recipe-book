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
        recipeBook.newIngredientName = " ";
        recipeBook.newIngredientType = " ";

        // load all information
        recipeBook.loadIngredients = function(){
            $http.get('services/fetch-all-ingredients.php').success(function(data){
                recipeBook.allIngredients = data;
            });
        };

        recipeBook.loadTypes = function(){
            $http.get('services/fetch-all-types.php').success(function(data){
                recipeBook.allTypes = data;
            });
        };

        recipeBook.loadMeasures = function(){
            $http.get('services/fetch-all-measures.php').success(function(data){
                recipeBook.allMeasures = data;
            });
        };

        recipeBook.loadRecipes = function(){
            $http.get('services/fetch-all-recipes.php').success(function(data){
                recipeBook.allRecipes = data;
            });
        };

        recipeBook.loadAllInformation = function(){
            recipeBook.loadIngredients();
            recipeBook.loadTypes();
            recipeBook.loadMeasures();
            recipeBook.loadRecipes();
        };

        recipeBook.loadAllInformation();

        this.showType = function(ingredientTypeID) {
            var selected = $filter('filter')(recipeBook.allTypes, {id: ingredientTypeID});
            var singleSelection;

            // Since it's returning 1 and 10 in the same set...
            if(selected.length) {
                for (var i = 0; i < selected.length; i++) {
                    if(selected[i].id === ingredientTypeID){
                        singleSelection = selected[i];
                    }
                }

                return singleSelection.name;
            }
            else
                //return 'Not set';
                return (ingredientTypeID && selected.length) ? selected[0].name : 'Not set';
        };

        // Add functionality
        $scope.addType = function() {
            var newID = -1;

            if(recipeBook.newTypeName !== " ") {
                $http.post('services/insert-type-by-name.php', {name: recipeBook.newTypeName}).
                    success(function(successData){
                        newID = successData[0].id;
                        console.log("adding new type (" +recipeBook.newTypeName + ") with id " + newID);

                        recipeBook.allTypes.push(
                            {
                                name: recipeBook.newTypeName,
                                id: newID
                            });

                        recipeBook.loadTypes();
                        recipeBook.newTypeName = " ";
                        $('#newTypeNameInput').focus();
                    }).
                    error(function(errorData){
                        console.log("errorData: " + errorData);
                        return false;
                    });

                return true;
            } else {
                $('#newTypeNameInput').focus();
                return false;
            }
        };

        $scope.addIngredient = function() {
            var newID = -1;

            if(recipeBook.newIngredientName !== " " && recipeBook.newIngredientType !== " ") {
                $http.post('services/insert-ingredient-by-name.php', {name: recipeBook.newIngredientName, type_id: recipeBook.newIngredientType}).
                success(function(successData){

                    console.log(successData);

                    newID = successData[0].id;
                    console.log("adding new ingredient (" +recipeBook.newIngredientName + ") with id " + newID + " and type (" + recipeBook.newIngredientType + ")");

                    recipeBook.allIngredients.push(
                        {
                            name: recipeBook.newIngredientName,
                            id: newID
                        });

                    recipeBook.loadIngredients();
                    recipeBook.newIngredientName = " ";
                    $('#newIngredientNameInput').focus();
                }).
                error(function(errorData){
                    console.log("errorData: " + errorData);
                    return false;
                });

                return true;
            } else {
                $('#newIngredientNameInput').focus();
                console.log("failed to add new ingredient (" +recipeBook.newIngredientName + ") with id " + newID + " and type (" + recipeBook.newIngredientType + ")");
                return false;
            }
        };

        // Update functionality
        $scope.updateIngredientName = function(data, ingredientID){
            $http.post('services/update-ingredient-by-id.php', {id: ingredientID, name: data}).
                success(function(successData){
                    recipeBook.loadIngredients();
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
                    recipeBook.loadIngredients();
                    return successData === "true";
                }).
                error(function(errorData){
                    console.log("errorData: " + errorData);
                    return false;
                });
        };

        $scope.updateTypeName = function(data, typeID){
            $http.post('services/update-type-by-id.php', {id: typeID, name: data}).
                success(function(successData){
                    recipeBook.loadTypes();
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
                    recipeBook.loadMeasures();
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
                    recipeBook.loadTypes();
                    recipeBook.loadIngredients();
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
        this.tab = INGREDIENT_TAB;

        this.setTab = function(newValue){
            this.tab = newValue;
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