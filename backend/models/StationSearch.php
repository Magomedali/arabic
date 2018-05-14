<?php

namespace backend\models;

use backend\models\Station;
use yii\db\Query;
use yii\data\Pagination;
use yii\data\ActiveDataProvider;

class StationSearch extends Station
{
    /**
     * Принимаемые моделью входящие данные
     */

   

    public $page_size = 50;

    /**
     * Правила валидации модели
     * @return array
     */
    public function rules()
    {
        return [
            // Только числа, значение как минимум должна равняться единице
            //[[],'safe']
        ];
    }

    public function scenarios(){
        return Station::scenarios();
    }

    /**
     * Реализация логики выборки
     * @return ActiveDataProvider|\yii\data\DataProviderInterface
     */
    public function search($params)
    {   
        $query = Station::find();
        $query->orderBy(['id' => SORT_DESC]);
        /**
         * Создаём DataProvider, указываем ему запрос, настраиваем пагинацию
         */
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => new Pagination([
                    'pageSize' => $this->page_size
                ])
        ]);

        if(!($this->load($params) && $this->validate())){
            return $dataProvider;
        }
        
        
        return $dataProvider;
    }

    
}