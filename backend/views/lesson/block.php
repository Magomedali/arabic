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
		'url'   => Url::to(['level/view','id'=>$model->level])
];

$this->params['breadcrumbs'][] = [
		'label' => Yii::t("lesson","LESSON"),
		'url'   => Url::to(['lesson/view','id'=>$model->id])
];

$this->params['breadcrumbs'][] = $this->title;




$elements = [];
if(isset($currentBlock->id)){
	$elements = $currentBlock->publicElements;
}

$tableElements = [];
$ulOpen = false;
$tableRendered = false;
if(is_array($elements)){
	foreach ($elements as $key => $e) {
		if($e->displayInTable){
			$tableElements[$e->id] = $e;
		}
	}
}



?>
<div class="row">
	<div class="col-xs-12">
		<?php if(isset($currentBlock->id)){ ?>
					<div class="row block">
						<div class="col-xs-12 elements">
							
						
					<?php
					if(is_array($elements)){

						$dIl= $currentBlock->displayInline;
						
						if(!count($tableElements) && $dIl){ $ulOpen = true;?> <ul> <?php }

						foreach ($elements as $key2 => $e) {


							if(count($tableElements) && $dIl && !$ulOpen && !array_key_exists($e->id, $tableElements)){
								$ulOpen = true;
							?>
								<ul>
							<?php
							}elseif(count($tableElements) && $dIl && $ulOpen && array_key_exists($e->id, $tableElements)){
								$ulOpen = false;
							?>
								</ul>
							<?php
							}


							if(count($tableElements) && !$tableRendered && array_key_exists($e->id, $tableElements)){ ?>
								<div class="element">
									<?php echo $this->render("displayTableElements",['tableElements'=>$tableElements]); ?>
								</div>
							<?php
								$tableRendered = true;
							}

							if(array_key_exists($e->id, $tableElements) && $tableRendered){

								continue;
							}


							if($ulOpen){ ?> <li> <?php }


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
							if($ulOpen){ ?> </li> <?php }
						}

						if($ulOpen && $dIl){ $ulOpen = false; ?> </ul> <?php }
					}
					?>
						</div>
					</div>
					<?php
			}
		?>


		


		<?php if(isset($blocks) && count($blocks)){ ?>
			<div class="row">
				<div class="col-xs-12">
					
				<ul class="pagination">
				<?php foreach ($blocks as $key => $block) { ?>
					<li class="<?php echo $block->id == $currentBlock->id ? "active":""?>">
						<?php echo $block->id != $currentBlock->id ? Html::a($key+1,['lesson/block','id'=>$model->id,'block_id'=>$block->id],['class'=>'']) : Html::a($key+1,"#",['class'=>'']) ;?>
					</li>
				<?php } ?>
			
				</ul>
				</div>
			</div>
		<?php } ?> 
	</div>
</div>





<?php 
$script = <<<JS
	if($(".img_icon_for_audio img").length){
		$(".img_icon_for_audio img").css("cursor","pointer");
		$(".img_icon_for_audio img").click(function(){
			
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



	//Для таблиц
	if($(".element_audio_image,.element_audio_content").length){
		$(".element_audio_image,.element_audio_content").css("cursor","pointer");
		$(".element_audio_image,.element_audio_content").click(function(){
			
			var audio_id = parseInt($(this).parents("td").data("id"));
			var a = document.getElementById("audio__"+audio_id);
			
			if(a){
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