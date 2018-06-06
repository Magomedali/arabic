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
	<div class="col-xs-12 blocks">
		<?php
			$blocks = $model->blocks;
			if(is_array($blocks)){
				foreach ($blocks as $key => $block) {
					$elements = $block->elements;
					?>
					<div class="row block">
						<div class="col-xs-12 elements">
							
						
					<?php
					if(is_array($elements)){
						foreach ($elements as $key2 => $e) {
						?>
							<div class="element">
								<?php 

									if($e->type == Element::TYPE_TEXT){
									?>
										<div class="element_text">
											<?php echo $e->content; ?>
										</div>
									<?php
									}elseif($e->type == Element::TYPE_IMAGE){
									?>	
										<div class="element_image_text">
											<?php echo $e->content; ?>
										</div>
										<div class="element_image">
											<img src="<?php echo $e->file?>">
										</div>
									<?php
									}elseif($e->type == Element::TYPE_AUDIO){
									?>	
										<div class="element_audio_text">
											<?php echo $e->content; ?>
										</div>
										<div class="element_audio">
											<audio controls>
												<source src="<?php echo $e->file?>">
												Ваш браузер не пожжерживает тег audio!
											</audio>
										</div>
									<?php
									}
								?>
							</div>
						<?php
						}
					}
					?>
						</div>
					</div>
					<?php
				}
			}
		?>
	</div>
</div>


<?php
	if(!$lessonIsProcessed){
?>
<div class="row">
	<div class="col-xs-12">
		<?php $form = ActiveForm::begin(['action'=>['lesson/process']]);?>
			
		<?php echo Html::hiddenInput('lesson',$model->id); ?>
			
		<?php echo Html::submitButton("Материал пройден",['class'=>'btn btn-success']); ?>
			
		<?php ActiveForm::end();?>
	</div>
</div>
<?php
	}
?>