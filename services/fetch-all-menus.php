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

    $query = "select menus.id id,
                menus.name name,
                menus.start_date startDate,
                menus.end_date endDate
              from menus
              order by menus.start_date, menus.name";

    $results = $db->ExecuteArrayQuery($query);
    $json = json_encode($results);
    echo $json;
/*    echo '<pre>';
    echo print_r($results, true);
    echo '</pre>';
*/
}
//echo '<pre>', json_encode($results, JSON_PRETTY_PRINT), '</pre>';
//echo '<pre>', json_encode($prettyJson), '</pre>';
//trace(print_r($result, true));
?>