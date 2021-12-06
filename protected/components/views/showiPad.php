
<?php $this->widget('booster.widgets.TbGridView',array(
'id'=>'ipad-usage-grid',
'dataProvider'=>$model->searchOwner($barCode),
'filter'=>$model,
'columns'=>array(
		//'id',
		//'Code',
		//'barCode',
		'academicyear',
		'Code',
		'hasReturn',
		'ReturnAdapter',
		'ReturnCable',
		'HasPan',
		'hasReturnPan',
		
array(
'class'=>'booster.widgets.TbButtonColumn',
),
),
)); ?>
