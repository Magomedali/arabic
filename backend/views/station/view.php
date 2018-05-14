<?php

use yii\helpers\{Html,Url};

$this->title = Yii::t('station',"STATION_TITLE",['code'=>$model->code]);
?>
<div class="row">
	<div class="col-xs-12 page-action-panel">
		<?php
			if(\Yii::$app->user->can("superadmin")){
            	echo Html::a(Yii::t('station','TO_UPDATE'),['/station/create','id'=>$model->id],['class'=>'btn btn-primary']);
			}
		?>
	</div>
</div>
<div class="row">
	<div class="col-xs-3">
		<h4><?php echo Yii::t('station','PARAMETERS');?></h4>
		<table class="table table-bordered table-collapsed table-hover">
			<tr>
				<td><?php echo $model->getAttributeLabel("code");?></td><td><?php echo Html::encode($model->code);?></td>
			</tr>
			<tr>
				<td><?php echo $model->getAttributeLabel("latitude");?></td><td><?php echo Html::encode($model->latitude);?></td>
			</tr>
			<tr>
				<td><?php echo $model->getAttributeLabel("longitude");?></td><td><?php echo Html::encode($model->longitude);?></td>
			</tr>
			<tr>
				<td><?php echo $model->getAttributeLabel("ip");?></td><td><?php echo Html::encode($model->ip);?></td>
			</tr>
			<tr>
				<td><?php echo $model->getAttributeLabel("version_id");?></td><td><?php echo Html::encode($model->currentVersionNumber);?></td>
			</tr>
			<tr>
				<td><?php echo $model->getAttributeLabel("isDeleted");?></td><td><?php echo Html::encode($model->isDeleted? Yii::t('station','DELETED') : Yii::t('station','NOT_DELETED'));?></td>
			</tr>
		</table>
	</div>

	<div class="col-xs-3">
		<h4><?php echo Yii::t('station','STANDS');?></h4>
		<table class="table table-bordered table-collapsed table-hover">
			<tr>
				<th>#ID</th><th><?php echo Yii::t('stand','number')?></th><th><?php echo Yii::t('stand','version_id')?></th>
				<th><?php echo Yii::t('stand','isDeleted')?></th>
			</tr>
			<?php
				$stands = $model->stands;
				if(is_array($stands) && count($stands)){
					foreach ($stands as $key => $stand) {
						?>
						<tr>
							<td><?php echo Html::encode($stand->id)?></td>
							<td><?php echo Html::encode($stand->number)?></td>
							<td><?php echo Html::encode($stand->currentVersionNumber)?></td>
							<td><?php echo Html::encode($model->isDeleted? Yii::t('station','DELETED') : Yii::t('station','NOT_DELETED'));?></td>
						</tr>
						<?php
					}
				}
			?>
		</table>
	</div>
</div>