<?php
?>
<?php
include_once "functions.php";
$practicantes = getPracticantes();
echo json_encode($practicantes);
