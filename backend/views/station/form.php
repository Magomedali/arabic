<?php

use yii\helpers\{Html,Url};
use yii\bootstrap\ActiveForm;
use backend\models\{PropertiesValue,Station};



use dosamigos\google\maps\LatLng;
use dosamigos\google\maps\overlays\InfoWindow;
use dosamigos\google\maps\overlays\Marker;
use dosamigos\google\maps\Map;
use dosamigos\google\maps\layers\BicyclingLayer;
use dosamigos\google\maps\Event;

$this->title = isset($model->code) ? Yii::t("station","UPDATE_STATION",['code'=>$model->code]) : Yii::t("station","NEW_STATION");


?>

<div class="row">
	<div class="col-xs-12 page-action-panel">
		
	</div>
</div>

<div class="row">
<?php $form = ActiveForm::begin(['id'=>'formStation']);?>
	<div class="col-xs-3">
		
		<?php echo $form->field($model,'code')->textinput();?>
		<?php echo $form->field($model,'latitude')->textinput();?>
		<?php echo $form->field($model,'longitude')->textinput();?>
		<?php echo $form->field($model,'ip')->textinput();?>
		<?php echo $form->field($model,'address')->textinput();?>
		<?php echo Html::input("text",'station-hidden-address',"",['id'=>'station-hidden-address','class'=>'form-control'])?>
		<?php echo Html::submitButton(Yii::t('station','SAVE'),['class'=>'btn btn-primary'])?>
	</div>

	<div class="col-xs-3">
		<?php
			$properties = $model->properties;
			$propertiesValues = $model->propertiesValue;
			if(is_array($properties) && count($properties)){
				foreach ($properties as $key => $prop) {
					
					$v = array_key_exists($prop->id, $propertiesValues) ? $propertiesValues[$prop->id]['value'] : "";
					echo $form->field(new PropertiesValue,"value",['inputOptions'=>['name'=>"PropertiesValue[{$key}][value]"]])->textinput(['value'=>$v])->label($prop->title);
					
					if(isset($model->id))
						echo $form->field(new PropertiesValue,"station_id",['inputOptions'=>['name'=>"PropertiesValue[{$key}][station_id]"]])->hiddenInput(['value'=>$model->id])->label(false);
					
					echo $form->field(new PropertiesValue,"property_id",['inputOptions'=>['name'=>"PropertiesValue[{$key}][property_id]"]])->hiddenInput(['value'=>$prop->id])->label(false);
					?>
					<?php
				}
			}
		?>
	</div>

	<div class="col-xs-3">
		<?php
			echo Html::a(Yii::t('station','ADD_STAND'),'#',['class'=>'btn btn-primary','id'=>'btn-add-stand']);
			echo Html::a(Yii::t('station','REMOVE_STAND'),'#',['class'=>'btn btn-danger','id'=>'btn-remove-stand']);
			$js = <<<JS
				var addStand = function(){
					var stands = $('.stands');
					var stand = "";
					var c = stands.find('.stand').length + 1;
					stand += "<div class='form-group stand'>";
						stand +="<label class='form-label'>Стойка #" + c + "</label>";
						stand +="<input type='text' name='Stands["+c+"][number]' class='form-control' value='"+c+"' readonly>";
					stand +="</div>";

					stands.append(stand);
				}

				var removeStand = function(){
					var stand = $('.stands .stand').eq(-1);
					if(!stand.find("input[type=hidden]").length){
						stand.remove();
					}
				}

				$("#btn-add-stand").click(function(event){
					event.preventDefault();
					addStand();
				})

				$("#btn-remove-stand").click(function(event){
					event.preventDefault();
					removeStand();
				});
JS;
		
			$this->registerJs($js);
		?>
		<div class="stands">
			<?php
				if(isset($standsModels) && is_array($standsModels) && count($standsModels)){
					foreach ($standsModels as $key => $stand) {
							$c = ++$key;
						?>
							<div class='form-group stand'>
								<?php 
									if(isset($stand['id'])){
								?>
									<input type="hidden" name="Stands[<?php echo $c ?>][id]" class='stand_id' value="<?php echo $stand['id'] ?>">
								<?php 
									}
								?>
								<label class='form-label'>Стойка #<?php echo $c?></label>
								<input type="text" name="Stands[<?php echo $c ?>][number]" class='form-control' value="<?php echo $stand['number'] ?>" readonly>
							</div>
						<?php
					}
				}
			?>
		</div>
	</div>
<?php ActiveForm::end();?>
</div>


