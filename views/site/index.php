<div class="logo-wrapper">
    <?= \yii\helpers\Html::img([ 'img/logo.png' ], [
        'height' => 150,
    ]) ?>
</div>
<br>
<div class="identity-container">
    <b><?= Yii::$app->getUser()->getIdentity()->{'surname'} ?></b>
    <b><?= Yii::$app->getUser()->getIdentity()->{'name'} ?></b>
    <br>
    <i><?= Yii::$app->getUser()->getIdentity()->{'login'} ?></i>
</div>