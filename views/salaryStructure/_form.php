<?php /* @var $model SalaryStructure */ ?>
<?php $form=$this->beginWidget('CActiveForm'); ?>

<div class="row">
    <?php echo $form->labelEx($model,'emp_id'); ?>
    <?php echo $form->dropDownList($model,'emp_id', CHtml::listData(Employee::model()->findAll(),'id','name'), array('prompt'=>'Select employee')); ?>
    <?php echo $form->error($model,'emp_id'); ?>
</div>

<div class="row">
    <?php echo $form->labelEx($model,'basic'); ?>
    <?php echo $form->textField($model,'basic'); ?>
</div>

<div class="row">
    <?php echo $form->labelEx($model,'hra'); ?>
    <?php echo $form->textField($model,'hra'); ?>
</div>

<div class="row">
    <?php echo $form->labelEx($model,'conveyance'); ?>
    <?php echo $form->textField($model,'conveyance'); ?>
</div>

<div class="row">
    <?php echo $form->labelEx($model,'special_allow'); ?>
    <?php echo $form->textField($model,'special_allow'); ?>
</div>

<div class="row">
    <?php echo $form->labelEx($model,'other_allow'); ?>
    <?php echo $form->textField($model,'other_allow'); ?>
</div>

<div class="row">
    <?php echo $form->labelEx($model,'pf_applicable'); ?>
    <?php echo $form->checkBox($model,'pf_applicable'); ?>
</div>

<div class="row">
    <?php echo $form->labelEx($model,'esi_applicable'); ?>
    <?php echo $form->checkBox($model,'esi_applicable'); ?>
</div>

<div class="row">
    <?php echo $form->labelEx($model,'pt_state'); ?>
    <?php echo $form->textField($model,'pt_state'); ?>
</div>

<div class="row">
    <?php echo $form->labelEx($model,'regime'); ?>
    <?php echo $form->dropDownList($model,'regime', array('old'=>'Old','new'=>'New')); ?>
</div>

<div class="row buttons">
    <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
</div>

<?php $this->endWidget(); ?>
