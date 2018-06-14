<?php
use yii\helpers\{Html,Url};
use backend\models\{Element};

?>
<?php if($e->type == Element::TYPE_AUDIO){ ?>
	<div class="element_audio_text">
		<?php echo $e->content; ?>
	</div>
	<div class="element_audio">
		<?php if($e->audio_icon && file_exists($_SERVER['DOCUMENT_ROOT'].$e->audio_icon_path)){?>
		<div class="img_icon_for_audio">
			<img src="<?php echo $e->audio_icon_path?>">
		</div>
		<?php } ?>

		<?php if($e->file_name && file_exists($_SERVER['DOCUMENT_ROOT'].$e->file)){?>
		<audio id="audio_<?php echo $e->block?>_<?php echo $e->id?>" controls>
			<source src="<?php echo $e->file?>">
			Ваш браузер не пожжерживает тег audio!
		</audio>
		<?php } ?>
	</div>
<?php } ?>