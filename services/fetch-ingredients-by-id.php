<?php
/* __________ CONFIGURATION ____________ */
if (!defined("INCLUDES_PATH")){
	require_once("../config.php");
}
/* ¯¯¯¯¯¯¯¯¯¯ CONFIGURATION ¯¯¯¯¯¯¯¯¯¯¯¯ */

require_once(INCLUDES_PATH . '/dbi_functions_sqlite.php');
require_once(INCLUDES_PATH . '/nicejson.php');
//require_once(INCLUDES_PATH . '/debug_functions.php');
//TurnDebugOff();

$recipe_id = $_GET["recipeID"];
$recipe_id = 1;

$conn = new SuperConnection();

$query = "select recipes_ingredients.measure_amount,
	                measures.name,
	                ingredients.name
            from ingredients, measures, recipes_ingredients
            where recipes_ingredients.recipes_id = 1
	          and recipes_ingredients.ingredients_id = ingredients.id
	          and recipes_ingredients.measures_id = measures.id";

$results = $conn->ExecuteArrayQuery($query);

$json = json_encode($results);

echo '<pre>', htmlspecialchars(json_format($json)), '</pre>';
//echo '<pre>', json_encode($results, JSON_PRETTY_PRINT), '</pre>';
//echo '<pre>', json_encode($prettyJson), '</pre>';
//trace(print_r($result, true));
?>