<?php
 ?>
<?php
include_once "header.php";
include_once "nav.php";
include_once "functions.php";
$practicantes = getPracticantes();
?>
<div class="row">
    <div class="col-12">
        <h1 class="text-center">Practicantes</h1>
    </div>
    <div class="col-12">
        <a href="practicante_add.php" class="btn btn-info mb-2">Agregar Nuevo Practicante <i class="fa fa-plus"></i></a>
    </div>
    <div class="col-12">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Nombre</th>
                        <th>Editar</th>
                        <th>Eliminar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($practicantes as $practicante) { ?>
                        <tr>
                            <td>
                                <?php echo $practicante->id ?>
                            </td>
                            <td>
                                <?php echo $practicante->name ?>
                            </td>
                            <td>
                                <a class="btn btn-warning" href="practicante_edit.php?id=<?php echo $practicante->id ?>">
                                Editar <i class="fa fa-edit"></i>
                            </a>
                            </td>
                            <td>
                                <a class="btn btn-danger" href="practicante_delete.php?id=<?php echo $practicante->id ?>">
                                Eliminar <i class="fa fa-trash"></i>
                            </a>
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
