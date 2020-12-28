<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ConsultationLab */

$this->title = 'Update Consultation Lab: ' . $model->auto_number;
$this->params['breadcrumbs'][] = ['label' => 'Consultation Labs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->auto_number, 'url' => ['view', 'id' => $model->auto_number]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="consultation-lab-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
