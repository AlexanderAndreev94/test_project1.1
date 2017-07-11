<?php
use yii\helpers\Html;
use yii\widgets\Pjax;
use \yii\bootstrap\Modal;
use \yii\widgets\ActiveForm;
use yii\helpers\Url;
use \app\components\CategoryWidget;
use yii\grid\GridView;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use app\models\Categorytree;
$this->title  = 'Admin page';

?>
<div class="adminContainer">
    <?php Pjax::begin();?>
    <div class="left">
        <div>Edit posts</div>
        <?php
                echo Html::button('Add new post', ['id'=>'newCatBtn', 'class'=>'btn btn-success', 'data-toggle'=>'modal', 'data-target'=>'#addPostModal']);

                $dataProvider = new ActiveDataProvider([
                    'query' => \app\models\Post::find(),
                    'pagination' => [
                        'pageSize' => 20,
                    ],
                ]);
                echo GridView::widget([
                    'dataProvider' => $dataProvider,
                    'id' => 'postGV',
                    'columns' => [
                        [
                            'class' => 'yii\grid\ActionColumn',
                            'buttons' => [
                                'update' => function($url, $model, $key){
                                    $imgModel = new \app\models\UploadForm();
                                    Modal::begin([
                                        'id' => 'editPostModal'.$key,
                                        'header' => 'Edit post'
                                    ]);

                                    $form = ActiveForm::begin([
                                        'id' => 'editPostForm', 'action' => ['admin/edit-post'], 'method' => 'post',
                                    ]);

                                    $items = ArrayHelper::map(\app\models\Categorytree::find()->all(), 'id', 'name');
                                    $itemsStatus = [
                                        '0' => 'Inactive',
                                        '1' => 'Active'
                                    ];
                                    echo $form->field($model, 'id')->textInput(['name'=>'postId'])->label('ID');
                                    echo $form->field($model, 'title')->textInput()->label('title');
                                    echo $form->field($model, 'content')->textInput()->label('content');
                                    echo $form->field($model, 'category_id')->textInput()->dropDownList($items, ['prompt'=>'Choose post category'])->label('Category ID');
                                    echo $form->field($model, 'status')->textInput()->dropDownList($itemsStatus, ['prompt'=>'Choose status'])->label('status');
                                    echo $form->field($imgModel, 'imageFile')->fileInput();
                                    echo $form->field($imgModel, 'postid')->textInput(['value' => $model->id, 'name'=>'postid'])->label('Attach post ID');
                                    echo Html::submitButton('Edit post', ['id'=>'editPost', 'class'=>'btn btn-success']);

                                    ActiveForm::end();
                                    Modal::end();
                                    return Html::a('Edit', '#', ['data-toggle'=>'modal', 'data-target'=>'#editPostModal'.$key]);
                                },
                                'delete' => function($url, $model, $key){
                                    Modal::begin([
                                        'id' => 'deletePostModal'.$key,
                                        'header' => 'Dlelete post',
                                    ]);

                                    echo '<center><h3>Are you sure to delete post with id:'.$key.'?</h3></center>';
                                    echo '<center>'.Html::a('Delete', Url::to(['admin/delete-post', 'id'=>$key,]), ['class' => 'btn btn-success']).' '.Html::a('Cancel', '#', ['class'=>'btn btn-primary', 'data-dismiss' => 'modal']).'</center>';

                                    Modal::end();
                                    return Html::a('Delete', '#', ['data-toggle' => 'modal', 'data-target'=>'#deletePostModal'.$key]/*, Url::to(['admin/delete-comment', 'id'=>$key])*/);
                                },
                                'view' => function($url, $model, $key){

                                },
                            ],
                        ],

                        'id',
                        'title',
                        'content',
                        'category_id',
                        'status',
                        'pub_date',
                    ],
                    'options' => ['style' => 'width: 750px; padding: 10px;',]
                ]);
        ?>
    </div>
    <?php
    if(!isset($id))
    {
        $id = 1;
    }
    echo CategoryWidget::widget(['id'=>$id]);
    ?>
    <?php Pjax::end();?>
</div>


