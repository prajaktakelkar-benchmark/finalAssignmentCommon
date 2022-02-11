<?php

namespace frontend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Leads;
use common\models\Persons;
use common\models\Addresses;
use yii\data\ActiveDataFilter;

/**
 * LeadSearch represents the model behind the search form of `app\models\Leads`.
 */
class LeadSearch extends Leads
{
    /**
     * {@inheritdoc}
     */

    public function fields() {
        return [
            'lead_id',
            'persons' => function ($model) {
                return $model->persons;
            },
            // 'addresses' => function ($model) {
            //     return $model->persons->addresses;
            // }
        ];
    }

    public function rules()
    {
        return [
            [['lead_id'], 'integer'],
            [['lead_id','person_id', 'created_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $filter = new ActiveDataFilter([
            'searchModel' => 'frontend\models\LeadFilter',
            'attributeMap' => [
                'person_id' => 'persons.person_id',
            ],
        ]);
        
        $filterCondition = null;
        
        // You may load filters from any source. For example,
        // if you prefer JSON in request body,
        // use Yii::$app->request->getBodyParams() below:
        if ($filter->load(\Yii::$app->request->get())) { 
            $filterCondition = $filter->build();
            if ($filterCondition === false) {
                // Serializer would get errors out of it
                return $filter;
            }
        }
        $query = self::find();
        $query->joinWith(['persons', 'persons.addresses']);
        

        $query->where('is_deleted = 0');
       
        if ($filterCondition !== null) {
            $query->andWhere($filterCondition);
        }
 
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        $dataProvider->setSort([
            'attributes' => [
                'lead_id',
                'created_at',
                'person_id',
                'person_fname' => [
                    'asc' => ['person_fname' => SORT_ASC],
                    'desc' => ['person_fname' => SORT_DESC],
                    'label' => 'Person Name',
                    'default' => SORT_ASC
                ],
                'person_email' => [
                    'asc' => ['person_email' => SORT_ASC],
                    'desc' => ['person_email' => SORT_DESC],
                    'label' => 'Person Email',
                    'default' => SORT_ASC
                ],
                'city' => [
                    'asc' => ['addresses.city' => SORT_ASC],
                    'desc' => ['addresses.city' => SORT_DESC],
                    'label' => 'City Name',
                    'default' => SORT_ASC
                ],
                'person_phone' => [
                    'asc' => ['person_phone' => SORT_ASC],
                    'desc' => ['person_phone' => SORT_DESC],
                    'label' => 'Person Contact',
                    'default' => SORT_ASC
                ],
            ],
        ]);

        // print_r($dataProvider->$query->createCommand()->rawSql;
        // print_r($dataProvider->query->createCommand()->rawSql);
        // die;
        
        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'lead_id' => $this->lead_id,
            'person_id' => $this->person_id,
            'created_at' => $this->created_at,
        ]);

        return $dataProvider;
    }

    public function getPersons() {
        return $this->hasOne(Persons::className(), ['person_id' => 'person_id']);
    }

}