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
    $postdata = file_get_contents("php://input");
    $postdata = json_decode($postdata, true);
    //echo $postdata;
    //echo print_r($postdata, true);
    $ingredientID = $postdata['id'];

    if(isset($postdata['name']) and !empty($postdata['name'])) {
        $name = $postdata['name'];

        $query = "update ingredients
                    set name = '$name'
                    where id = $ingredientID";

        $results = $conn->ExecuteQuery($query);
        echo "true";
    } else if(isset($postdata['type']) and !empty($postdata['type'])) {
        $type = $postdata['type'];

        $query = "update ingredients_types
                    set types_id = $type
                    where ingredients_id = $ingredientID";

        $results = $conn->ExecuteQuery($query);
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