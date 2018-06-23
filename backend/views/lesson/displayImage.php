<?php
use yii\helpers\{Html,Url};
use common\models\{Element};

?>
<?php if($e->type == Element::TYPE_IMAGE){ ?>
	<div class="element_image_text">
		<?php echo $e->content; ?>
	</div>
	<?php if($e->file_name && file_exists($_SERVER['DOCUMENT_ROOT'].$e->file)){?>
	<div class="element_image">
		<img src="<?php echo $e->file?>">
	</div>
	<?php } ?>
<?php } ?>