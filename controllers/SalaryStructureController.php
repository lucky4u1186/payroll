<?php
class SalaryStructureController extends Controller
{
    public function filters()
    {
        return array('accessControl');
    }

    public function accessRules()
    {
        return array(
            array('allow',
                'actions'=>array('index','view','create','update','delete'),
                'users'=>array('@'),
            ),
            array('deny','users'=>array('*')),
        );
    }

    public function actionIndex()
    {
        $model = new SalaryStructure('search');
        $model->unsetAttributes();
        if(isset($_GET['SalaryStructure'])) $model->attributes = $_GET['SalaryStructure'];
        $this->render('index', array('model'=>$model));
    }

    public function actionView($id)
    {
        $model = $this->loadModel($id);
        $this->render('view', array('model'=>$model));
    }

    public function actionCreate()
    {
        $model = new SalaryStructure;

        if(isset($_POST['SalaryStructure']))
        {
            $model->attributes = $_POST['SalaryStructure'];
            if($model->save()) $this->redirect(array('view','id'=>$model->id));
        }

        $employees = CHtml::listData(Employee::model()->findAll(),'id','name');
        $this->render('create', array('model'=>$model,'employees'=>$employees));
    }

    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);

        if(isset($_POST['SalaryStructure']))
        {
            $model->attributes = $_POST['SalaryStructure'];
            if($model->save()) $this->redirect(array('view','id'=>$model->id));
        }

        $employees = CHtml::listData(Employee::model()->findAll(),'id','name');
        $this->render('update', array('model'=>$model,'employees'=>$employees));
    }

    public function actionDelete($id)
    {
        if(Yii::app()->request->isPostRequest)
        {
            $this->loadModel($id)->delete();
            if(!isset($_GET['ajax'])) $this->redirect(array('index'));
        }
        else throw new CHttpException(400,'Invalid request.');
    }

    public function loadModel($id)
    {
        $m = SalaryStructure::model()->findByPk($id);
        if($m===null) throw new CHttpException(404,'Not found');
        return $m;
    }
}
