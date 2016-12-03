<?php

/* @var $this yii\web\View */
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\widgets\LinkPager;


$this->title = 'Messages';
//$this->params['breadcrumbs'][] = $this->title;
?>
<?php if (Yii::$app->session->hasFlash('del_key')): ?>
  <div class="alert alert-success alert-dismissable">
  <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
  <h4><i class="icon fa fa-check"></i>Posted! Your deletion key is: </h4>
  <?= Yii::$app->session->getFlash('del_key') ?>
  </div>
<?php endif; ?>
<div class="row site-about">
     <?php foreach ($messages as $message): ?>
                        <div class="message col-xs-12" style="border: 1px dashed #333; margin-bottom: 20px; background: #ffebeb">
                            <div class="row">
                                <div class="col-xs-1" style="background: #9acfea;">
                                    #<?= $message->id ?>
                                    <p style="<?= ($message->answer_for_id == '') ? 'display:none;' : 'display:block'; ?>">
                                    To: <?= $message->answer_for_id ?>
                                    </p>
                                </div>
                                <div class="col-xs-2">
                                    <img style="padding-top: 10px; padding-bottom: 10px; width:100%; height:auto; <?= ($message->image == '') ? 'display:none;' : 'display:inline-block'; ?>" 
                                         href="<?= $message->image ?>" target="_blank" src="<?= $message->image ?>"/>
                                </div>
                                <div class="col-xs-9" >
                                    <p><strong><?= ($message->author_name == '') ? 'Anon' : $message->author_name; ?></strong> says>>></p>
                        <?php echo $message->text; ?>                  
                                </div> 
                                
                                </div>
                                <div class="row" style="background: #9acfea">
                                <div class="col-xs-8">
                                    
                                    <!--<a href="index.php?r=message%2Fupdate&id=<?= $message->id ?>" type="button" class="btn btn-lg reply">Update</a>
                                    <a href="index.php?r=message%2Fdelete&id=<?= $message->id ?>" data-confirm="Are you sure you want to delete this message?" type="button" class="btn btn-lg reply" data-method="post" pjax="0">Delete</a>-->
                        Key: <input class="del_code" type="text" name="<?= $message->id ?>">  
                        <a class="btn btn-lg" name="<?= $message->id ?>" onclick="deletion(this)" href="index.php?r=message%2Fdelete&amp;id=<?= $message->id ?>" data-confirm="Are you sure you want to delete this item?" data-method="post">Delete</a>
                            </div>                                
                                <div class="col-xs-4">
                                   <?= $message->date_created ?>
                                    <a type="button" class="btn btn-lg reply" onclick="getMessage(this)" name="<?= $message->id ?>">Reply</a>
                                </div>
                                </div>                            
                            </div>
     <?php endforeach; ?>
        
    
    <div class="col-xs-12">
     <?php echo LinkPager::widget([
    'pagination' => $pages,
    ]); ?>
    </div>
    
    
    <div class="col-xs-12">
        <div class="message-form">
            <h2>Write a Message</h2>
     
        <div id="rep-to" style="display: none;">Replying To: <span ></span> <button id="norepl" onclick="resetMessage()">Don't Reply</button></div>
        
    <?php $form = ActiveForm::begin(/*['options' => ['enctype' => 'multipart/form-data']]*/); 
    $form->action=  yii\helpers\Url::to('index.php?r=message%2Fcreate');
    ?>
        
    <?= $form->field($model, 'author_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'text')->textArea(['maxlength' => true]) ?>

    <?= $form->field($model, 'image')->textInput(['maxlength' => true]) ?>
        
     <?= $form->field($model, 'imageFile')->fileInput(['onchange' => 'fileChoice()'])?>  

    <?= $form->field($model, 'answer_for_id')->hiddenInput()->label(false) ?>

    <?= $form->field($model, 'topic_id')->hiddenInput(['value' => Yii::$app->getRequest()->getQueryParam('topic_id')])->label(false) ?>
	
    <?= $form->field($model, 'del_key')->hiddenInput(['value' => rand(0, 9999999)])->label(false) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

        </div>
    </div>
    
</div>

<script>
    
        function fileChoice(){
            var imagefile = document.getElementById("message-imagefile").value;
    
            if(imagefile != '')
            {
                var parts = imagefile.split('\\');
                var answer = parts[parts.length - 1];
                answer = 'uploads/' + answer;
                
                document.getElementById("message-image").value = answer;
            
            }
        }
        
        var element = document.getElementById("message-answer_for_id");
        var showElement = document.getElementById("rep-to").getElementsByTagName('span')[0];             
        
        function getMessage(thisButton){      
              
              var mesId = thisButton.getAttribute("name");
              
              element.value = mesId;
              
              showElement.innerHTML = mesId;
              
              document.getElementById("rep-to").style.display = 'block';
              
            }
            
            function resetMessage(){                
                
                element.value = '';
                
                showElement.innerHTML = '';   
                
                document.getElementById("rep-to").style.display = 'none';
                
            }
            
            function deletion(thisButton){                
                
                var mesId = thisButton.getAttribute("name");
                
                var allNames = document.getElementsByName(mesId);
                
                var input;
                
                for (var i = 0; i < allNames.length; i++) {
                    if (allNames[i].type == "text") {
                    input = allNames[i];
                    }
                }
                
                //var input = document.getElementsByTagName("input")[0].elements["'"+mesId+"'"];
                
                var del_key = '&del_key='+input.value;
                                
                thisButton.href += del_key;
                
            }
        
</script>