<?php 
use yii\widgets\ActiveForm;
use yii\helpers\Html;
?>




<?php $form= ActiveForm :: begin(['action' =>['question/create'], 'id' => 'form_create', 'method' => 'post',])?>
<?= $form ->field($question,'q_content')->textArea(['placeholder'=>'nhap cau hoi','row'=>'6']) ?>
<?php echo $form->field($question, 'q_category')->dropDownList($category,['prompt'=>'---Select---']); ?>
<?= $form->field($question, 'q_level')->radioList(array(1=>'Trung Binh',2 =>'Kho')); ?>
<?= $form->field($question, 'q_type')->radioList(array(1=>'1 cau tra loi dung',2 =>'nhieu cau tra loi dung')); ?>
<hr width=300px align="left"/>



   <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script>

$(document).ready(function(){
    $("#btn1").click(function(){
        var i=0;
    	var name = $("#in").val();
    	var answer = [];
    	answer[i] = name;
    	i=i++;
        $("ol").append("<li id='result1'>"+name+"<button id='btn2'>remove</button></li>");
    });
    $("#form_create").submit( function () {    
        $.ajax({   
            type: "POST",
            dataType: "html", 
            cache: false,  
            url: "controller/create",   
            success: function(data){
                $("#results").html(data);                       
            }   
        }); 

    $("#btn2").click(function(){
           $("result1").remove();
      });  
});

    
</script>

<ol id="result">
  
</ol>
<p>Answer: <input type="text" id="in" value=""></p>
<button id="btn1">Add Answer</button></br>



<hr width=300px align="left"/>
<?php // echo $form->field($tag, 'qt_content')->checkboxList($tagarray); ?>

<hr width=300px align="left"/>
<?php echo Html::a('Back', ['/question/index'],['class'=>'btn btn-success']);?>
<?= Html::submitButton('Create',['class'=> 'btn btn-success']) ?>
<?php ActiveForm :: end()?>

		