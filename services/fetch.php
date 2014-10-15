<?php
/* __________ CONFIGURATION ____________ */
if (!defined("INCLUDES_PATH")){
	require_once("config.php");
}
/* ¯¯¯¯¯¯¯¯¯¯ CONFIGURATION ¯¯¯¯¯¯¯¯¯¯¯¯ */

require_once(INCLUDES_PATH . '/dbi_functions.php');
require_once(INCLUDES_PATH . '/debug_functions.php');
TurnDebugOff();

$conn = new SuperConnection();

$sql = "SELECT s.id, s.name, s.school, s.level, s.isritual, s.casttime, s.range, s.components, s.duration, s.description, 
			(SELECT GROUP_CONCAT((			
				SELECT a.class
				FROM class a
				WHERE a.id = c.class_id) SEPARATOR ' ')
			FROM class_spells c
			WHERE c.spell_id = s.id
			GROUP BY c.spell_id) AS classes
		FROM spells s
		ORDER BY s.level, s.school, s.name";

$params = array();
$params[] = $email;
$result = $conn->ExecuteStatement($sql, $params);

//trace(print_r($result, true));
echo json_encode($result);
?>