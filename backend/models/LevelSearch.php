<?php

namespace backend\models;

use yii\db\Query;
use yii\data\Pagination;
use yii\data\ActiveDataProvider;

use backend\models\Level;

class LevelSearch extends Level
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
            [['title','desc','position'],'safe']
        ];
    }

    public function scenarios(){
        return Level::scenarios();
    }

    /**
     * Реализация логики выборки
     * @return ActiveDataProvider|\yii\data\DataProviderInterface
     */
    public function search($params)
    {   
        
        $query = Level::find();
        
        
        
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
            
            $query->orderBy(['position' => SORT_DESC]);

            return $dataProvider;
        }

        

        if($this->title)
            $query->andFilterWhere(['like', 'title', $this->title]);
        
        if($this->desc)
            $query->andFilterWhere(['like', 'desc', $this->desc]);

        if($this->position)
            $query->andWhere(['position'=>$this->position]);

        return $dataProvider;
    }

    
}