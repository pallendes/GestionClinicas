<?php
/* @var $this ProfesionalesController */
/* @var $dataProvider CActiveDataProvider */
Yii::app()->params['moduloActivo'] = $this->selectedItem;

$this->breadcrumbs = array(
    'Profesionales',
);
?>

<h1>Profesionales</h1>
<hr>

<!-- Mensajes de informacion -->
<?php if (!is_null($this->mensaje)): ?>
    <div class="alert alert-warning alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert">
            <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
        </button>
        <?php echo $this->mensaje ?>
    </div>
<?php endif; ?>
<!-- fin mensajes de informacion -->

<!-- Formulario de búsqueda -->
<?php echo CHtml::beginForm('/gestionclinicas/profesionales/index', 'get', array('class' => 'form-horizontal', 'role' => 'form')) ?>
<div class="form-group">
    <div class="col-sm-1">
        <label for="buscar" class="col-sm-2 control-label">Buscar:</label>
    </div>
    <div class="col-sm-9">
        <input type="search" name="palabraClave" value="<?php isset($_GET['palabraClave']) ? CHtml::encode($_GET['palabraClave']) : ''; ?>"
               class="form-control" id="buscar" placeholder="Ingrese una palabra para la búsqueda">
    </div>
    <div class="col-sm-2">
        <button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-search"></span>&nbsp; Buscar</button>
    </div>
</div>
<?php echo CHtml::endForm() ?>
<!-- fin formulario de busqueda -->
<hr />

<!-- Listado de pacientes -->
<?php if (!empty($profesionales)): ?>
    <table class="table table-hover table-striped">
        <thead>
            <tr>
                <th>Rut</th>
                <th>Nombres</th>
                <th>Celular</th>
                <th>Email</th>
                <th>Dirección</th>
                <th>Ciudad</th>
                <th colspan="3">Acciones</th>
            </tr>
        </thead>
        <?php foreach ($profesionales as $profesional): ?>
            <tbody class="table">
                <tr>
                    <td><?php echo $profesional->rut ?></td>
                    <td>
                        <?php echo $profesional->nombre_1 . ' ' . $profesional->apellido_paterno . ' ' . $profesional->apellido_materno ?>
                    </td>
                    <td><?php echo $profesional->celular ?></td>
                    <td><?php echo $profesional->email ?></td>
                    <td><?php echo $profesional->direccion ?></td>
                    <td><?php echo $profesional->fkCiudad->ciudad ?></td>
                    <td>
                        <a href="<?php echo Yii::app()->request->baseUrl; ?>/profesionales/detalles/<?php echo $profesional->rut ?>">
                            <span class="glyphicon glyphicon-zoom-in"></span>
                        </a>
                    </td>
                    <td>
                        <a href="<?php echo Yii::app()->request->baseUrl; ?>/profesionales/editar/<?php echo $profesional->rut ?>">
                            <span class="glyphicon glyphicon-pencil"></span>
                        </a>
                    </td>
                    <td>
                        <a href="#" onclick="openModal('<?php echo $profesional->rut ?>', '<?php echo $profesional->nombre_1 . ' ' . $profesional->apellido_paterno ?>')">
                            <span class="glyphicon glyphicon-remove"></span>
                        </a>
                    </td>
                </tr>
            </tbody>
        <?php endforeach; ?>
    </table>
    <!-- fin listado de pacientes -->
    <!-- Paginador -->
    <div class="row">
        <div class="col-md-10">
            <?php
            $this->widget('CLinkPager', array(
                'pages' => $pages,
                'header' => '',
                'nextPageLabel' => 'Next',
                'prevPageLabel' => 'Prev',
                'selectedPageCssClass' => 'active',
                'hiddenPageCssClass' => 'disabled',
                'prevPageLabel' => 'Anterior',
                'nextPageLabel' => 'Siguiente',
                'firstPageLabel' => '<<',
                'lastPageLabel' => '>>',
                'htmlOptions' => array(
                    'class' => 'pagination',
                )
            ))
            ?>
            <!-- fin paginador -->
        </div>
        <div class="col-md-2">
            <a href="<?php echo Yii::app()->request->baseUrl; ?>/profesionales/crear" class="btn btn-primary">
                <span class="glyphicon glyphicon-plus"></span>&nbsp; Agregar
            </a>
        </div>
    </div>

<?php else: ?>
    <h3>No hay datos para mostrar</h3>
    <div class="row">
        <div class="col-lg-12 right">
            <a href="<?php echo Yii::app()->request->baseUrl; ?>/profesionales/crear" class="btn btn-primary">
                <span class="glyphicon glyphicon-plus"></span>&nbsp; Nuevo
            </a>
        </div>
    </div>
<?php endif; ?>
<!-- fin listado de pacientes -->
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">¿Eliminar Registro?</h4>
            </div>
            <div class="modal-body" id="dataTarget">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <a href="#" class="btn btn-primary" id="deleteButton">Aceptar</a>
            </div>
        </div>
    </div>
</div>
<!-- Scripts -->
<script type="text/javascript">

    function openModal(id, nombre) {
        $('#dataTarget').html(nombre + ', rut: ' + id);
        $('#deleteButton').attr('href', 'eliminar/' + id);
        $('#myModal').modal('show');
    }

</script>
<!-- Fin -->