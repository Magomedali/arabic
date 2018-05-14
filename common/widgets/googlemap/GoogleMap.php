<?php

namespace common\widgets\googlemap;

use yii\bootstrap\Widget;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\JsExpression;

use dosamigos\google\maps\LatLng;
use dosamigos\google\maps\overlays\InfoWindow;
use dosamigos\google\maps\overlays\Marker;
use dosamigos\google\maps\Map;
use dosamigos\google\maps\layers\BicyclingLayer;
use dosamigos\google\maps\Event;

class GoogleMap extends Widget
{
    /**
     * @var array the alert types configuration for the flash messages.
     * This array is setup as $key => $value, where:
     * - $key is the name of the session flash variable
     * - $value is the bootstrap alert type (i.e. danger, success, info, warning)
     */
    public $mapOptions = [];
    public $stations = [];

    /**
     * @inheritdoc
     */
    public function init()
    {   

        

        parent::init();
        $this->registerAssets();

        $lat = $this->mapOptions['center']['lat'];
        $lng = $this->mapOptions['center']['lng'];

        $this->mapOptions['center'] =  new LatLng(['lat' => $lat, 'lng' => $lng]);

    }

    public function run(){

        $map = new Map($this->mapOptions);

        
        if(isset($this->stations) && is_array($this->stations)){
            foreach ($this->stations as $key => $s) {

                $c = new LatLng(['lat' => $s['latitude'], 'lng' => $s['longitude']]);
                $marker = new Marker([
                    'name'=>'s'.$s['code'],
                    'title'=>'Station #'.$s['code'],
                    'position'=>$c
                ]);

                $marker->attachInfoWindow(new InfoWindow([
                    'content'=>"Station #".$s['code']." <br> Свободных мест: ".$s['free'],
                ]));
                $map->addOverlay($marker);
            }
        }
        
        $html = $this->view->render($this->viewPath."/map.php",['map'=>$map]);
        return $html;
    }

    public function getViewPath(){
        return "@common/widgets/googlemap/views";
    }

    /**
     * Registers the needed assets
     */
    public function registerAssets()
    {
        $view = $this->getView();
        GoogleMapAsset::register($view);

        $js = <<<SCRIPT
SCRIPT;
        $view->registerJs($js);
    }
}
