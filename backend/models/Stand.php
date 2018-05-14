<?php 
namespace backend\models;

use Yii;
use yii\base\NotSupportedException;

use common\models\Stand as cStand;


class Stand extends cStand
{

	/**
     * @inheritdoc
     */
    public function rules()
    {
        return [
        	[['number','station_id'],'required'],
        	
        	[['number','station_id'],'integer'],
        	
            [['isDeleted'],'default', 'value' => 0],
        ];
    }

}

?>