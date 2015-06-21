<?php
/**
 * @var $this \yii\web\View
 */
?>
<?= \app\widgets\ModelNav::widget() ?>
<br>
<div class="col-xs-12">
    <div class="col-xs-8">
        <?= \yii\grid\GridView::widget([
            'dataProvider' => \app\models\File::search('file_group_id = \'material\''),
            'columns' => [
                [ 'attribute' => 'id', 'label' => '#' ],
                [ 'attribute' => 'name', 'label' => 'Имя' ],
                [ 'attribute' => 'user_login', 'label' => 'Пользователь' ],
                [ 'attribute' => 'upload_time', 'label' => 'Время загрузки' ],
                [ 'attribute' => 'file_group_name', 'label' => 'Группа файла' ],
                [ 'attribute' => 'file_extension', 'label' => 'Расширение' ],
                [
                    'class' => '\yii\grid\ActionColumn',
                    'buttons' => [
                        'load' => function($url) {
                            $js = <<< JS
                            $.get("$url", {}, function(response) {
                                $(".material-container").empty().append(response).prev("h4").remove();
                            });
JS;
                            return \yii\helpers\Html::a('Предпросмотр', "javascript:void(0)", [
                                'class' => 'btn btn-success btn-xs',
                                'onclick' => $js
                            ]);
                        }
                    ],
                    'contentOptions' => [
                        'width' => '200px',
                        'align' => 'middle'
                    ],
                    'template' => '{load}',
                ]
            ]
        ]) ?>
    </div>
    <div class="col-xs-4">
        <br>
        <div class="panel panel-primary">
            <div class="panel-heading">
                Предпросмотр материала
            </div>
            <div class="panel-body">
                <h4 class="text-center">Материал не выбран</h4>
                <pre class="material-container text-left"></pre>
            </div>
        </div>
        <?= \app\widgets\FlashMessenger::widget() ?>
    </div>
</div>