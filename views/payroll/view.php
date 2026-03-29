<?php /* @var $model Payroll */ ?>
<h2>Payslip - <?php echo CHtml::encode($model->employee->name); ?></h2>
<p>
    <?php echo CHtml::link('Download PDF', array('pdf','id'=>$model->id), array('class'=>'btn')); ?>
</p>

<?php $this->renderPartial('_payslip', array('model'=>$model)); ?>
