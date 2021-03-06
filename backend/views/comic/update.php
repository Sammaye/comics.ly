<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use common\models\Comic;
use common\models\ComicStrip;
use common\models\Log;

$this->title = Yii::t(
    'app',
    'Update Comic: {title}',
    ['title' => $model->title]
);

?>
<h1 class="form-head"><?= Yii::t('app', 'Update Comic: {title}', ['title' => $model->title]) ?></h1>
<?= $this->render('_form', ['model' => $model]) ?>
<hr/>
<h4>Comic Strips</h4>
<div class="admin-toolbar">
    <?= Html::a(
        Yii::t('app', 'Add Strip'),
        ['comic-strip/create', 'comic_id' => (String)$model->_id],
        ['class' => 'btn btn-primary']
    ) ?>
</div>
<?php

$comicStrip = new ComicStrip(['scenario' => ComicStrip::SCENARIO_SEARCH]);
$comicStrip->comic = $model;

echo GridView::widget([
    'dataProvider' => $comicStrip->search($model->_id),
    'filterModel' => $comicStrip,
    'columns' => [
        '_id',
        'url',
        'image_url',
        'image_md5',
        [
            'attribute' => 'index',
            'format' => 'raw',
            'value' => function ($model, $key, $index, $column) {
                if ($model->comic->type === Comic::TYPE_DATE) {
                    return Yii::$app->getFormatter()->format($model->index, 'date');
                } elseif ($model->comic->type === Comic::TYPE_ID) {
                    return Yii::$app->getFormatter()->format($model->index, 'text');
                }
            }
        ],
        [
            'attribute' => 'updated_at',
            'format' => 'date'
        ],
        [
            'attribute' => 'created_at',
            'format' => 'date'
        ],
        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{update} {delete}',
            'urlCreator' => function ($action, $model, $key, $index) {
                $params = is_array($key) ? $key : ['id' => (string)$key];
                $params[0] = 'comic-strip' . '/' . $action;
                return Url::toRoute($params);
            }
        ]
    ]
]) ?>
<hr/>
<h4>Log</h4>
<?php

$log = new Log(['scenario' => Log::SCENARIO_SEARCH]);

echo GridView::widget([
    'dataProvider' => $log->search($model->_id),
    'filterModel' => $log,
    'columns' => [
        '_id',
        'level',
        'category',
        'prefix',
        [
            'attribute' => 'message',
            'value' => function ($model, $key, $index, $column) {
                return nl2br($model->message);
            },
            'format' => 'html',
        ],
        [
            'attribute' => 'log_time',
            'format' => 'date'
        ],
    ]
]) ?>
