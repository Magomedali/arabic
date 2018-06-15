<?php
use yii\helpers\{Html,Url};
use yii\bootstrap\ActiveForm;
use common\models\{Element,LearningProcess};

$this->title = Yii::t("lesson","LESSON_NAME",['name'=>$model->title]);


$this->params['breadcrumbs'][] = [
		'label' => Yii::t("level","LEVELS"),
		'url'   => Url::to(['level/index'])
];

$this->params['breadcrumbs'][] = [
		'label' => Yii::t("level","LEVEL"),
		'url'   => Url::to(['level/lessons','id'=>$model->level])
];

$this->params['breadcrumbs'][] = $this->title;

$nextLesson = $model->nextLesson;

$prevLesson = $model->prevLesson;

$user = \Yii::$app->user->identity;

$lessonIsProcessed = $user->lessonIsProcessed($model->id);

?>
<div class="row">
	<div class="col-xs-12">
		<div class="pull-left previous_lesson">
			<?php
				if(isset($prevLesson->id)){
					echo Html::a("Предыдущий",['level/lesson','id'=>$prevLesson->id],['class'=>'btn btn-primary text-left']);
				}
			?>
			
		</div>
		
		<div class="pull-left lesson-title">
			<h2><?php echo Html::encode($model->title);?></h2>
			<?php echo $lessonIsProcessed ? Html::tag("span","(пройден!)"): "" ?> 
		</div>	
			
		<div class="pull-right">
			<?php
				if(isset($nextLesson->id)){
					echo Html::a("Следующий",['level/lesson','id'=>$nextLesson->id],['class'=>'btn btn-primary']);
				}
			?>
		</div>
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


		<?php
			$firstBlock = $model->firstBlock;
			if(isset($firstBlock->id)){
		?>
			<div class="pull-center" style="text-align: center;">
				<?php echo Html::a("Перейти к изучению",['lesson/block','id'=>$model->id,'block_id'=>$firstBlock->id],['class'=>'btn btn-success']);?>
			</div>
		<?php
			}
		?>
		
		
	</div>
</div>
