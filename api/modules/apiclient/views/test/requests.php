<?php

use yii\helpers\{Html,Url};

$this->title = "Api requests";

?>

<div class="row">
	<div class="col-xs-12">
			<?php
				if(isset($requests['ok']) && $requests['ok'] == 1 && isset($requests['requests']) && is_array($requests['requests'])){
					

					echo Html::a("Execute all",['/apiclient/test/execute-requests'],['class'=>'btn btn-primary']);
					?>
					<table class="table table-bordered table-collapsed table-hover">	
						<tr>
							<th>#</th>
							<th>id</th>
							<th>method</th>
							<th>params</th>
							<th>action</th>
						</tr>
					
					<?php
						foreach ($requests['requests'] as $key => $r) {
					
					?>
						<tr>
							<td><?php echo ++$key?></td>
							<td><?php echo $r['id']?></td>
							<td><?php echo $r['method']?></td>
							<td><?php echo json_encode($r['params'])?></td>
							<th>
								<?php
									echo Html::a("execute",['/apiclient/test/execute-requests','id'=>$r['id']],['class'=>'btn btn-success']);

									echo Html::a("fail",['/apiclient/test/execute-danger','id'=>$r['id']],['class'=>'btn btn-danger']);
								?>
							</th>
						</tr>

					<?php } ?>
					</table>
					<?php
				}else{
					?>
					<h2>Requests not found!</h2>
					<?php
				}
			?>
	</div>
</div>