<?php /* @var $this PayrollController */ ?>
<h2>Create Payroll for <?php echo CHtml::encode($employee->name); ?></h2>

<?php $form = $this->beginWidget('CActiveForm'); ?>

<?php echo $form->hiddenField($model,'employee_id'); ?>

<div class="row">
    <?php echo $form->labelEx($model,'month_year'); ?>
    <?php echo $form->textField($model,'month_year',array('value'=>date('Y-m-01'))); ?>
</div>

<div class="row buttons">
    <?php echo CHtml::submitButton('Generate Payroll'); ?>
</div>

<?php $this->endWidget(); ?>
