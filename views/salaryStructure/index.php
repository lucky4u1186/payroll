<?php
/* @var $this SalaryStructureController */
/* @var $model SalaryStructure */
$this->breadcrumbs=array('Salary Structures');
?>
<h2>Salary Structures</h2>

<p><?php echo CHtml::link('Create New Salary Structure', array('salaryStructure/create'), array('class'=>'btn')); ?></p>

<table class="table">
    <thead>
        <tr><th>Employee</th><th>Basic</th><th>HRA</th><th>Conveyance</th><th>Special</th><th>Other</th><th>PF</th><th>ESI</th><th>State</th><th>Regime</th><th>Actions</th></tr>
    </thead>
    <tbody>
    <?php foreach(SalaryStructure::model()->findAll() as $s): ?>
        <tr>
            <td><?php echo CHtml::encode($s->employee ? $s->employee->name : ''); ?></td>
            <td><?php echo number_format($s->basic,2); ?></td>
            <td><?php echo number_format($s->hra,2); ?></td>
            <td><?php echo number_format($s->conveyance,2); ?></td>
            <td><?php echo number_format($s->special_allow,2); ?></td>
            <td><?php echo number_format($s->other_allow,2); ?></td>
            <td><?php echo $s->pf_applicable ? 'Yes' : 'No'; ?></td>
            <td><?php echo $s->esi_applicable ? 'Yes' : 'No'; ?></td>
            <td><?php echo CHtml::encode($s->pt_state); ?></td>
            <td><?php echo CHtml::encode($s->regime); ?></td>
            <td>
                <?php echo CHtml::link('View', array('salaryStructure/view','id'=>$s->id)); ?> |
                <?php echo CHtml::link('Edit', array('salaryStructure/update','id'=>$s->id)); ?> |
                <?php echo CHtml::link('Delete', '#', array('submit'=>array('salaryStructure/delete','id'=>$s->id),'confirm'=>'Are you sure?')); ?>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
