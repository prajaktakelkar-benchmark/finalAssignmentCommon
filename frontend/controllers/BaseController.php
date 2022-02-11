<?php

namespace frontend\controllers;

    use Yii;
    use yii\rest\ActiveController;
    use yii\web\Response;
    use yii\helpers\ArrayHelper;
    use yii\filters\auth\HttpBasicAuth;

class BaseController extends ActiveController
{

    protected function verbs()
    {
        return [
            'index' => ['GET', 'HEAD'],
            'view' => ['GET', 'HEAD'],
            'create' => ['POST','OPTIONS'],
            'update' => ['PUT', 'PATCH','OPTIONS'],
            'delete' => ['DELETE'],
        ];
    }
    public function actionOptions()
    {
        Yii::$app->getResponse()->getHeaders()->set('Allow', implode(', ', ['OPTIONS', 'POST', 'GET']));
        
    }
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        // remove authentication filter
        $auth = $behaviors['authenticator'];
        unset($behaviors['authenticator']);
        
        // add CORS filter
        $behaviors['corsFilter'] = [
            'class' => \yii\filters\Cors::class,
           'cors' => [
                                    // restrict access to
                                    'Origin' => ['*'],
                                    'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'OPTIONS', 'DELETE'],
                                    'Access-Control-Request-Headers' => ['*'],
                                    'Cache-Control' => 'no-cache, no-store, must-revalidate ,max-age=60'
                                //  'Access-Control-Allow-Credentials' => true,
                                ],

        ];
        return $behaviors;
    }
   

        public function actions()
        {
            $actions = parent::actions();
            unset($actions['view']);
            unset($actions['index']);
            unset($actions['create']);   
            unset($actions['update']);
            // unset($actions['delete']);
            return $actions;
        }
        
    }
?>