<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>

<?= Html::beginForm(Url::toRoute('/test-exam/test-index'), 'post'); ?>
    <table class="table table-bordered">
        <tr><th>Search body</th><td colspan="5"><?= Html::input('text', 'content', Yii::$app->request->post('q_content')) ?></td></tr>
        <tr>
            <th>Category</th><td><?= $category ?>
            <th>Type</th><td><?= Html::dropDownList('type', [isset($search_param['type'])? $search_param['type'] : null ], $type, ['prompt' => '---Select---']) ?></td>
            <th>Level</th><td><?= Html::dropDownList('level', [isset($search_param['level'])? $search_param['level'] : null ], $level, ['prompt' => '---Select---']) ?></td>
        </tr>
        <tr><th>Tag</th><td colspan="5"><?= Html::input('text', 'qt_content', Yii::$app->request->post('qt_content')) ?></td></tr>
        <tr><td colspan="6"><?= Html::submitButton('Search', ['class' => 'btn btn-success', 'name' => 'search']) ?></td></tr>
    </table>
<?= Html::endForm() ?>

