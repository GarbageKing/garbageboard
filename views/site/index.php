<?php

/* @var $this yii\web\View */
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\widgets\LinkPager;

$this->title = 'Garbageboard';
?>
<div class="row site-index">
    
     <?php foreach ($topics as $topico): ?>
                        <div class="topic col-xs-12">
                                <hr>
                            <div class="row">
                                <div class="col-xs-10">
                                    <?php echo $topico->name ?>
                                </div>
                                <div class="col-xs-2">
                                    <p>By: <strong><?= ($topico->author_name == '') ? 'Anon' : $topico->author_name; ?></strong></p>                                            
                                </div> 
                                
                            </div>
                            <div class="row">
                                <div class="col-xs-push-8 col-xs-4">
                                   <?= $topico->date_created ?>
                                    <a type="button" class="btn btn-lg" href="index.php?r=site%2Fmessagelist&topic_id=<?= $topico->id ?>">View</a>
                                </div>
                            </div>
                                <hr>
                        </div>
     <?php endforeach; ?>
    
    <div class="col-xs-12">
     <?php echo LinkPager::widget([
    'pagination' => $pages,
    ]); ?>
    </div>
  
    <div class="col-xs-12">
        <div class="topic-form">
            <h2>Create Topic</h2>
    <?php $form = ActiveForm::begin(); 
    $form->action=  yii\helpers\Url::to('index.php?r=topic%2Fcreate');
    ?>    
    
    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'author_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'del_key')->hiddenInput(['value' => rand(0, 9999999)])->label(false) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
	
        </div>
    </div>
</div>
