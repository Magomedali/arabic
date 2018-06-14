<?php

use yii\helpers\{Html,Url};
use yii\bootstrap\{Modal,ActiveForm};
use common\models\Level;

$this->title = Yii::t('profile',"PERSONAL_PAGE");
$this->params['breadcrumbs'][] = $this->title;

$user = \Yii::$app->user->identity;

?>
<div class="row">
	<div class="col-lg-4">
		<h2><?php echo Html::encode($user->fullName); ?></h2>

		<?php echo Html::a(\Yii::t('profile','CHANGE_PROFILE'),['profile/change'],['class'=>'btn btn-primary']); ?>

		<table class="table table-bordered table-hover">
			
			<tr>
				<td><?php echo Yii::t('profile',"EMAIL"); ?></td>
				<td>
					<?php 
						echo Html::encode($user->email);
						if(!(int)$user->email_confirmed){
							echo " не подтвержден!".Html::a("Отпарвить письмо для подтверждения!",['profile/send-confirm-email','e'=>Html::encode($user->email)]);
						}

						echo Html::a('&nbsp<span class="glyphicon glyphicon-pencil"></span>',['profile/add-email'],['id'=>'btnAddEmail']);
					?>

				</td>
			</tr>
			<tr>
				<td><?php echo Yii::t('user',"PHONE"); ?></td>
				<td>
					<?php
						if(!$user->phone){
							echo Html::a('&nbsp<span class="glyphicon glyphicon-plus"></span>',['profile/add-phone'],['id'=>'btnAddPhone']);
						}else{
							echo Html::encode($user->phone);

							if(!(int)$user->phone_confirmed)
								echo " не подтвержден!".Html::a("Отпарвить код для подтверждения!",['profile/send-confirm-phone','p'=>Html::encode($user->phone)]);

							echo Html::a('&nbsp<span class="glyphicon glyphicon-pencil"></span>',['profile/add-phone'],['id'=>'btnAddPhone']);
						}
					?>
				</td>
			</tr>
			<tr>
				<td><?php echo Yii::t('profile',"BORTH_DAY"); ?></td>
				<td><?php echo $user->bdate ? date("d.m.Y",strtotime($user->bdate)) : null; ?></td>
			</tr>
		</table>
		
	</div>
	<div class="col-lg-4">
		<?php 
			$lastLesson = $user->getCurrentLesson();
			if($lastLesson){
		?>
			<h3>Урок на котором вы остановились: <?php echo Html::a($lastLesson->title,['level/lesson','id'=>$lastLesson->id]);?></h3>
		<?php 
			}else{
				$level = new Level();
        		$firstLevel = $level->firstLevel;
        		if($firstLevel){
        		?>
					<h3><?php echo Html::a("Начать обучение",['level/lessons','id'=>$firstLevel->id],['class'=>'btn btn-success']);?></h3>
				<?php
        		}
			}
		?>
	</div>
</div>
<?php

	$script = <<<JS
		$(function(){
			$("#btnAddPhone").click(function(event){
				event.preventDefault();
				$("#modalAddPhone").modal('show').find(".modal-body").load($(this).attr('href'));
			});

			$("#btnAddEmail").click(function(event){
				event.preventDefault();
				$("#modalAddEmail").modal('show').find(".modal-body").load($(this).attr('href'));
			});
		});


JS;


$this->registerJs($script);


	Modal::begin([
		'header'=>"<h4>Телефон</h4>",
		'id'=>'modalAddPhone',
		'size'=>'modal-sm'
	]);
	Modal::end();


	Modal::begin([
		'header'=>"<h4>E-mail</h4>",
		'id'=>'modalAddEmail',
		'size'=>'modal-sm'
	]);
	Modal::end();
?>

