<?php
$emp = $model->employee;
$items = $model->items;
$earnings = array();
$deductions = array();
$employer = array();
foreach($items as $it){
    if($it->type == 'earning') $earnings[] = $it;
    if($it->type == 'deduction') $deductions[] = $it;
    if($it->type == 'employer_contribution') $employer[] = $it;
}
$max = max(count($earnings), count($deductions));
?>

<style>
    table.payslip { width:100%; border-collapse:collapse; font-family: Arial, sans-serif; }
    table.payslip td, table.payslip th { border:1px solid #000; padding:6px; vertical-align:top; }
    .highlight { background:#ffd800; font-weight:700; }
    .right { text-align:right; }
</style>

<table class="payslip">
    <tr>
        <td colspan="4"><strong>Name of the Employee:</strong> <?php echo CHtml::encode($emp->name); ?></td>
    </tr>
    <tr>
        <td><strong>Employee ID</strong></td><td><?php echo CHtml::encode($emp->employee_id); ?></td>
        <td><strong>PAN</strong></td><td><?php echo CHtml::encode($emp->pan); ?></td>
    </tr>
    <tr>
        <td><strong>UAN Account No:</strong></td><td><?php echo CHtml::encode($emp->uan); ?></td>
        <td><strong>ESIC/Insurance No:</strong></td><td><?php echo CHtml::encode($emp->esic); ?></td>
    </tr>
    <tr>
        <td><strong>Designation:</strong></td><td><?php echo CHtml::encode($emp->designation); ?></td>
        <td><strong>Month & Year:</strong></td><td><?php echo date('F Y', strtotime($model->month_year)); ?></td>
    </tr>
    <tr>
        <td><strong>Monthly CTC:</strong></td><td><?php echo number_format($emp->monthly_ctc,2); ?></td>
        <td><strong>Total Working Days:</strong></td><td><?php echo (int)$model->total_working_days; ?></td>
    </tr>

    <tr class="highlight">
        <th>Earnings</th><th>Amount</th><th>Deductions</th><th>Amount</th>
    </tr>

    <?php
    for($i=0;$i<$max;$i++):
        $e = isset($earnings[$i]) ? $earnings[$i] : null;
        $d = isset($deductions[$i]) ? $deductions[$i] : null;
    ?>
    <tr>
        <td><?php echo $e ? CHtml::encode($e->label) : '&nbsp;'; ?></td>
        <td class="right"><?php echo $e ? number_format($e->amount,2) : '&nbsp;'; ?></td>
        <td><?php echo $d ? CHtml::encode($d->label) : '&nbsp;'; ?></td>
        <td class="right"><?php echo $d ? number_format($d->amount,2) : '&nbsp;'; ?></td>
    </tr>
    <?php endfor; ?>

    <tr class="highlight">
        <td><strong>Total Earnings</strong></td>
        <td class="right"><?php echo number_format($model->total_earnings,2); ?></td>
        <td><strong>Total Deduction</strong></td>
        <td class="right"><?php echo number_format($model->total_deductions,2); ?></td>
    </tr>

    <tr class="highlight"><th colspan="4">Employer Contribution</th></tr>
    <?php foreach($employer as $c): ?>
    <tr>
        <td colspan="3"><?php echo CHtml::encode($c->label); ?></td>
        <td class="right"><?php echo number_format($c->amount,2); ?></td>
    </tr>
    <?php endforeach; ?>

    <tr class="highlight">
        <td><strong>CTC</strong></td>
        <td class="right"><?php echo number_format($emp->monthly_ctc,2); ?></td>
        <td><strong>NET Salary Payable</strong></td>
        <td class="right"><?php echo number_format($model->net_payable,2); ?></td>
    </tr>
</table>
