<?php
use yii\helpers\{Html,Url};
use yii\bootstrap\ActiveForm;
use backend\models\{Element};

$this->title = Yii::t("lesson","LESSON_TITLE",['title'=>$model->title]);


$this->params['breadcrumbs'][] = [
		'label' => Yii::t("level","LEVELS"),
		'url'   => Url::to(['level/index'])
];

$this->params['breadcrumbs'][] = [
		'label' => Yii::t("level","LEVEL"),
		'url'   => Url::to(['level/view','id'=>$model->level])
];

$this->params['breadcrumbs'][] = $this->title;

$nextLesson = $model->nextLesson;

$prevLesson = $model->prevLesson;



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
			<?php
				echo Html::a(Yii::t("site","TO_UPDATE"),['lesson/form','id'=>$model->id],['class'=>'btn btn-primary']);
			?>
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
	</div>
</div>
<div class="row">
	<div class="col-xs-12 blocks">
		<?php
			$blocks = $model->publicBlocks;
			if(is_array($blocks)){
				foreach ($blocks as $key => $block) {
					$elements = $block->publicElements;
					?>
					<div class="row block">
						<div class="col-xs-12 elements">
							
						
					<?php
					if(is_array($elements)){

						$dIl= $block->displayInline;
						
						if($dIl){ ?> <ul> <?php }

						foreach ($elements as $key2 => $e) {

							if($dIl){ ?> <li> <?php }
						?>
							<div class="element">
								<?php 

									if($e->type == Element::TYPE_TEXT){
										echo $this->render("displayText",['e'=>$e]);
									}elseif($e->type == Element::TYPE_IMAGE){
										echo $this->render("displayImage",['e'=>$e]);
									}elseif($e->type == Element::TYPE_AUDIO){
										echo $this->render("displayAudio",['e'=>$e]);
									}
								?>
							</div>
						<?php
							if($dIl){ ?> </li> <?php }
						}

						if($dIl){ ?> </ul> <?php }
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
$script = <<<JS
	if($(".img_icon_for_audio img").length){
		$(".img_icon_for_audio img").css("cursor","pointer");
		$(".img_icon_for_audio img").click(function(event){
			event.preventDefault();
			var audio = $(this).parent().siblings("audio");
			if(audio.length){
				var id = audio.attr("id");
				var a = document.getElementById(id);
				
				if(a.currentTime != 0.0){
					a.pause();
					a.currentTime = 0.0;
				}else{
					a.play();
				}
			}
		});
	}
JS;

	$this->registerJS($script);
?>