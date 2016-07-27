<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\TestExamQuestionsSearch */
/* @var $form yii\widgets\ActiveForm */
$category = ['1' => 'PHP', '2' => 'C/C++', '3' => 'Java', '4' => 'SQL', '5' => 'C#'];
$level = ['1' => 'Easy', '2' => 'Normal', '3' => 'Hard'];
?>

<div class="user-test-search">
    <form method="get">
        Username <input type="text" name="u_name" value="<?= isset($_GET['u_name']) ? $_GET['u_name'] : '' ?>" />
        Category <select name="te_category">
            <option value="0">--- Select Category ---</option>
            <?php for ($i = 1; $i <= count($category); $i++) { ?>
                <option value="<?= $i ?>" <?= (isset($_GET['te_category']) && $_GET['te_category'] == $i) ? 'selected' : '' ?>><?= $category[$i] ?></option>
            <?php } ?>
        </select>
        Title <input type="text" name="te_title" value="<?= isset($_GET['te_title']) ? $_GET['te_title'] : '' ?>" />
        Level <select name="te_level">
            <option value="0">--- Select Level ---</option>
            <?php for ($i = 1; $i <= count($level); $i++) { ?>
                <option value="<?= $i ?>" <?= (isset($_GET['te_level']) && $_GET['te_level'] == $i) ? 'selected' : '' ?>><?= $level[$i] ?></option>
            <?php } ?>
        </select>
        Start date<input type="date" name="ut_start_at" value="<?= isset($_GET['ut_start_at']) ? $_GET['ut_start_at'] : '' ?>"/>
        End date<input type="date" name="ut_finished_at" value="<?= isset($_GET['ut_finished_at']) ? $_GET['ut_finished_at'] : '' ?>"/>
        <input type="submit" value="Search" name="a" />
        <input type="submit" value="Back" name="a" />
    </form>
</div>
