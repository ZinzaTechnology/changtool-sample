<?php 
use yii\helpers\Html;
?>

<p>
<?php echo Html::a('Create Question', ['/question/create'],['class'=>'btn btn-success']);?>
</p>

	<?php  echo $this->render('//question/_search',['question' => $question,'answer' => $answer,'category'=>$category]); ?>
			
			<table border="1">
			<caption>TABLE QUESTION</caption>
			<thead bgcolor="#0892d0">
			<tr>
			<th>Content</th>
			<th>Category</th>
			<th>level</th>
            <th>type</th>
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
				<td>'.$value['q_created_date'].'</td>
				<td>'.$value['q_updated_date'].'</td>
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
					
<?php /*GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'q_content',
            'q_type',
        	'q_level',
        	'q_date',
            ['class' => 'yii\grid\ActionColumn',
                'template' => '{view} {edit} {delete}',
                'buttons' => [
                    'view' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url);
                    },
                    
                    
                    'edit' => function ($url, $model) {
                    return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url);
                    },
                    
                    'delete' => function ($url, $model) {
                    return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url);
                    },
                    
                ],
                
                'urlCreator' => function ($action, $dataProvider, $key, $index) {
                
                if ($action === 'view') {
                	return Url::to(['Controller/view', 'id' =>$dataProvider['q_id']]);
                }
                if ($action === 'edit') {
                	return Url::to(['/Controller/update', 'id' =>$dataProvider['q_id']]);
                }
                if ($action === 'delete') {
                	return Url::to(['/Controller/delete', 'id' =>$dataProvider['q_id']]);
                }
                return $url;
                }
                
                
				],
        ],
    ]); */ ?>	
    
    