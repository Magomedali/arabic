<?php

use yii\helpers\{Html,Url};
use yii\web\JqueryAsset;

$this->title = Yii::t('site',"CONTACTS_PAGE");
$this->params['breadcrumbs'][] = $this->title;

$user = \Yii::$app->user->identity;

$google_map_key = "AIzaSyDB4ObYUSmHECFac5UMv7tAxBwVaPCIPcw";
$map_url = "https://maps.googleapis.com/maps/api/js?key=".$google_map_key;

$this->registerJsFile($map_url);

$script = <<<JS
	
	var latlng = new google.maps.LatLng(39.305, -76.617);
		
	var mapOptions = {
		center: latlng,
		zoom: 8,
	};
	var map = new google.maps.Map(document.getElementById('map'),mapOptions);
	
JS;


$this->registerJs($script);
?>
<!-- <script type="text/javascript">
	function initMap(){
		var latlng = new google.maps.LatLng(39.305, -76.617);
		
		var point = {lat: 39.305, lng: -76.617};
		var mapOptions = {
		   center: point,
		   zoom: 8,
		};
		var map = new google.maps.Map(document.getElementById('map'),mapOptions);
	}
</script> -->
<div class="row">
	<div class="col-xs-12">
		<p>
			Lorem ipsum dolor sit amet... Если вы как-то связаны с дизайном, наверняка вы видели эту фразу сотни раз. Известная как «рыба» или «латинская заготовка», она используется для имитации текстового наполнения сайта, лендига, рекламы или продукта, чтобы дизайнерам не приходилось ждать готового контента, а клиенты не отвлекались от графической реализации на чтение непонятного текста:
		</p>
		
		<p>
			«Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.»
		</p>

		<p>
			Этот псевдо-латинский текст невозможно принять за свой родной язык, а уж тем более, по ошибке утвердить его и направить на публикацию или печать. Для его воссоздания вы можете обратиться к одному из онлайн-генераторов или просто скопировать параграф с чужого сайта и повторять его, пока не будет достигнут нужный объём. Однако, несмотря на повсеместное распространение, Lorem Ipsum вызывает немало споров. В чем же секрет его популярности, и откуда вообще пошла эта традиция?
		</p>
	</div>
</div>

<div class="row">
	<div class="col-xs-12">
		<div id="map" style="height: 300px;"></div>
	</div>
</div>