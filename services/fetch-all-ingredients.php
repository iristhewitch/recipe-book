<?php
/* __________ CONFIGURATION ____________ */
if (!defined("INCLUDES_PATH")){
	require_once("../config.php");
}
/* ¯¯¯¯¯¯¯¯¯¯ CONFIGURATION ¯¯¯¯¯¯¯¯¯¯¯¯ */

require_once(INCLUDES_PATH . '/dbi_functions_sqlite3.php');
//require_once(INCLUDES_PATH . '/debug_functions.php');
//TurnDebugOff();

$db = new Sqlite3Connection();

if($db) {

    $query = "select ingredients.id ingredient_id,
                types.name type_name,
                types.id type_id,
                ingredients.name ingredient_name
              from ingredients, types, ingredients_types
              where ingredients_types.types_id = types.id
              and ingredients_types.ingredients_id = ingredients.id
              order by types.name, ingredients.name";

    $results = $db->ExecuteArrayQuery($query);
    $json = json_encode($results);
    echo $json;
}
//echo '<pre>', json_encode($results, JSON_PRETTY_PRINT), '</pre>';
//echo '<pre>', json_encode($prettyJson), '</pre>';
//trace(print_r($result, true));
?>