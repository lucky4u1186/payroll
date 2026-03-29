<h2>Salary Structure for <?php echo CHtml::encode($model->employee ? $model->employee->name : ''); ?></h2>

<table class="table">
<tr><th>Basic</th><td><?php echo number_format($model->basic,2); ?></td></tr>
<tr><th>HRA</th><td><?php echo number_format($model->hra,2); ?></td></tr>
<tr><th>Conveyance</th><td><?php echo number_format($model->conveyance,2); ?></td></tr>
<tr><th>Special Allow</th><td><?php echo number_format($model->special_allow,2); ?></td></tr>
<tr><th>Other Allow</th><td><?php echo number_format($model->other_allow,2); ?></td></tr>
<tr><th>PF Applicable</th><td><?php echo $model->pf_applicable ? 'Yes':'No'; ?></td></tr>
<tr><th>ESI Applicable</th><td><?php echo $model->esi_applicable ? 'Yes':'No'; ?></td></tr>
<tr><th>Professional Tax State</th><td><?php echo CHtml::encode($model->pt_state); ?></td></tr>
<tr><th>Tax Regime</th><td><?php echo CHtml::encode($model->regime); ?></td></tr>
</table>

<p><?php echo CHtml::link('Edit', array('salaryStructure/update','id'=>$model->id)); ?></p>
