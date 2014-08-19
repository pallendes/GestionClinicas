<?php
/* @var $this CiudadesController */
/* @var $model Ciudades */

Yii::app()->params['moduloActivo'] = $this->selectedItem; 

$this->breadcrumbs = array(
    'Ciudades' => array('index'),
    'Nueva',
);
?>

<h1>Agregar Ciudad</h1>
<hr>
<div class="row">
    <div class="col-md-7">
        <?php echo $this->renderPartial('_form', array('model' => $model)); ?>
    </div>  
    <div class="col-md-4 col-md-offset-1">
        <div class="panel panel-primary">
            <div class="panel-heading">Operaciones</div>
            <div class="panel-body">
                <?php
                echo CHtml::link('Listar', '/gestionclinicas/ciudades/') . '<br>';
                echo CHtml::link('Volver', Yii::app()->request->urlReferrer);
                ?>
            </div>
        </div>
        <?php
        ?> 
    </div>
</div>