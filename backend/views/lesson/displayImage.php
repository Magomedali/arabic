<?php
use yii\helpers\{Html,Url};
use backend\models\{Element};

?>
<?php if($e->type == Element::TYPE_IMAGE){ ?>
	<div class="element_image_text">
		<?php echo $e->content; ?>
	</div>
	<div class="element_image">
		<img src="<?php echo $e->file?>">
	</div>
<?php } ?>