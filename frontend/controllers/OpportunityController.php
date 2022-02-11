<?php

    namespace frontend\controllers;
    use Yii;
    use yii\rest\ActiveController;
    use frontend\models\Opportunity;
    use frontend\models\OpportunitySearch;
    use frontend\models\OpportunityFilter;
    use frontend\models\Addresses;
    use frontend\models\Persons;
    use frontend\controllers\baseController;


    class OpportunityController extends BaseController
    {
     public $modelClass = 'frontend\models\OpportunitySearch';
        
        public function actionIndex()
        {   
            $searchModel = new OpportunitySearch();
            $dataProvider = $searchModel->search($this->request->queryParams);
  
            return $dataProvider;
        }
         public function actionView($id)
        {
            $opportunity = OpportunitySearch::findOne($id);
            return $opportunity;
        }

        public function actionCreate()
        {
            $transactions = Yii::$app->db->beginTransaction();

            try {
                $address = new Addresses();
                $person = new Persons();
                $opportunity = new Opportunity();
                
                if ($address->load(Yii::$app->getRequest()->getBodyParams(),'') && $address->validate() ) {
                    if ($address->save()) {
                        $person->address_id = $address->address_id;
                        if ($person->load(Yii::$app->getRequest()->getBodyParams(),'') && $person-> validate()) {
                            if ($person->save()) {
                                $opportunity->person_id = $person->person_id;
                                if ($opportunity->load(Yii::$app->getRequest()->getBodyParams(),'') && $opportunity -> validate() ) {
                                    if ($opportunity->save()) {
                                        $transactions->commit();
                                        return true;
                                    }
                                } else {
                                    $transactions->rollBack();
                                    return $opportunity;
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
        // public function actionUpdate($id)
        // {     
        //     $opportunity = Opportunity::findOne($id);
        //     // print_r ($opportunity);
        //     // die;
        //     $person = Persons::findOne($opportunity->person_id);
        //     $address = Addresses::findOne($person->address_id);
            
        //     if($opportunity->load(Yii::$app->getRequest()->getBodyParams(),''))
        //     {
        //         if($person->load(Yii::$app->getRequest()->getBodyParams(),'')) 
        //         {
        //             if($address->load(Yii::$app->getRequest()->getBodyParams(),'')) 
        //             {
        //                 $opportunity->save();
        //                 $person->save();
        //                 $address->save();
        //                 return "Edited sucessfully";
        //             }
        //         }
        //     }
        //     return "Editing failed.. try again";
            
        // }


        public function actionUpdate($id)
        {     
            

            $transactions = Yii::$app->db->beginTransaction();

            try {
                $opportunity = Opportunity::findOne($id);
                $person = Persons::findOne($opportunity->person_id);
                $address = Addresses::findOne($person->address_id);
                echo "working";
            
                if($opportunity->load(Yii::$app->getRequest()->getBodyParams(),''))
                {
                    if ($opportunity->save()) {
                        if($person->load(Yii::$app->getRequest()->getBodyParams(),'')) 
                        {
                            if ($person->save()) {
                                if($address->load(Yii::$app->getRequest()->getBodyParams(),'')) 
                                {
                                    if ($address->save()) {
                                        $transactions -> commit();
                                        return "Edited sucessfully";
                                    }
                                    else {
                                        $transactions->rollBack();
                                        return $address;
                                    }
                                    
                                }
                            }else {
                                $transactions -> rollBack();
                                return $person;
                            }
                            
                        }
                    }else {
                        $transactions->rollback();
                        return $opportunity;
                    }
                    
                }
            } catch (\Throwable $th) {
                $transactions->rollBack();
                return $th;
            }
            
        }
    
    }
?>