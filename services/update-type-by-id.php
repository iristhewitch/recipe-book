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
    $typeID = $postdata['id'];

    if(isset($postdata['name']) and !empty($postdata['name'])) {
        $name = $postdata['name'];

        $query = "update types
                    set name = '$name'
                    where id = $typeID";

        $results = $db->ExecuteQuery($query);
        echo "true";
    }
    else
        echo "false";
} else {
    echo "false";
}
//echo '<pre>', json_encode($results, JSON_PRETTY_PRINT), '</pre>';
//echo '<pre>', json_encode($prettyJson), '</pre>';
//trace(print_r($result, true));
?>