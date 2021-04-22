<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Customer */

$this->title = 'Create Customer';
$this->params['breadcrumbs'][] = ['label' => 'Customers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="customer-create">

    
    <?php
    $hadCreated=false;
    if ($hadCreated==false):?>
    <h2>Ups! Anda melewati batas customer</h2>
    
     <?php 
    else:
    $this->render('_form', [
        'model' => $model,
    ]);
    endif;
    ?>

</div>
