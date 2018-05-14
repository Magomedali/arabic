<?php

use yii\helpers\{Html,Url};
use yii\bootstrap\ActiveForm;

?>

<div>
	<?php $form = ActiveForm::begin(['id'=>'add-phone']);?>
		
		<?php echo $form->field($model,'phone')->textInput(); ?>
		<?php echo Html::submitButton("Сохранить",['class'=>'btn btn-primary']);?>
	<?php ActiveForm::end();?>
</div>