<?php
    use yii\helpers\Html;
    use yii\widgets\Pjax;
    use \yii\bootstrap\Modal;
    use \yii\widgets\ActiveForm;
    use yii\helpers\Url;
    use \creocoder\nestedsets\NestedSetsBehavior;
    use \app\components\CategoryWidget;
   echo $this->title;
?>
<div class="adminContainer">
    <?php Pjax::begin();?>
    <div class="left">
        <div>Categories, posts and comments page</div>
        <?php
            if(isset($id))
            {
                if($id == 1)
                {
                    foreach($categories as $category)
                    {
                        echo '
                            <div>'.$category->title.'</div>
                    ';
                    }
                }
                if($id == 2)
                {

                    foreach($posts as $post)
                    {
                        $cat = $categories->find()->where('id=:id', [':id'=>$post->category_id])->one();
                        echo '
                            <div style="border: 1px solid; border-radius: 5px; width: 200px; height: 50px; margin-top: 10px; box-sizing: border-box; padding-left: 5px;">
                                <p>'.'Title: '.$post->title.'</p>
                                <p>'.'Category: '.$cat->title.' '.Html::a("Edit", Url::to(['admin/edit', 'id'=>$post->id]), ['id'=>'editLink', 'data-toggle' => 'modal', 'data-target' => '#editPostModal']).' '.Html::a("Delete", "admin/delete&id=".$post->id).'</p>

                            </div>
                        ';

                        Modal::begin([
                            'header'=>'Edit post',
                            'id' => 'editPostModal'
                        ]);

                        $form = ActiveForm::begin(
                            [
                                'id' => 'editPostForm', 'action' => ['admin/edit&id='.$post->id], 'method' => 'post',
                                //      'options' => ['data-pjax' => true,'enctype' => 'multipart/form-data']
                            ]
                        );

                        echo $form->field($post, 'id')->textInput()->label('postId');
                        echo $form->field($post, 'title')->textInput()->label('title');
                        echo $form->field($post, 'content')->textarea(['rows'=>4])->label('content');
                        echo $form->field($post, 'status')->textInput()->label('status');
                        echo Html::submitButton('Edit', ['class'=>'btn btn-success']);
                        ActiveForm::end();
                        Modal::end();
                    }

                }
                if($id == 3)
                {
                    foreach($posts as $post)
                    {
                        echo '
                            <div style="border: 1px solid; border-radius: 5px; width: 200px; height: 50px; margin-top: 10px; box-sizing: border-box; padding-left: 5px;">
                                <p>'.'Title: '.$post->title.'</p>
                                <p>'.Html::a("Edit comments", "", ['id'=>'editCommentLink', 'data-toggle' => 'modal', 'data-target' => '#editCommentsModal']).'</p>

                            </div>
                        ';
                        $commentModel = new \app\models\Comment();
                        Modal::begin([
                            'header'=>'Edit comments',
                            'id' => 'editCommentsModal'
                        ]);

                        $form = ActiveForm::begin(
                            [
                                'id' => 'editPostForm', 'action' => ['admin/editcomment'], 'method' => 'post',
                                //      'options' => ['data-pjax' => true,'enctype' => 'multipart/form-data']
                            ]
                        );

                        echo $form->field($commentModel, 'id')->textInput()->label('comment ID');
                        echo $form->field($commentModel, 'post_id')->textInput(['value'=>$post->id])->label('Post ID');
                        echo $form->field($commentModel, 'content')->textarea(['rows'=>4])->label('content');
                        echo $form->field($commentModel, 'date_created')->textInput()->label('comment creation date');
                        echo $form->field($commentModel, 'status')->textInput()->label('status');
                        echo Html::submitButton('Edit', ['class'=>'btn btn-success']);
                        ActiveForm::end();
                        Modal::end();
                    }
                }
            }

        ?>
    </div>
    <?php
    echo CategoryWidget::widget(['id'=>$id]);
    ?>
    <?php Pjax::end();?>
</div>


