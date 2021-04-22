<?php

/* @var $this yii\web\View */

$this->title = 'My Yii Application';
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

?>
<div class="site-index">

    <div class="jumbotron">
        <h1>Toko Baru GEDE</h1>

        <p class="lead">You have successfully created your Yii-powered application.</p>

        <p><a class="btn btn-lg btn-success" href="http://www.yiiframework.com">Get started with Yii</a></p>
    </div>

    <div class="body-content">

        <div class="container">
        <div class="well well-sm">
                <div class="col-xs-10">
                    <?php $form = ActiveForm::begin(['id' => 'login-form','layout' => 'horizontal']); ?>
                    <?= $form->field(new \frontend\models\Item(),'category_id')->dropDownList(['1'=>'Kategori 1','2'=>'Kategori 2'],['prompt'=>'Select Category'])->label('Category') ?>
                </div>
                <div>
                    <?= Html::submitButton('Filter', ['class' => 'btn btn-success', 'name' => 'filter-button']) ?>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
            
            <div class="row">
                <?php foreach ($items as $item): ?>
                <div class="item  col-xs-4 col-lg-4">
                    <div class="thumbnail">
                        <img class="group list-group-image" src="<?=$item->imagePre?>" alt="" style="min-height: 300px; max-height: 300px"/>
                        <div class="caption">
                            <h4 class="group inner list-group-item-heading">
                                <?=$item->name?></h4>
                            <p class="group inner list-group-item-text">
                                <?=$item->category->name?:'No Category'?>
                            </p>
                            <div class="row">
                                <div class="col-xs-12 col-md-6">
                                    <p class="lead">
                                        <?=$item->priceRupiah?></p>
                                </div>
                                <div class="col-xs-12 col-md-6">
                                    <?php
                                        if (Yii::$app->user->isGuest)
                                            echo Html::a('Log in first',['/site/login'],['class'=>'btn btn-warning']);
                                        else
                                            echo Html::a('Add to cart',['/site/checkout'],['class'=>'btn btn-success']);
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach;?>
            </div>
        </div>

    </div>

</div>
