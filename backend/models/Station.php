<?php 
namespace backend\models;

use Yii;
use yii\base\NotSupportedException;

use common\models\Station as cStation;
use backend\models\{Properties,PropertiesValue};

class Station extends cStation
{

	/**
     * @inheritdoc
     */
    public function rules()
    {
        return [
        	[['code','latitude','longitude','ip','address'],'required'],
        	
        	[['code'],'integer'],
        	
        	[['latitude','longitude'],'double'],
        	
        	['ip','ip'],

            [['isDeleted'],'default', 'value' => 0],

        	['code','unique','targetClass' => '\backend\models\Station', 'message' => 'Станция под таким кодом уже заведена в системе!'],
        	['ip','unique','targetClass' => '\backend\models\Station', 'message' => 'Станция под таким ip уже заведена в системе!']
        ];
    }



    public function scenarios(){
    	return array_merge(parent::scenarios(),[

    	]);
    }


    public function addStands($stands){
        if(is_array($stands) && count($stands)){
            $StandsModels = [];

            foreach ($stands as $key => $stand) {
                
                $mStand = null;

                if(!isset($stand['number'])) continue;

                if(isset($stand['id']) && $stand['id']){
                   $mStand = Stand::findOne(['id'=>(int)$stand['id'],'station_id'=>$this->id]); 
                }
                
                if(!isset($mStand) || !isset($mStand->id) || !$mStand->id){
                    $mStand = new Stand;
                }

                $mStand->number = $stand['number'];
                $mStand->station_id = $this->id;
                
                if($mStand->validate()){
                    $mStand->save(1);
                }

                array_push($StandsModels, $mStand);
            }

            return $StandsModels;
        }

        return false;
    }


    public function getStands(){
        return $this->hasMany(Stand::className(),['station_id'=>'id']);
    }


    public function addProperties($properties){

        if(!is_array($properties) || !count($properties)) return false;

        $ModelsProperties = [];
        foreach ($properties as $key => $prop) {
            if(!isset($prop['property_id'])) continue;

            $model = null;

            $model = PropertiesValue::findOne(['station_id'=>$this->id,'property_id'=>(int)$prop['property_id']]);
            

            if(!isset($model) || !isset($model->id)){
                $model = new PropertiesValue;
                $model->station_id = $this->id;
                $model->property_id = (int)$prop['property_id'];
            }

            //Предустмотреть валидацию
            $model->value = trim(strip_tags($prop['value']));

            if($model->validate()){
                $model->save(1);
            }

            array_push($ModelsProperties,$model);
        }

        return $ModelsProperties;
    }



    public function getProperties(){

        return Properties::getStationProperties();
    }

    public function getPropertiesValue(){
        $values = PropertiesValue::getStationValues($this->id);

        $values = is_array($values) ? \yii\helpers\ArrayHelper::map($values,'property_id','attributes') : [] ;
        
        return $values;
    }
}
?>