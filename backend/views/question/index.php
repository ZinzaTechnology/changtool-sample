<?php 
use yii\helpers\Html;
use yii\helpers\Url;
?>

<p><?= Html::a('Create New Question', ['/question/create'], ['class' => 'btn btn-success']);?></p>
<div class="hr-line-solid"></div>

<?= $this->render('/question/_search', ['level' => $level, 'category' => $category, 'type' => $type]); ?>

<table border="1">
    <caption>QUESTION</caption>
    <thead bgcolor="#0892d0">
        <tr>
            <th>Content</th>
            <th>Category</th>
            <th>Level</th>
            <th>Type</th>
            <th>Created date</th>
            <th>Updated date</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
    </thead>

    <tbody bgcolor="#7df9ff	">    
    <?php
    foreach ($question as $value) {
        if ($value['q_level']==1)
            $string_level='Trung Binh';
        else $string_level='Kho';
        if ($value['q_type']==1)
            $string_type='1 cau tra loi dung';
        else $string_type='nhieu cau tra loi dung';
        echo '
                    <tr>
                        <td>'.Html::a($value['q_content'], ['/question/view','q_id'=>$value->q_id]).'</td>
                        <td>'.$category[$value['q_category']].'</td>
                        <td>'.$string_level.'</td>
                        <td>'.$string_type.'</td>
                        <td>'.$value['created_at'].'</td>
                        <td>'.$value['updated_at'].'</td>
                        <td>'.Html::a('Edit', ['/question/edit','q_id'=>$value->q_id], ['class'=>'btn btn-warning']).'</td>
                        <td>'.Html::a('Delete', ['/question/delete','q_id'=>$value->q_id], ['class'=>'btn btn-danger','data' => [
                            'confirm' => 'Are you sure you want to delete this item?',
                            'method' => 'post', 
                            ],]).'</td>
                    </tr>';
    }

    ?>
    </tbody>
</table>


<p>
<?php echo Html::a('Back', ['/question/index'],['class'=>'btn btn-success']);?>
</p>


