<?php

use yii\helpers\{Html,Url};
use yii\bootstrap\{Modal,ActiveForm};

$this->title = Yii::t('profile',"PERSONAL_PAGE");
$this->params['breadcrumbs'][] = $this->title;

$user = \Yii::$app->user->identity;
?>
<div class="row">
	<div class="col-lg-4">
		<h2><?php echo Yii::t('profile',"PERSONAL_DATA"); ?></h2>

		<?php
			if(Yii::$app->user->can("base")){
				echo Html::a(\Yii::t('profile','CHANGE_PROFILE'),['profile/change'],['class'=>'btn btn-primary']);
			}
		?>

		<table class="table table-bordered table-hover">
			<tr>
				<td><?php echo Yii::t('profile',"PERSONAL_INITIATES"); ?></td>
				<td><?php echo Html::encode($user->fullName)?></td>
			</tr>
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

		<div class="row">
			<div class="col-xs-4">
				<?php
					echo Html::a(Yii::t('profile',"SHOW_STORY"),['profile/story'],['class'=>'btn btn-primary']);
				?>
			</div>
		</div>
	</div>

	<div class="col-lg-8">
		<h2><?php echo Yii::t("profile","SESSION_DATA")?></h2>
		<div class="row">
			<div class="col-lg-8">
				<?php
					$sessions = $user->actualSessions;

					if(!$sessions){
				?>
						<div class="row">
							<?php $sForm = ActiveForm::begin(['id'=>"session_form"]);?>
							<div class="col-lg-4">
								<?php echo $sForm->field($sessionModel,"station_code")->textInput();?>
							</div>
							<div class="col-lg-4">
								<?php echo $sForm->field($sessionModel,"stand_number")->textInput();?>
							</div>
							<div class="col-lg-4">
								<?php echo Html::submitButton(Yii::t('profile',"SESSION_START"),['class'=>'btn btn-primary']);?>
							</div>
							<?php ActiveForm::end(); ?>
						</div>
				<?php }else{
					?>
					<table class="table table-hover table-bordered">
						<tr>
							<th><?php echo "#";?></th>
							<th><?php echo Yii::t('profile',"STATION");?></th>
							<th><?php echo Yii::t('profile',"STAND");?></th>
							<th><?php echo Yii::t('profile',"START_TIME");?></th>
							<th><?php echo Yii::t('profile',"FINISH_TIME");?></th>
							<th><?php echo Yii::t('profile',"SESSION_STATE");?></th>
							<th><?php echo Yii::t('profile',"SESSION_ACTIONS");?></th>
						</tr>
						<?php
							foreach ($sessions as $key => $session) {
						?>
							<tr>
								<td><?php echo ++$key;?></td>
								<td><?php echo $session->station->code;?></td>
								<td><?php echo $session->stand->number;?></td>
								<td><?php echo $session->start_time;?></td>
								<td><?php echo $session->finish_time;?></td>
								<td><?php echo !$session->accepted ? Yii::t('profile','NOT_ACCEPTED') : Yii::t('profile','ACCEPTED');?></td>
								<td>
									
									<?php 
										if($session->accepted){
											$stopForm = ActiveForm::begin();

											echo Html::input("hidden","Stop[session_id]",$session->id);
											echo Html::submitButton(Yii::t('profile',"STOP_PARKING"),['class'=>'btn btn-primary']);
											ActiveForm::end();
										}
									?>

								</td>
							</tr>
						<?php
							}
						?>
					</table>
				<?php } ?>
			</div>
		</div>
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

