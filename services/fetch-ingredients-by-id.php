<?php
/* __________ CONFIGURATION ____________ */
if (!defined("INCLUDES_PATH")){
	require_once("config.php");
}
/* ¯¯¯¯¯¯¯¯¯¯ CONFIGURATION ¯¯¯¯¯¯¯¯¯¯¯¯ */

require_once(INCLUDES_PATH . '/dbi_functions_sqlite.php');
require_once(INCLUDES_PATH . '/debug_functions.php');
TurnDebugOff();

$recipe_id = $_POST["recipeID"];

$conn = new SuperConnection();

$query = "select menus.name menu_name,
				recipes.name recipe_name
			from menus, recipes, menus_recipes
			where menus.id = menus_recipes.menu_id
				and recipes.id = menus_recipes.recipe_id
				and menus.id = $recipe_id";


$result = $conn->ExecuteQuery($query);

//trace(print_r($result, true));
echo json_encode($result);
?>