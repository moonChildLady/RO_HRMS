<div class="tab-pane fade" id="step3">
	<div class="panel-body" id="loadPrograme">
		
	</div>
	   <p class="text-right">
	   <a class="btn btn-default back" href="#">Back <span class="chi">上一步</span></a>
	<?php
	echo CHtml::ajaxLink('Save Draft 儲存草稿',
			Yii::app()->createUrl('lwwSelection/submitPrograme'),
			array(
				'type'=>'POST',
				'data'=> 'js:$("#lww-selection-form").serialize()+"&savemode=DRAFT"',
				'success'=>'js:function(string){ 
					//console.log(string);
					$("#loadfinish").empty().append(string);
					 var nextId = $(".next_3").parents(".tab-pane").next().attr("id");
					$("[href=#"+nextId+"]").tab("show");
					$.scrollTo($(".navbar"), { duration: 0});
				}'           
				//'update'=>'#step3_programmetable', 
				),
				array(
				'class'=>'btn btn-warning next_3',
				));
?>
		<?php
	echo CHtml::ajaxLink('Submit 提交',
			Yii::app()->createUrl('lwwSelection/submitPrograme'),
			array(
				'type'=>'POST',
				'data'=> 'js:$("#lww-selection-form").serialize()+"&savemode=SUBMIT"',
				'success'=>'js:function(string){ 
					$("#loadfinish").empty().append(string);
					 var nextId = $(".next_3").parents(".tab-pane").next().attr("id");
					$("[href=#"+nextId+"]").tab("show");
					$.scrollTo($(".navbar"), { duration: 0});
				}'           
				//'update'=>'#step3_programmetable', 
				),
				array(
				'class'=>'btn btn-primary next_3',
				));
?>
</p>   
	  </div>
 



