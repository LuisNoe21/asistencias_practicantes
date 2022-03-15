<?php
 ?>
<?php
if (!isset($_GET["id"])) exit("No id provided");
include_once "header.php";
include_once "nav.php";
$id = $_GET["id"];
include_once "functions.php";
$practicante = getPracticanteById($id);
?>
<div class="row">
    <div class="col-12">
        <h1 class="text-center">Editar Practicante</h1>
    </div>
    <div class="col-12">
        <form action="practicante_update.php" method="POST">
            <input type="hidden" name="id" value="<?php echo $practicante->id ?>">
            <div class="form-group">
                <label for="name">Nombre</label>
                <input value="<?php echo $practicante->name ?>" name="name" placeholder="Name" type="text" id="name" class="form-control" required>
            </div>
            <div class="form-group">
                <button class="btn btn-success">
                    Guardar <i class="fa fa-check"></i>
                </button>
            </div>
        </form>
    </div>
</div>
<?php
include_once "footer.php";
