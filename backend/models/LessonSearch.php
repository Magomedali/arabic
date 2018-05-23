<?php

namespace backend\models;

use backend\models\Lesson;
use yii\db\Query;
use yii\data\Pagination;
use yii\data\ActiveDataProvider;

class LessonSearch extends Lesson
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
            [['title','number','level'],'safe']
        ];
    }

    public function scenarios(){
        return Lesson::scenarios();
    }

    /**
     * Реализация логики выборки
     * @return ActiveDataProvider|\yii\data\DataProviderInterface
     */
    public function search($params)
    {   
        
        $query = Lesson::find();
        
        
        
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

        if($this->number)
            $query->andWhere(['number'=>$this->number]);

        if($this->title)
            $query->andFilterWhere(['like', 'title', $this->title]);
        
        if($this->level)
            $query->andWhere(['level'=>$this->level]);

        return $dataProvider;
    }

    
}