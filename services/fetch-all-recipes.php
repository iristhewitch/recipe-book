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

    $query = "select types.id id,
                types.name name
              from types";
    $query = "select recipes.id id,
                recipes.name name,
                recipes.min_time minTime,
                recipes.max_time maxTime,
                recipes.servings servings
              from recipes
              order by recipes.name;
    ";

    $results = $conn->ExecuteArrayQuery($query);
    $json = json_encode($results);
    echo $json;
}
//echo '<pre>', json_encode($results, JSON_PRETTY_PRINT), '</pre>';
//echo '<pre>', json_encode($prettyJson), '</pre>';
//trace(print_r($result, true));
?>