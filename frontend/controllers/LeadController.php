<?php

namespace frontend\controllers;

use yii;
use frontend\models\Leads;
use frontend\models\Addresses;
use frontend\models\Persons;
use frontend\models\LeadSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\rest\ActiveController;
use yii\filters\auth\HttpBasicAuth;
use frontend\controllers\BaseController;

/**
 * LeadController implements the CRUD actions for Leads model.
 */
class LeadController extends BaseController
{
    public $modelClass = 'frontend\models\LeadSearch';
    // public function behaviors()
    // {
    //     return array_merge(
    //         parent::behaviors(),
    //         [
    //             'verbs' => [
    //                 'class' => VerbFilter::className(),
    //                 'actions' => [
    //                     'delete' => ['POST'],
    //                 ],
    //             ],
    //         ]
    //     );
    // }

    /**
     * Lists all Leads models.
     *
     * @return string
     */


    public function actionConvert() {
        try {
            $opportunity = new Opportunity();
            $opportunity->load(Yii::$app->getRequest()->getBodyParams(),'');
            $opportunity->save();
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

    /**
     * Displays a single Leads model.
     * @param int $lead_id Lead ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($lead_id)
    {
        $lead = LeadSearch::findOne($id);
            return $lead;
    }

    /**
     * Creates a new Leads model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        
        $addresses = new Addresses();
        $addresses->load(Yii::$app->getRequest()->getBodyParams(),'');
        $addresses->save();
        // echo "Working";

        $persons = new Persons();
        $persons->load(Yii::$app->getRequest()->getBodyParams(),'');
        $persons->address_id = $addresses->address_id;
        $persons->save();
        // echo "Working";

        $leads = new Leads();
        $leads->person_id = $persons->person_id;
        $leads->save();
        // echo "Working";

        return $leads;
    }

    /**
     * Updates an existing Leads model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $lead_id Lead ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($lead_id)
    {
        $lead = Lead::findOne($id);
            $persons = Persons::findOne($lead->person_id);
            $addresses = Addresses::findOne($persons->address_id);

            if($persons->load(Yii::$app->getRequest()->getBodyParams(),'')) 
            {
                if($addresses->load(Yii::$app->getRequest()->getBodyParams(),'')) 
                {
                    $persons->save();
                    $addresses->save();
                    return "Edited sucessfully";
                }
            }
            return "Edition failed.. try again";
    }

    /**
     * Deletes an existing Leads model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $lead_id Lead ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($lead_id)
    {
        $lead = Lead::findOne($id);
            $lead->is_deleted = 1;
            $lead->save();
            return "Deleted successfully";
    }

    /**
     * Finds the Leads model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $lead_id Lead ID
     * @return Leads the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    // protected function findModel($lead_id)
    // {
    //     if (($model = Leads::findOne(['lead_id' => $lead_id])) !== null) {
    //         return $model;
    //     }

    //     throw new NotFoundHttpException('The requested page does not exist.');
    // }
}
