<?php

namespace api\modules;


use yii\db\Query;
use yii\data\Pagination;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use api\models\Request;

class RequestSearch extends Request{
	 /**
     * Принимаемые моделью входящие данные
     */

    public $date_from;
    public $date_to;
    public $page_size = 100;

    /**
     * Правила валидации модели
     * @return array
     */
    public function rules()
    {
        return [
            // Только числа, значение как минимум должна равняться единице
            [['date_init','date_from','date_to','request_type','result','completed'],'safe'],

        ];
    }

    public function scenarios(){
        return Request::scenarios();
    }

    /**
     * Реализация логики выборки
     * @return ActiveDataProvider|\yii\data\DataProviderInterface
     */
    public function search($params)
    {   
        $query = Request::find();
        //$query->orderBy(['id' => SORT_DESC]);
        /**
         * Создаём DataProvider, указываем ему запрос, настраиваем пагинацию
         */
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['id'=>SORT_DESC]],
            'pagination' => new Pagination([
                    'pageSize' => $this->page_size
                ])
        ]);
        
        if(!($this->load($params) && $this->validate())){

            // $this->date_from = date("d-m-Y H:i",strtotime(date("Y-m-d")));
            // $this->date_to = date("d-m-Y H:i",strtotime(date("Y-m-d"))+86340);
            // $query->andFilterWhere(['>=','date_init', date("Y-m-d\TH:i:s",strtotime($this->date_from))]);
            // $query->andFilterWhere(['<=','date_init', date("Y-m-d\TH:i:s",strtotime($this->date_to))]);
            return $dataProvider;
        }

        if($this->date_from)
            $query->andFilterWhere(['>=',self::tableName().'.date_init', date("Y-m-d\TH:i:s",strtotime($this->date_from))]);

        if($this->date_to)
            $query->andFilterWhere(['<=',self::tableName().'.date_init', date("Y-m-d\TH:i:s",strtotime($this->date_to))]);

        if($this->request_type != null)
            $query->andFilterWhere(['like', self::tableName().'.request_type', "{$this->request_type}%",false]);

        if($this->result != '')
            $query->andFilterWhere(['result'=>$this->result]);

        if($this->completed != '')
            $query->andFilterWhere(['completed'=>$this->completed]);

        

        return $dataProvider;
    }
}
?>