<?php

use yii\helpers\{Html,Url};
use yii\bootstrap\ActiveForm;
use common\widgets\googlemap\GoogleMap;


$this->title = Yii::t('site',"STATIONS_MAP");

?>

<div class="row">
	<div class="col-xs-12">
		<div id="map">
			<?php

				$lat = 59.9309;
				$lng = 30.3608;
				echo GoogleMap::widget([
					'mapOptions'=>[
						'name'=>"mapStations",
						'center'=>[
							'lat'=>$lat,
							'lng'=>$lng,
						],
						'zoom'=>15,
						'width'=>"100%",
						'height'=>"650",
					],
					'stations'=>$stations
				]);
			?>
		</div>
	</div>
</div>