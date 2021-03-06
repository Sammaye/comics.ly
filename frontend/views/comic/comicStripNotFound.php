<?php

use yii\helpers\Url;
use yii\helpers\Html;
use common\models\Comic;

use MongoDB\BSON\UTCDateTime;

Yii::$app->response->setStatusCode(404);

$this->params['comic_id'] = (String)$model->_id;

$this->title = Yii::t('app', '#404 ZOMG strip Not Found!');

?>
<div class="comic-view-strip-not-found">
    <div class="comic-date-picker">
        <form method="get" action="<?= Url::to(['comic/view', 'id' => (String)$model->_id]) ?>">
            <div>
                <?php if ($model->current_index) { ?>
                    <a href="<?= $model->indexUrl($model->current_index) ?>" class="btn btn-lg btn-default btn-previous-comic">&laquo;</a>
                <?php } else { ?>
                    <a href="#" disabled="disabled" class="btn btn-lg btn-default">&laquo;</a>
                <?php } ?>
                <input
                    type="text"
                    class="form-control input-lg"
                    name="index"
                    id="datepicker"
                    value="<?php
                    if ($value = Yii::$app->request->get('index')) {
                        $value = $model->index($value);
                        if ($value instanceof UTCDateTime) {
                            echo date('d-m-Y', $value->toDateTime()->getTimestamp());
                        } else {
                            echo $value;
                        }
                    } else {
                        echo '####';
                    }
                    ?>"
                />
                <a href="#" disabled="disabled" class="btn btn-lg btn-default">&raquo;</a>
            </div>
        </form>
    </div>

    <div class="alert alert-danger">
        <?= Yii::t('app', "Sammaye's Comics has no record of this strip!") ?>
    </div>
    <p><?= Yii::t(
        'app',
        'If you believe this is an error and this strip should be here {link}.',
        [
            'link' => Html::a(
                Yii::t('app', 'then please contact me through the help section'),
                ['site/help', '#' => 'need-help-support']
            )
        ]
    ) ?></p>
    <p><?= Yii::t(
        'app',
        'On the other hand if you wish to go back to one that does exist: {link}',
        [
            'link' => Html::a(
                Yii::t('app', 'simply click here'),
                ['comic/view', 'id' => (String)$model->_id]
            )
        ]
    ) ?></p>
</div>
