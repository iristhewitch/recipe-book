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

    if(isset($postdata['id']) and !empty($postdata['id'])) {
        $typeID = $postdata['id'];

        if($typeID === '9999999')
        /*$query = "delete from ingredients
                  where id = $ingredientID";

        $query2 = "delete from ingredients_types
                    where ingredients_id = $ingredientID";

        $results = $conn->ExecuteQuery($query);
        $results2 = $conn->ExecuteQuery($query2);*/
            echo "false";
        else
            echo "true";

    }
} else {
    echo "false";
}
//echo '<pre>', json_encode($results, JSON_PRETTY_PRINT), '</pre>';
//echo '<pre>', json_encode($prettyJson), '</pre>';
//trace(print_r($result, true));
?>