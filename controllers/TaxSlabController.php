<?php
class TaxSlabController extends Controller
{
    public function filters()
    {
        return array('accessControl');
    }

    public function accessRules()
    {
        return array(
            array('allow',
                'actions'=>array('index','create','update','delete','view'),
                'users'=>array('@'),
            ),
            array('deny','users'=>array('*')),
        );
    }

    public function actionIndex()
    {
        $slabs = TaxSlab::model()->findAll(array('order'=>'regime ASC, slab_from ASC'));
        $this->render('index', array('slabs'=>$slabs));
    }

    public function actionView($id)
    {
        $model = $this->loadModel($id);
        $this->render('view', array('model'=>$model));
    }

    public function actionCreate()
    {
        $model = new TaxSlab;

        if(isset($_POST['TaxSlab']))
        {
            $model->attributes = $_POST['TaxSlab'];
            if($model->save()) $this->redirect(array('index'));
        }

        $this->render('create', array('model'=>$model));
    }

    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);

        if(isset($_POST['TaxSlab']))
        {
            $model->attributes = $_POST['TaxSlab'];
            if($model->save()) $this->redirect(array('index'));
        }

        $this->render('update', array('model'=>$model));
    }

    public function actionDelete($id)
    {
        if(Yii::app()->request->isPostRequest)
        {
            $this->loadModel($id)->delete();
            if(!isset($_GET['ajax'])) $this->redirect(array('index'));
        } else throw new CHttpException(400,'Invalid Request.');
    }

    protected function loadModel($id)
    {
        $m = TaxSlab::model()->findByPk($id);
        if($m===null) throw new CHttpException(404,'Slab not found');
        return $m;
    }
}
