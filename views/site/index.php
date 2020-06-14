<?php

use yii\grid\GridView;

/* @var $this yii\web\View */

$this->title = 'Grid with entries';
?>
    <h1>Entries</h1>
    <?= GridView::widget([
        'dataProvider' => $provider,
        'columns' => [
            'id',
            'internal_id',
            'last_modify:datetime',
            'regulator',
        ],
    ]) ?>
