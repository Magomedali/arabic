<?php

use yii\helpers\{Html,Url};

$this->title = Yii::t('level',"LEVEL_TITLE",['title'=>$model->title]);
?>
<div class="row">
	<div class="col-xs-12 page-action-panel">
		<?php
			if(\Yii::$app->user->can("superadmin")){
            	echo Html::a(Yii::t('level','TO_UPDATE'),['/level/form','id'=>$model->id],['class'=>'btn btn-primary']);
			}
			if(\Yii::$app->user->can("superadmin")){
            	echo Html::a(Yii::t('level','TO_DELETE'),['/level/delete','id'=>$model->id],['class'=>'btn btn-danger','data-confirm'=>Yii::t('level','confirm_delete')]);
			}
		?>
	</div>
</div>
<div class="row">
	<div class="col-xs-3">
		<h4><?php echo Yii::t('level','LEVEL');?></h4>
		<table class="table table-bordered table-collapsed table-hover">
			<tr>
				<td><?php echo $model->getAttributeLabel("title");?></td><td><?php echo Html::encode($model->title);?></td>
			</tr>
			<tr>
				<td><?php echo $model->getAttributeLabel("desc");?></td><td><?php echo Html::encode($model->desc);?></td>
			</tr>
			<tr>
				<td><?php echo $model->getAttributeLabel("position");?></td><td><?php echo Html::encode($model->position);?></td>
			</tr>
			
		</table>
	</div>

	
</div>