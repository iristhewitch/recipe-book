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
    //echo $postdata;
    //echo print_r($postdata, true);

    if(isset($postdata['id']) and !empty($postdata['id'])) {
        $typeID = $postdata['id'];

        $query = "update ingredients_types
                    set types_id = (select id from types where name = 'Misc.')
                    where types_id = $typeID";

        $query2 = "delete from types
                  where id = $typeID";

        $results = $db->ExecuteQuery($query);
        $results2 = $db->ExecuteQuery($query2);
        echo "true";

    }
} else {
    echo "false";
}
//echo '<pre>', json_encode($results, JSON_PRETTY_PRINT), '</pre>';
//echo '<pre>', json_encode($prettyJson), '</pre>';
//trace(print_r($result, true));
?>