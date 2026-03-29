<h2>Tax Slab Management</h2>

<p><?php echo CHtml::link('Add New Slab', array('taxSlab/create'), array('class'=>'btn btn-primary')); ?></p>

<table class="table">
<thead>
<tr>
    <th>Regime</th>
    <th>From (₹)</th>
    <th>To (₹)</th>
    <th>Rate (%)</th>
    <th>Actions</th>
</tr>
</thead>
<tbody>
<?php foreach($slabs as $s): ?>
<tr>
    <td><?php echo CHtml::encode($s->regime); ?></td>
    <td><?php echo number_format($s->slab_from); ?></td>
    <td><?php echo number_format($s->slab_to); ?></td>
    <td><?php echo $s->rate; ?>%</td>
    <td>
        <?php echo CHtml::link('Edit', array('taxSlab/update','id'=>$s->id)); ?> |
        <?php echo CHtml::link('Delete', '#', array(
            'submit'=>array('taxSlab/delete','id'=>$s->id),
            'confirm'=>'Delete this tax slab?'
        )); ?>
    </td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
