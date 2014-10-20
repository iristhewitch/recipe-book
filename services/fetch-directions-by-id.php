<?php
/* __________ CONFIGURATION ____________ */
if (!defined("INCLUDES_PATH")){
	require_once("config.php");
}
/* ¯¯¯¯¯¯¯¯¯¯ CONFIGURATION ¯¯¯¯¯¯¯¯¯¯¯¯ */

require_once(INCLUDES_PATH . '/dbi_functions.php');
require_once(INCLUDES_PATH . '/debug_functions.php');
TurnDebugOff();

$conn = new SuperConnection();

$sql = "select directions.step_number step,
				directions.direction direction
			from directions
			where directions.recipe_id = $recipe_id";



$params = array();
$params[] = $email;
$result = $conn->ExecuteStatement($sql, $params);

//trace(print_r($result, true));
echo json_encode($result);
?>