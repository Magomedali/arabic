<?php

namespace backend\models;

use backend\models\Session;
use yii\db\Query;
use yii\data\Pagination;
use yii\data\ActiveDataProvider;

class SessionSearch extends Session
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
        return Session::scenarios();
    }

    /**
     * Реализация логики выборки
     * @return ActiveDataProvider|\yii\data\DataProviderInterface
     */
    public function search($params)
    {   
        $query = Session::find();
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