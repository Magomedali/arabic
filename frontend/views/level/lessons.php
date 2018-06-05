<?php

use yii\helpers\{Html,Url};
use yii\bootstrap\ActiveForm;

$this->title = Yii::t('site','LEVEL_TITLE');

?>
<div class="row">
	<div class="col-xs-12">
		<h1><?php echo Yii::t('site','LEVEL_TITLE')?></h1>
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