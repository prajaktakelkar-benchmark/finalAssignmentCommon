<?php
    namespace frontend\controllers;
    use Yii;
    use yii\rest\ActiveController;
    use frontend\models\Leads;
    use frontend\models\LeadSearch;
    use frontend\models\Persons;
    use frontend\models\Addresses;
    use frontend\models\Opportunity;
    use yii\filters\auth\HttpBasicAuth;
    use frontend\controllers\BaseController;

    class LeadController extends BaseController
    {
        public $modelClass = 'frontend\models\LeadSearch';

        public function actionConvert($id) {
            // echo "woorking.";
            try {
                
                $lead = Leads::findOne($id);
                $opportunity = new Opportunity();
                $opportunity->lead_id = $lead ->lead_id;
                $opportunity->person_id = $lead ->person_id;
                $opportunity->load(Yii::$app->getRequest()->getBodyParams(),'');
                $opportunity->save();
                return $opportunity;
            }
            
            catch (\yii\db\Exception $e) {
                return "Duplicate entry not allowed";
            }
        }

        public function actionIndex()
        {
            $searchModel = new LeadSearch();
            $dataProvider = $searchModel->search($this->request->queryParams);
            return $dataProvider;
        }

        public function actionView($id)
        {
            $lead = LeadSearch::findOne($id);
            return $lead;
        }

        // public function actionCreate()
        // {
        //     $address = new Addresses();
        //     $address->load(Yii::$app->getRequest()->getBodyParams(),'');
        //     if($address->validate(()){
        //         $address->attributes
        //     }
        //     //if else condition for validation
        //     $address->save();
        //     return $address;

        //     $person = new Persons();
        //     $person->load(Yii::$app->getRequest()->getBodyParams(),'');
        //     $person->address_id = $address->address_id;
        //     $person->save();
        //     return $person;

        //     $leads = new Leads();
        //     $leads->person_id = $person->person_id;
        //     $leads->load(Yii::$app->getRequest()->getBodyParams(),'');
        //     $leads->save();
        //     return $leads;
        // }

        public function actionCreate(){
            $transactions = Yii::$app->db->beginTransaction();
            try {
                $address = new Addresses();
                $person = new Persons();
                $lead = new Leads();
                
                if ($address->load(Yii::$app->getRequest()->getBodyParams(),'') && $address->validate() ) {
                    if ($address->save()) {
                        $person->address_id = $address->address_id;
                        if ($person->load(Yii::$app->getRequest()->getBodyParams(),'') && $person-> validate()) {
                            if ($person->save()) {
                                $lead->person_id = $person->person_id;
                                if ($lead->load(Yii::$app->getRequest()->getBodyParams(),'') && $lead -> validate() ) {
                                    if ($lead->save()) {
                                        $transactions->commit();
                                        return true;
                                    }
                                } else {
                                    $transactions->rollBack();
                                    return $lead;
                                }
                            }
                        } else {
                            $transactions -> rollBack();
                            return $person;
                        }
                    }
                } else {
                    $transactions -> rollBack();
                    return $address;
                }
                
                
            } catch (\Throwable $th) {
                $transactions -> rollBack();
                throw $th;
            }

        }

        
        public function actionUpdate($id)
        {
            // echo "Calling";
            // die;
                   
            $lead = Leads::findOne($id);
            $person = Persons::findOne($lead->person_id);
            $address = Addresses::findOne($person->address_id);
            // print_r($person);
            // die;
            if($lead->load(Yii::$app->getRequest()->getBodyParams(),''))
            {
                if($person->load(Yii::$app->getRequest()->getBodyParams(),'')) 
                {
                    if($address->load(Yii::$app->getRequest()->getBodyParams(),'')) 
                    {
                        $lead->save();
                        $person->save();
                        $address->save();
                        return "Edited sucessfully";
                    }
                }
            }
            return "Editing failed.. try again";
        }

        public function actionDelete($id)
        {
            $lead = Leads::findOne($id);
            $lead->is_deleted = 1;
            $lead->save();
            return "Deleted successfully";
        }        
        
    }   
?>