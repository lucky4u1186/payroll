<h2>Tax Slab Details</h2>

<table class="table">
<tr><th>Regime</th><td><?php echo $model->regime; ?></td></tr>
<tr><th>Slab From</th><td><?php echo number_format($model->slab_from); ?></td></tr>
<tr><th>Slab To</th><td><?php echo number_format($model->slab_to); ?></td></tr>
<tr><th>Rate</th><td><?php echo $model->rate; ?>%</td></tr>
</table>

<p><?php echo CHtml::link('Edit', array('taxSlab/update','id'=>$model->id)); ?></p>
