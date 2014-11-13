<?php
/* __________ CONFIGURATION ____________ */
if (!defined("INCLUDES_PATH")){
	require_once("../config.php");
}
/* ¯¯¯¯¯¯¯¯¯¯ CONFIGURATION ¯¯¯¯¯¯¯¯¯¯¯¯ */

require_once(INCLUDES_PATH . '/dbi_functions_sqlite.php');
//require_once(INCLUDES_PATH . '/debug_functions.php');
//TurnDebugOff();

$conn = new SuperConnection();

if($conn) {
    //$query = "select * from ingredients";
    //$query = "select * from types";

    $query = "select ingredients.id ingredient_id,
                types.name type_name,
                types.id type_id,
                ingredients.name ingredient_name
              from ingredients, types, ingredients_types
              where ingredients_types.types_id = types.id
              and ingredients_types.ingredients_id = ingredients.id
              order by types.name, ingredients.name";

    $results = $conn->ExecuteArrayQuery($query);
    $json = json_encode($results);
    echo $json;
}
//echo '<pre>', json_encode($results, JSON_PRETTY_PRINT), '</pre>';
//echo '<pre>', json_encode($prettyJson), '</pre>';
//trace(print_r($result, true));
?>