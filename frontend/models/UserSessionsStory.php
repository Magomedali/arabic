<?php

namespace frontend\models;

use common\models\Session;
use yii\db\Query;
use yii\data\Pagination;
use yii\data\ActiveDataProvider;



class UserSessionsStory extends Session
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
            //[['title','name'],'safe']
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
        
        $user = \Yii::$app->user->identity;

        $query->where(['client_id'=>$user->id]);
        
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
            $query->orderBy(['id' => SORT_DESC]);

            return $dataProvider;
        }


        //if($this->name)
        //    $query->andFilterWhere(['like', 'name', $this->name]);

        //if($this->title)
        //    $query->andFilterWhere(['like', 'title', $this->title]);
        

        return $dataProvider;
    }

    
}