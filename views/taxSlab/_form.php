<?php $form=$this->beginWidget('CActiveForm'); ?>

<div class="row">
    <?php echo $form->labelEx($model,'regime'); ?>
    <?php echo $form->dropDownList($model,'regime', array('old'=>'Old Regime','new'=>'New Regime')); ?>
</div>

<div class="row">
    <?php echo $form->labelEx($model,'slab_from'); ?>
    <?php echo $form->textField($model,'slab_from'); ?>
</div>

<div class="row">
    <?php echo $form->labelEx($model,'slab_to'); ?>
    <?php echo $form->textField($model,'slab_to'); ?>
</div>

<div class="row">
    <?php echo $form->labelEx($model,'rate'); ?>
    <?php echo $form->textField($model,'rate'); ?> %
</div>

<div class="row buttons">
    <?php echo CHtml::submitButton($model->isNewRecord ? 'Create Slab' : 'Save Changes'); ?>
</div>

<?php $this->endWidget(); ?>
