<?php
$this->breadcrumbs=array('Salary Structures'=>array('index'),'Create');
?>
<h2>Create Salary Structure</h2>
<?php $this->renderPartial('_form', array('model'=>$model,'employees'=>isset($employees)?$employees:array())); ?>
