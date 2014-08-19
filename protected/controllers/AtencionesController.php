<?php

class AtencionesController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';
    public $_mensaje;
    public $selectedItem = 'atenciones';
    public $rutPaciente;
    public $rutProfesional;

    /**
     * @return array action filters
     */
    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
            'postOnly + delete', // we only allow deletion via POST request
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules() {
        return array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('index', 'view', 'nueva', 'cargardiagnosticos', 'editar', 'ver', 'find'),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('create', 'update'),
                'users' => array('@'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('admin', 'delete'),
                'users' => array('admin'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionVer($id) {
        echo $id;
//        $this->render('detalles', array(
//            'model' => $this->loadModel($id),
//        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionNueva($id) {
        $model = new Atenciones;

        $this->rutPaciente = $id;

        $this->performAjaxValidation($model);
        
        if (isset($_POST['Atenciones'])) {
            
            $model->attributes = $_POST['Atenciones'];
            $model->rut_profesional = '112223334';
            $model->rut_paciente = $this->rutPaciente;
            $model->fecha = date('y-m-d');

            if ($model->save()) {
                $this->forward('atenciones/ver/' . $model->id);
            }
        }

        $this->render('nueva', array(
            'model' => $model,
        ));
    }

    public function actionCargarDiagnosticos() {

        $data = Diagnosticos::model()->findAll('id_categoria=:idCategoria', 
                array(':idCategoria' => (int) $_POST['idCategoria']));

        $data = CHtml::listData($data, 'id', 'diagnostico');

        foreach ($data as $value => $name) {
            echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
        }
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionEditar($id) {
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['Atenciones'])) {
            $model->attributes = $_POST['Atenciones'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
        }

        $this->render('editar', array(
            'model' => $model,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        $this->loadModel($id)->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax'])) {
            
        }
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {

        $criteria = new CDbCriteria();
        $count = Atenciones::model()->count($criteria);
        $pages = new CPagination($count);

        if (isset($_GET['clavePaciente'])) {
            $q = $_GET['clavePaciente'];
            $criteria->compare('nombre_1', $q, true, 'OR');
            $criteria->compare('apellido_paterno', $q, true, 'OR');
            $criteria->compare('rut', $q, true, 'OR');
        }

        // results per page
        $pages->pageSize = 5;
        $pages->applyLimit($criteria);

        $profesionales = Atenciones::model()->findAll($criteria);

        $this->render('index', array('atenciones' => $profesionales,
            'pages' => $pages,
        ));
    }

    public function actionFind() {

        $criteria = new CDbCriteria();
        $count = Atenciones::model()->count($criteria);
        $pages = new CPagination($count);

        if (isset($_POST)) {
            print_r($_POST);

            if (isset($_POST['fechaDesde'])) {
                $criteria->addBetweenCondition('fecha', $_POST['fechaDesde'], date('Y-m-d'));
            }

            if (isset($_POST['fechaHasta'])) {
                $criteria->addBetweenCondition('fecha', date('Y-m-d'), $_POST['fechaHasta']);
            }

//            if(isset($_POST['id_categoria'])){
//                $criteria->compare('', $pages)
//            }
//            
            if (isset($_POST['id_diagnostico'])) {
                $criteria->compare('id_diagnostico', $_POST['id_diagnostico']);
            }


//            $criteria->compare('nombre_1', $q, true, 'OR');
//            $criteria->compare('apellido_paterno', $q, true, 'OR');
////            $criteria->compare('rut', $q, true, 'OR');
        }

        // results per page
        $pages->pageSize = 5;
        $pages->applyLimit($criteria);

        $profesionales = Atenciones::model()->findAll($criteria);

//        $this->render('index', array('atenciones' => $profesionales,
//            'pages' => $pages,
//        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Atenciones the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = Atenciones::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, 'La página solicitada no existe.');
        }
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Atenciones $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'atenciones-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
