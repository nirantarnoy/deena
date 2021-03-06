<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\PromotionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'โปรโมชั่น';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="promotion-index">
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
     <div class="row">
      <div class="col-lg-12">
        <div class="panel panel-default">
          <div class="panel-heading">
           <div>
        <?= Html::a('<i class="fa fa-plus-circle"></i> สร้างโปรโมชั่น', ['create'], ['class' => 'btn btn-success']) ?>
         <div class="btn-group pull-right" style="bottom: 10px">
        <?php  echo $this->render('_search', ['model' => $searchModel]); ?>
      </div>
      </div>
      </div>
      <div class="panel-body">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'code',
            'name',
            'description',
            [
              'attribute' => 'amount',
              'value'=> function($data){
                return number_format($data->amount);
              }
            ],
            //'amount',
            //'promotion_type',
            // 'start_date',
            // 'end_date',
            // 'photo',
            [
              'attribute' => 'promotion_type',
              'value'=> function($data){
                return \backend\models\Promotiontype::getTypeName($data->promotion_type);
              }
            ],
              [
              'attribute' => 'start_date',
              'value'=> function($data){
                return date("d-m-Y",$data->start_date);
              }
            ],
              [
              'attribute' => 'end_date',
              'value'=> function($data){
                return date("d-m-Y",$data->end_date);
              }
            ],
            [
               'attribute'=>'status',
               'format' => 'html',
               'value'=>function($data){
                 return $data->status === 1 ? '<div class="label label-success">Active</div>':'<div class="label label-default">Inactive</div>';
               }
             ],
            //'created_at',
            // 'updated_at',
            // 'created_by',
            // 'updated_by',

            [
                        'label' => 'Action',
                        'format' => 'raw',
                        'value' => function($model){
                                return '
                                    <div class="btn-group" >
                                        <button data-toggle="dropdown" class="btn btn-default dropdown-toggle"><i class="fa fa-ellipsis-v"></i></button>
                                        <ul class="dropdown-menu" style="right: 0; left: auto;">
                                        <li><a href="'.Url::toRoute(['/promotion/view', 'id'=>$model->id]).'">'.'View'.'</a></li>
                                        <li><a href="'.Url::toRoute(['/promotion/update', 'id'=>$model->id]).'">'.'Update'.'</a></li>
                                        <li><a onclick="return confirm(\'Confirm ?\')" href="'.Url::to(['/promotion/delete', 'id'=>$model->id],true).'">Delete</a></li>
                                        </ul>
                                    </div>
                                ';
                            // }
                        },
                        'headerOptions'=>['class'=>'text-center'],
                        'contentOptions' => ['class'=>'text-center','style'=>'vertical-align: middle','text-align: center'],

                    ],
        ],
    ]); ?>
     </div>
  </div>
  </div>
  </div>
    <?php Pjax::end(); ?>
</div>
