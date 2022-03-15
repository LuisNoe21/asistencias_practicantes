<?php
?>
<?php
if (!isset($_POST["name"])) {
    exit("No data provided");
}
include_once "functions.php";
$name = $_POST["name"];
savePracticante($name);
header("Location: practicantes.php");
