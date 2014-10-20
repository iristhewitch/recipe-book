<?php
/* __________ CONFIGURATION ____________ */
if (!defined("INCLUDES_PATH")){
	require_once("../config.php");
}
/* ¯¯¯¯¯¯¯¯¯¯ CONFIGURATION ¯¯¯¯¯¯¯¯¯¯¯¯ */

require_once(INCLUDES_PATH . '/dbi_functions_sqlite.php');
//require_once(INCLUDES_PATH . '/debug_functions.php');
//TurnDebugOff();

$recipe_id = $_GET["recipeID"];

$conn = new SuperConnection();

$query = "select ingredients.measure_amount amount,
				measures.type amount_type,
				ingredients.name name
			from ingredients, measures
			where ingredients.recipe_id = $recipe_id
				and ingredients.measure_id = measures.id";

$results = $conn->ExecuteArrayQuery($query);

echo json_encode($results);

//trace(print_r($result, true));
?>