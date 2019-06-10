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
    $postdata = file_get_contents("php://input");
    $postdata = json_decode($postdata, true);

    if (isset($postdata['name']) and !empty($postdata['name'])) {
        $ingredientName = $postdata['name'];

        $query = "insert into ingredients (name) values ('$ingredientName')";
        $results = $db->ExecuteQuery($query);


        $query = "select name, id
                    from ingredients
                    where name = '$ingredientName'";

        $results = $db->ExecuteArrayQuery($query);
        $json = json_encode($results);
        echo $json;
    }
}
//echo '<pre>', json_encode($results, JSON_PRETTY_PRINT), '</pre>';
//echo '<pre>', json_encode($prettyJson), '</pre>';
//trace(print_r($result, true));
?>