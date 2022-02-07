<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\LeadSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Leads';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="leads-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Leads', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'lead_id',
            'notes',
            'updated_at',
            'person_id',
            'is_deleted',
            'created_at',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Leads $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'lead_id' => $model->lead_id]);
                 }
            ],
        ],
    ]); ?>


</div>
