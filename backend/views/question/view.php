<?php 
use yii\helpers\Html;
?>		
	<?php 
			echo 'Content question :'.$question['q_content'].'</br>';
			switch ($question['q_category']) {
				case 1:
					echo 'category : PHP </br>';
					break;
				case 2:
					echo 'category : Java </br>';
					break;
				case 3:
					echo 'category : C </br>';
					break;
				case 3:
					echo 'category : C#/C++ </br>';
					break;
			}
			if($question['q_type']==1)
			{
			echo 'Type question : mot dap an dung </br>';
			}else echo 'Type question : Nhieu dap an dung </br>';
			if($question['q_level']==1)
			{
				echo 'level question : trung binh </br>';
			}else echo 'level question : kho </br>';
			echo 'Created date : '.$question['q_created_date'].' </br>';
			echo 'Updated date : '.$question['q_updated_date'].' </br>';
			?>
			<hr width=300px align="left"/>
			<table border="1">
			<caption>TABLE ANSWER</caption>
			<thead bgcolor="#0892d0">
			<tr>
			<th>Content Answer</th>
			<th>Status</th>
			</tr>
			</thead>
			<tbody bgcolor="#7df9ff	">    
			   <?php
        	foreach ($answer as $value) {
        		if($value['qa_status']==1)
        			$string ='True';
        		else $string ='False';
            echo '
            <tr>
                <td>'.$value['qa_content'].'</td>
                <td>'.$string.'</td>
            </tr>';
       		 }
			
    		?>
			</tbody>
			</table>
			<br/>
			<hr width=300px align="left"/>
			<?php echo Html::a('Back', ['/question/index'],['class'=>'btn btn-success']);?>
			<?=Html::a('Edit', ['/question/edit','q_id'=>$question->q_id], ['class'=>'btn btn-warning'])?>
			<?=Html::a('Delete', ['/question/delete','q_id'=>$question->q_id], ['class'=>'btn btn-danger','data' => [
						'confirm' => 'Are you sure you want to delete this item?',
						'method' => 'post', 
            			],])?>