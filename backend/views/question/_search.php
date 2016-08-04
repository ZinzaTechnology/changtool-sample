<?php 
use yii\helpers\Html;
use yii\helpers\Url;
?>

<?= Html::beginForm(Url::toRoute('question/index'), 'post'); ?>
    Search body: <?= Html::input('text', 'content', Yii::$app->request->post('q_content')) ?>
    </br>
    Category: <?= Html::dropDownList('category', [], $category, ['prompt' => '---Select---']) ?>
    Type: <?= Html::dropDownList('type', [], $type, ['prompt' => '---Select---']) ?>
    Level: <?= Html::dropDownList('level', [], $level, ['prompt' => '---Select---']) ?>
    Tag: <?= Html::input('text', 'qt_content',Yii::$app->request->post('qt_content')) ?>
    </br>
    <?= Html::submitButton('Search', ['class' => 'btn btn-lg btn-primary', 'name' => 'search']) ?>
<?= Html::endForm() ?>

