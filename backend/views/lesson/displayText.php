<?php
use yii\helpers\{Html,Url};
use common\models\{Element};

?>
<?php if($e->type == Element::TYPE_TEXT){ ?>
	<div class="element_text">
		<?php echo $e->content; ?>
	</div>
<?php } ?>