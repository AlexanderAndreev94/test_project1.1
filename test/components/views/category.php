<?php
use yii\helpers\Html;
use \yii\bootstrap\Modal;
use \yii\widgets\ActiveForm;

?>
<div class="right">
    <div><?= Html::a('Categories', 'index.php?r=admin/show&id=1'); ?></div>
    <div><?= Html::a('Edit posts', 'index.php?r=admin/show&id=2'); ?></div>
    <?php
    if(isset($id))
    {
        if($id == 2)
        {
            $model = new \app\models\Post();
            $imgModel = new \app\models\UploadForm();
            Modal::begin([
                'header'=>'Edit post',
                'id' => 'addPostModal'
            ]);

            $form = ActiveForm::begin(
                [
                    'id' => 'addPostForm', 'action' => ['admin/add'], 'method' => 'post',
                    'options' => ['enctype' => 'multipart/form-data'],
                ]
            );

            $items = \yii\helpers\ArrayHelper::map(\app\models\Categorytree::find()->all(), 'id', 'name');

            echo $form->field($model, 'title')->textInput()->label('title');
            echo $form->field($model, 'content')->textarea(['rows'=>4])->label('content');
            echo $form->field($model, 'category_id')->textInput()->dropDownList($items, ['prompt'=>'Select category'])->label('category id');
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