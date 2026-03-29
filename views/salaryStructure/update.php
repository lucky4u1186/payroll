<?php
$this->breadcrumbs=array('Salary Structures'=>array('index'),'Update');
?>
<h2>Update Salary Structure</h2>
<?php $this->renderPartial('_form', array('model'=>$model,'employees'=>isset($employees)?$employees:array())); ?>
