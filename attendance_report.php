<?php
 ?>
<?php
include_once "header.php";
include_once "nav.php";
include_once "functions.php";
$start = date("Y-m-d");
$end = date("Y-m-d");
if (isset($_GET["start"])) {
    $start = $_GET["start"];
}
if (isset($_GET["end"])) {
    $end = $_GET["end"];
}
$practicantes = getPracticantesWithAttendanceCount($start, $end);
?>
<div class="row">
    <div class="col-12">
        <h1 class="text-center">Reporte de Asistencia</h1>
    </div>
    <div class="col-12">

        <form action="attendance_report.php" class="form-inline mb-2">
            <label for="start">Desde:&nbsp;</label>
            <input required id="start" type="date" name="start" value="<?php echo $start ?>" class="form-control mr-2">
            <label for="end">Hasta:&nbsp;</label>
            <input required id="end" type="date" name="end" value="<?php echo $end ?>" class="form-control">
            <button class="btn btn-success ml-2">Filtrar</button>
        </form>
    </div>
    <div class="col-12">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Practicante</th>
                        <th>Dias Asistidos</th>
                        <th>Dias No Asistidos</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($practicantes as $practicante) { ?>
                        <tr>
                            <td>
                                <?php echo $practicante->name ?>
                            </td>
                            <td>
                                <?php echo $practicante->presence_count ?>
                            </td>
                            <td>
                                <?php echo $practicante->absence_count ?>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php
include_once "footer.php";
