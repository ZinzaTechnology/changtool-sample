<?php 
use yii\helpers\Html;
use yii\helpers\Url;
?>



<?= Html::beginForm(Url::toRoute('question/index'),'post'); ?>
		Search body :
    <?= Html::input('text', 'q_content', Yii::$app->request->post('q_content')) ?>
    </br>
    category :
     <?= Html::dropDownList('category', [], $category,['prompt'=>'---Select---']) ?>
	 type :
     <?= Html::dropDownList('type', [],['1'=>'1','2'],['prompt'=>'---Select---']) ?>
     level :
     <?= Html::dropDownList('level', [],['1'=>'1','2'],['prompt'=>'---Select---']) ?>
     tag :
     <?php  echo Html::input('text', 'qt_content',Yii::$app->request->post('qt_content')) ?>
     </br>
    <?= Html::submitButton('Search', ['class' => 'btn btn-lg btn-primary', 'name' => 'search']) ?>
<?= Html::endForm() ?>






<!--  
<table  width="663" bgcolor="#FF3366">
		<tr>
		<form action='Url::toRoute([controller/index])' method="post" name="from1">
		<td>Search body</td>
		<td width="379" height="40"> <input type="text" name="search1"></td>
		<td width="118"><input type="submit" name="search1" value="Search" ></td>
		</form>
		</tr>
</table></font>
<form  action="Url::toRoute([controller/index])" method="post" name="from2">
		category :
		<?php 
		echo '<select name="q_category">'; 
		echo '<option value="" "></option>';
   		echo '<option value="'.$category[1].'">'.$category[1].'</option>';
   		echo '<option value="'.$category[2].'">'.$category[2].'</option>';
   		echo '<option value="'.$category[3].'">'.$category[3].'</option>';
   		echo '<option value="'.$category[4].'">'.$category[4].'</option>';
   		echo '<option value="'.$category[5].'">'.$category[5].'</option>';
		echo '</select>';
		?>
		Type :
		<?php 
		echo '<select name"q_type">'; 
		echo '<option value="" "></option>';
   		echo '<option value="1">1 cau hoi dung</option>';
   		echo '<option value="2">nhieu cau tra loi dung</option>';
		echo '</select>';
		?>
		Type :
		<?php 
		echo '<select name"q_level">'; 
		echo '<option value="" "></option>';
   		echo '<option value="1">Trung Binh</option>';
   		echo '<option value="2">Kho</option>';
		echo '</select>';
		?>
		Tag : <input type="text" name="tag">
		<input type="submit" name="search2" value="Search" >
		</form> -->