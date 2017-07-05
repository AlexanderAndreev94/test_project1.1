<?php
use yii\helpers\Html;
use yii\widgets\Pjax;
use \yii\bootstrap\Modal;
use \yii\widgets\ActiveForm;
use yii\helpers\Url;
?>
<div class="right">
    <div><?= Html::a('Categories', 'index.php?r=admin/show&id=1'); ?></div>
    <div><?= Html::a('Edit posts', 'index.php?r=admin/show&id=2'); ?></div>
    <?php
    if(isset($id))
    {
        if($id == 2)
        {
            echo '<div style="text-align:center;">'.Html::a('Add new post', '#', ['id'=>'editLink', 'data-toggle' => 'modal', 'data-target' => '#addPostModal']).'</div>';

            $model = new \app\models\Post();
            Modal::begin([
                'header'=>'Edit post',
                'id' => 'addPostModal'
            ]);

            $form = ActiveForm::begin(
                [
                    'id' => 'addPostForm', 'action' => ['admin/add'], 'method' => 'post',
                    //      'options' => ['data-pjax' => true,'enctype' => 'multipart/form-data']
                ]
            );

            echo $form->field($model, 'title')->textInput()->label('title');
            echo $form->field($model, 'content')->textarea(['rows'=>4])->label('content');
            echo $form->field($model, 'category_id')->textInput()->label('category id');
            echo $form->field($model, 'status')->textInput()->label('status');
            echo $form->field($model, 'pub_date')->textInput(['value'=>date('Y:m:d')])->label('publication date');
            echo Html::submitButton('Edit', ['class'=>'btn btn-success']);
            ActiveForm::end();
            Modal::end();
        }
    }
    ?>
    <div><?= Html::a('Edit comments', 'index.php?r=admin/show&id=3'); ?></div>
</div>