<div class="row">
	<div class="col-xs-12">
		<div class="row">
			<div class="col-xs-12">
				<h3>Карта</h3>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12">
				<div id="map" style="height: 450px;">
					<?php

						$tMarker = "thisMarker";
						$mapName = "mapStations";

						$lat = $model->code ? $model->latitude : 59.9309;
						$lng = $model->code ? $model->longitude : 30.3608;

						$coord = new LatLng(['lat' => $lat, 'lng' => $lng]);
						
						$map = new Map([
						    'center' => $coord,
						    'zoom' => 15,
						    'zoomControl' => true,
						    "disableDefaultUI" => false,
							"zoomControl" => true,
					    	"scaleControl" => false,
					    	"mapTypeControl" => true,
					  		"streetViewControl" => true,
					  		"rotateControl" => true,
					  		'mapTypeId'=> 'roadmap'
						]);

						$map->width = "100%";
						$map->height = "450";
						$map->setName($mapName);

						$stations = Station::find()->where(['isDeleted'=>0])->all();

						if(isset($stations) && is_array($stations)){
							foreach ($stations as $key => $s) {
								if(isset($model->id) && $model->id == $s->id){
									continue;
								}
								$c = new LatLng(['lat' => $s->latitude, 'lng' => $s->longitude]);
								$marker = new Marker([
									'name'=>'s'.$s->code,
									'title'=>'Station #'.$s->code,
									'position'=>$c
								]);

								$marker->attachInfoWindow(new InfoWindow([
									'content'=>"Station #".$s->code,
								]));
								$map->addOverlay($marker);
							}
						}

						// Lets show the BicyclingLayer :)
						//$bikeLayer = new BicyclingLayer(['map' => $map->getName()]);
						// Append its resulting script
						//$map->appendScript($bikeLayer->getJs());
						$marker = new Marker([
						    'position' => $coord,
						]);

						$marker->attachInfoWindow(new InfoWindow([
								'content'=>isset($model->code) ? "Станция #".$model->code : "Новая станция",
						]));

						$marker->setName($tMarker);
						
						$map->addOverlay($marker);

$script = <<<JS
	function(event){
		$tMarker.setPosition(event.latLng);
		$tMarker.setMap($mapName);
		$("#station-latitude").val($tMarker.getPosition().lat());
		$("#station-longitude").val($tMarker.getPosition().lng());
	}
JS;
						$e = new Event([
							'trigger' =>"click",
							'js' => $script,
							'wrap'=>false,
						]);

						$map->addEvent($e);

$script= <<<JS
	var input = document.getElementById('station-hidden-address');
    var searchBox = new google.maps.places.SearchBox(input);
    {$mapName}.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

    var markers = [];

    searchBox.addListener('places_changed', function() {
          var places = searchBox.getPlaces();

          if (places.length == 0) {
            return;
          }

          // Clear out the old markers.
          markers.forEach(function(marker) {
            marker.setMap(null);
          });
          markers = [];

          // For each place, get the icon, name and location.
          var bounds = new google.maps.LatLngBounds();
          places.forEach(function(place) {
            if (!place.geometry) {
              console.log("Returned place contains no geometry");
              return;
            }
            var icon = {
              url: place.icon,
              size: new google.maps.Size(71, 71),
              origin: new google.maps.Point(0, 0),
              anchor: new google.maps.Point(17, 34),
              scaledSize: new google.maps.Size(25, 25)
            };
            
            $("#station-latitude").val(place.geometry.location.lat());
			$("#station-longitude").val(place.geometry.location.lng());

            // Create a marker for each place.
            markers.push(new google.maps.Marker({
              map: {$mapName},
              icon: icon,
              title: place.name,
              position: place.geometry.location
            }));

            if (place.geometry.viewport) {
              // Only geocodes have viewport.
              bounds.union(place.geometry.viewport);
            } else {
              bounds.extend(place.geometry.location);
            }
          });
          {$mapName}.fitBounds(bounds);
        });
JS;


$map->appendScript($script);

						$script = <<<JS
	function(event){
		searchBox.setBounds({$mapName}.getBounds());
	}
JS;
						$e2 = new Event([
							'trigger' =>"bounds_changed",
							'js' => $script,
							'wrap'=>false,
						]);

						$map->addEvent($e2);

$script = <<<JS
	
	// $('#station-latitude').val(start_lat);
	// $('#station-longitude').val(start_lng);

	$("#station-latitude,#station-longitude").keyup(function(){
		var lng = $("#station-longitude").val();
		var lat = $("#station-latitude").val();

		if(lng && lat){
			var pos = new google.maps.LatLng(lat, lng);
			thisStation.setPosition(pos);
		}
	})

	
	
JS;
						
						$map->appendScript($script);
						// Display the map -finally :)
						echo $map->display();
					?>
				</div>
			</div>
		</div>
	</div>
</div>