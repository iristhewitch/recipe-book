<?php
/* __________ CONFIGURATION ____________ */
if (!defined("INCLUDES_PATH")){
	require_once("../config.php");
}
/* ¯¯¯¯¯¯¯¯¯¯ CONFIGURATION ¯¯¯¯¯¯¯¯¯¯¯¯ */

require_once(INCLUDES_PATH . '/dbi_functions_sqlite.php');
require_once(INCLUDES_PATH . '/nicejson.php');
//require_once(INCLUDES_PATH . '/dbi_functions.php');
//require_once(INCLUDES_PATH . '/debug_functions.php');
//TurnDebugOff();

$recipe_id = $_GET['recipe_id'];
$recipe_id = 1;

$conn = new SuperConnection();

$query = "select directions.step_number step,
				directions.direction direction
			from directions
			where directions.recipe_id = $recipe_id";

$results = $conn->ExecuteArrayQuery($query);

$json = json_encode($results);

echo '<pre>', htmlspecialchars(json_format($json)), '</pre>';

//echo '<pre>', json_encode($results, JSON_PRETTY_PRINT), '</pre>';
//echo '<pre>', json_encode($prettyJson), '</pre>';
?>