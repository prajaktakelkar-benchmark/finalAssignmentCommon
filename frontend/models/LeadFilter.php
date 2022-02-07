<?php

namespace frontend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\Leads;
use frontend\models\Persons;

class LeadFilter extends Leads
{
    /**
     * {@inheritdoc}
     */
    public $person_fname;
    public $person_email;
    public $person_phone;
    public $city;
    public $person_id;
    public $created_at;
    
    public function rules()
    {
        return [
            [['lead_id'], 'integer'],
            [['person_fname'], 'string'],
            [['person_id','created_at','person_fname','person_email','person_phone','city'], 'safe'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'lead_id' => 'Lead ID',
            'notes' => 'Notes',
            'updated_at' => 'Updated At',
            'person_id' => 'Person ID',
            'created_at' => 'Created At',
            'is_deleted' => 'Status',
        ];
    }


  
}