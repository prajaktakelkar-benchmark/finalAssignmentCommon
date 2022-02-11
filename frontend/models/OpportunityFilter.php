<?php

namespace frontend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\Opportunity;

class OpportunityFilter extends Opportunity
{
    /**
     * {@inheritdoc}
     */
    public $op_id;
    public $lead_id;
    public $person_id;
    //public $plan_id;
    public $firstname;
    public $lastname;
    public $email_id;
    public $contact_no;
    // public $plan_name;
    public $city;
    
    public function rules()
    {
        return [
            [['op_id','lead_id','person_id'], 'integer'],
            [['lead_id','person_id', 'firstname', 'lastname', 'email_id', 'contact_no','city'], 'safe'],
        ];
    }
  
}
