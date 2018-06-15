<?php
use yii\helpers\{Html,Url};
use common\models\{Element};

?>
<table class="table table-bordered">
	<?php   //Первая строка для изображения в основном    ?>
	<tr class="">
		<?php
			foreach ($tableElements as $key => $e) {
				$type = $e->type;
			?>
				<?php if($type == Element::TYPE_TEXT){ ?>
					<td class="td_element_text" data-id="<?php echo $e->id?>">
						<?php echo $e->content;	?>
					</td>
				<?php } ?>

				<?php if($type == Element::TYPE_AUDIO){ ?>
					<td class="td_element_audio" data-id="<?php echo $e->id?>">
						<?php if($e->audio_icon && file_exists($_SERVER['DOCUMENT_ROOT'].$e->audio_icon_path)){?>
							<div class="element_audio_image">
								<img src="<?php echo $e->audio_icon_path?>">
							</div>
						<?php } ?>
					</td>
				<?php } ?>

				<?php if($type == Element::TYPE_IMAGE){ ?>
					<td class="td_element_image" data-id="<?php echo $e->id?>">
						<?php if($e->file_name && file_exists($_SERVER['DOCUMENT_ROOT'].$e->file)){?>
							<div class="element_image">
								<img src="<?php echo $e->file?>">
							</div>
						<?php } ?>
					</td>
				<?php } ?>
			
		<?php } ?>
	</tr>

	<?php   //Вторая строка для контента   ?>
	<tr class="">
		<?php
			foreach ($tableElements as $key => $e) {
				$type = $e->type;
			?>

				<?php if($type == Element::TYPE_TEXT){ ?>
					<td class="td_element_text" data-id="<?php echo $e->id?>">
						
					</td>
				<?php } ?>

				<?php if($type == Element::TYPE_AUDIO){ ?>
					<td class="td_element_audio" data-id="<?php echo $e->id?>">
						
						<div class="element_audio_content">
							<?php echo $e->content;	?>
						</div>

						<?php if($e->file_name && file_exists($_SERVER['DOCUMENT_ROOT'].$e->file)){?>
							<div class="element_audio_file" style="display: none;">
								<audio id="audio__<?php echo $e->id?>" controls>
									<source src="<?php echo $e->file?>">
									Ваш браузер не поддерживает тег audio!
								</audio>
							</div>
						<?php } ?>
					</td>
				<?php } ?>

				<?php if($type == Element::TYPE_IMAGE){ ?>
					<td class="td_element_image" data-id="<?php echo $e->id?>">
						<div class="element_image_content">
							<?php echo $e->content;	?>
						</div>
					</td>
				<?php } ?>
			
		<?php } ?>
	</tr>


	<?php   //Третяя строка для перевода   ?>
	<tr class="">
		<?php
			foreach ($tableElements as $key => $e) {
				$type = $e->type;
			?>

				<?php if($type == Element::TYPE_TEXT){ ?>
					<td class="td_element_text" data-id="<?php echo $e->id?>">
						<div class="element_text_translate">
							<?php echo $e->translate;	?>
						</div>
					</td>
				<?php } ?>

				<?php if($type == Element::TYPE_AUDIO){ ?>
					<td class="td_element_audio" data-id="<?php echo $e->id?>">
						<div class="element_audio_translate">
							<?php echo $e->translate;	?>
						</div>
					</td>
				<?php } ?>

				<?php if($type == Element::TYPE_IMAGE){ ?>
					<td class="td_element_image" data-id="<?php echo $e->id?>">
						<div class="element_image_translate">
							<?php echo $e->translate;	?>
						</div>
					</td>
				<?php } ?>
			
		<?php } ?>
	</tr>

</table>