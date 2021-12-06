<?php
echo CHtml::openTag('div', array('class' => 'bs-navbar-top-example'));
$this->widget(
    'booster.widgets.TbNavbar',
    array(
        'brand' => 'Stewards Pooi Kei College',
        'brandOptions' => array('style' => 'width:auto;margin-left: 0px;'),
        'fixed' => 'top',
        'fluid' => true,
        'htmlOptions' => array('style' => 'position:absolute'),
        'items' => array(
            array(
                'class' => 'booster.widgets.TbMenu',
            	'type' => 'navbar',
                'items' => array(
                    array(
					'label' => 'Home', 
					'url' =>Yii::app()->createUrl('/backend/site/index'), 
					'active' => $this->controller->id=='site'?true:false
					),
					
					array(
					'label' => 'Settings', 
					'active' => ($this->controller->id=='publishedEvents' || $this->controller->id=='adminUsers')?true:false,
					
					'items'=>array(
						array(
						'label'=> 'SSP Cover Page',
						'url' =>Yii::app()->createUrl('/appl/reportLogAdmin')
						),
						array(
						'label'=> 'Events',
						'url' =>Yii::app()->createUrl('/publishedEvents/admin')
						),
						array(
						'label'=> 'Admin User',
						'url' =>Yii::app()->createUrl('/AdminUsers/admin')
						),
					)),
					
					/* array(
					'label' => 'SSP', 
					'active' => $this->controller->id=='appl'?true:false,
					
					'items'=>array(
						array(
						'label'=> 'Dashboard',
						'url' =>Yii::app()->createUrl('/appl/admin')
						),
						array(
						'label'=> 'Print slip [All]',
						'url' =>Yii::app()->createUrl('backend/appl/print/all')
						),
						array(
						'label'=> 'Print slip [Submit]',
						'url' =>Yii::app()->createUrl('backend/appl/print/submit')
						),
						array(
						'label'=> 'Print slip [Non-submit]',
						'url' =>Yii::app()->createUrl('backend/appl/print/nonsubmit')
						),
						array(
						'label'=> 'Excel [Non-submit]',
						'url' =>Yii::app()->createUrl('backend/appl/excel/nonsubmit')
						)
					)), */
					
                    //array('label' => 'Link', 'url' => array('/users'), 'active' => $this->controller->id=='users'?true:false),
					//array('label' => 'Close', 'url' => Yii::app()->createUrl('/users/close')),
                    array('label' => 'Close', 'url' => '#','itemOptions'=>array('class'=>'close_button')),
                )
            )
        )
    )
);
echo CHtml::closeTag('div');
?>