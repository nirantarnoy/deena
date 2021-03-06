<?php
namespace backend\models;
use yii\db\ActiveRecord;

date_default_timezone_set('Asia/Bangkok');
class Carinfo extends \common\models\CarInfo
{
  public function behaviors()
{
    return [
        'timestampcdate'=>[
            'class'=> \yii\behaviors\AttributeBehavior::className(),
            'attributes'=>[
            ActiveRecord::EVENT_BEFORE_INSERT=>'created_at',
            ],
            'value'=> time(),
        ],
        'timestampudate'=>[
            'class'=> \yii\behaviors\AttributeBehavior::className(),
            'attributes'=>[
            ActiveRecord::EVENT_BEFORE_INSERT=>'updated_at',
            ],
          'value'=> time(),
        ],
        'timestampupdate'=>[
            'class'=> \yii\behaviors\AttributeBehavior::className(),
            'attributes'=>[
            ActiveRecord::EVENT_BEFORE_UPDATE=>'updated_at',
            ],
            'value'=> time(),
        ],
    ];
 }
  public function findBrand($id){
    $model = \backend\models\Carbrand::find()->where(['id'=>$id])->one();
    return count($model)>0?$model->name :'';
    }
     public function findCarmodel($id){
    $model = Carinfo::find()->where(['id'=>$id])->one();
    return count($model)>0?$model->model :'';
    }
     public function findCaryear($id){
    $model = \backend\models\Caryear::find()->where(['id'=>$id])->one();
    return count($model)>0?$model->year_text :'';
    }
     public static function getCaryear($id){
    $model = \backend\models\Caryear::find()->where(['id'=>$id])->one();
    return count($model)>0?$model->year_text :'';
    }
}
