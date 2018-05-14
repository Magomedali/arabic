<?php

use yii\helpers\{Html,Url};
use yii\bootstrap\ActiveForm;

?>

<div>
	<?php $form = ActiveForm::begin(['id'=>'add-email']);?>
		
		<?php echo $form->field($model,'email')->textInput(); ?>
		<?php echo Html::submitButton("Сохранить",['class'=>'btn btn-primary']);?>
	<?php ActiveForm::end();?>
</div>