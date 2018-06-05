<?php
use yii\helpers\{Html,Url};
use backend\models\Element;

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
?>
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