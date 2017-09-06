<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Car */

$this->title = 'แก้ไขรหัสรถ : '.$model->name;
$this->params['breadcrumbs'][] = ['label' => 'รหัสรถ', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="car-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
