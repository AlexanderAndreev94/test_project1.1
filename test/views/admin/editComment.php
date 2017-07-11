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
        <div>Edit comments</div>
        <?php
                $dataProvider = new ActiveDataProvider([
                    'query' => \app\models\Comment::find(),
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
                                'update' => function ($url, $model, $key) {
                                    Modal::begin(['id' => 'editCommentModal'.$key,
                                        'header' => 'Edit comments']);

                                    $form = ActiveForm::begin([
                                        'id' => 'editCommentForm', 'action' => ['admin/editcomment'], 'method' => 'post'
                                    ]);

                                    $items = [
                                        'active' => 'Active',
                                        'inactive' => 'Inactive'
                                    ];

                                    echo $form->field($model, 'id')->textInput(['name'=>'commentId'])->label('ID');
                                    echo $form->field($model, 'content')->textInput()->label('Comment');
                                    echo $form->field($model, 'status')->textInput()->dropDownList($items, ['prompt'=>'Select status'])->label('Status');
                                    echo Html::submitButton('Edit comment', ['id'=>'editComment', 'class'=>'btn btn-success']);

                                    ActiveForm::end();
                                    Modal::end();

                                    return Html::a('Update', '#', ['data-toggle'=>'modal', 'data-target'=>'#editCommentModal'.$key]);
                                },
                                'delete' => function($url, $model, $key){
                                    Modal::begin([
                                        'id' => 'deleteCommentModal'.$key,
                                        'header' => 'Dlelete comment',
                                    ]);

                                    echo '<center><h3>Are you sure to delete comment with id:'.$key.'?</h3></center>';
                                    echo '<center>'.Html::a('Delete', Url::to(['admin/delete-comment', 'id'=>$key,]), ['class' => 'btn btn-success']).' '.Html::a('Cancel', '#', ['class'=>'btn btn-primary', 'data-dismiss' => 'modal']).'</center>';

                                    Modal::end();
                                    return Html::a('Delete', '#', ['data-toggle' => 'modal', 'data-target'=>'#deleteCommentModal'.$key]/*, Url::to(['admin/delete-comment', 'id'=>$key])*/);
                                },
                                'view' => function(){}
                            ],
                        ],

                        'id',
                        'post_id',
                        'user_id',
                        'content',
                        'status',
                        'date_created'
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


