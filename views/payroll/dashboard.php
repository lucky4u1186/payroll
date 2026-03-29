<?php
/* @var $month string (YYYY-mm-01) */
/* @var $rows array */
/* @var $totals array */
$this->breadcrumbs=array('Payroll Dashboard');
?>
<h2>Payroll Dashboard — <?php echo date('F Y', strtotime($month)); ?></h2>

<p>
    <?php echo CHtml::link('Run payroll for all (bulk)', array('payroll/runAll','month'=>date('Y-m', strtotime($month))), array('class'=>'btn btn-primary','onclick'=>"return confirm('Run payroll for all employees for ".date('F Y', strtotime($month))."?')")); ?>
</p>

<table class="table">
    <thead>
        <tr><th>#</th><th>Employee</th><th>Gross</th><th>Status</th><th>Actions</th></tr>
    </thead>
    <tbody>
    <?php $i=1; foreach($rows as $r): ?>
        <tr>
            <td><?php echo $i++; ?></td>
            <td><?php echo CHtml::encode($r['employee']->name); ?></td>
            <td><?php echo number_format($r['gross'],2); ?></td>
            <td><?php echo CHtml::encode($r['status']); ?></td>
            <td>
                <?php if($r['status']=='Pending'): ?>
                    <?php echo CHtml::link('Generate', array('payroll/create','employee_id'=>$r['employee']->id), array('class'=>'btn-sm')); ?>
                <?php else: ?>
                    <?php echo CHtml::link('View Payslip', array('payroll/view','id'=>$r['payroll']->id), array('class'=>'btn-sm')); ?>
                <?php endif; ?>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<h3>Totals</h3>
<table class="table">
    <tr><th>Total Gross</th><td><?php echo number_format($totals['gross'],2); ?></td></tr>
    <tr><th>Total Deductions (generated)</th><td><?php echo number_format($totals['deductions'],2); ?></td></tr>
    <tr><th>Total Net (generated)</th><td><?php echo number_format($totals['net'],2); ?></td></tr>
</table>
