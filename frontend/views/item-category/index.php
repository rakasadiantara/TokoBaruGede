<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ItemCategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Item Categories';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="item-category-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Item Category', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'parent_category',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
