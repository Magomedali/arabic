<?php

use yii\helpers\{Html,Url};
use yii\bootstrap\ActiveForm;

$this->title = Yii::t('site','LEVEL_TITLE',['name'=>$model->title]);

?>
<div class="row">
	<div class="col-xs-12">
		<h1><?php echo $this->title; ?></h1>
	</div>
</div>
<div class="row">
	<div class="col-xs-12">
		<?php if($model->showDesc){?>
			<h3>Описание</h3>
			<div>
				<?php echo $model->desc?>
			</div>
		<?php } ?>
	</div>
</div>
<div class="row">
	<div class="col-xs-8">
		<?php if(count($lessons)){
			?>
			<table class="table table-bordered table-collapsed">
				<tr>
					<th>#</th>
					<th>Урок</th>
					<th>Действие</th>
				</tr>	
			
			<?php
			foreach ($lessons as $key => $l) {
				?>
				<tr>
					<td><?php echo $l->number?></td>
					<td><?php echo $l->title?></td>
					<td><?php echo Html::a("Открыть",['level/lesson','id'=>$l->id])?></td>
				</tr>
				<?php
			}
			?>
			</table>
			<?php
		}?>
	</div>
</div>