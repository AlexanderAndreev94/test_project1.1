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
        <div>Categories, posts and comments page</div>
        <?php
            if(isset($id))
            {
                if($id == 1)
                {

                    echo Html::button('Add new category', ['id'=>'newCatBtn', 'class'=>'btn btn-success', 'data-toggle'=>'modal', 'data-target'=>'#addCatModal']);

                    $dataProvider = new ActiveDataProvider([
                        'query' => \app\models\Categorytree::find(),
                        'pagination' => [
                            'pageSize' => 20,
                        ],
                    ]);
                    echo GridView::widget([
                        'dataProvider' => $dataProvider,
                        'id' => 'catGV',
                        'columns' => [
                            [
                                    'class' => 'yii\grid\ActionColumn',
                                    'buttons' => [
                                            'update' => function($url, $model, $key){
                                                Modal::begin([
                                                        'id' => 'editCategoryModal'.$key,
                                                        'header' => 'Edit category'
                                                ]);
                                                $form = ActiveForm::begin([
                                                        'id'=>'editCategoryForm', 'action'=>['admin/update-category'], 'method' => 'post'
                                                ]);

                                                $itemsStatus = [
                                                    'active' => 'Active',
                                                    'inactive' => 'Inactive'
                                                ];

                                                $categoryItems = ArrayHelper::map(Categorytree::find()->all(), 'id', 'name');

                                                echo $form->field($model, 'id')->textInput(['name'=>'categoryId'])->label('ID');
                                                echo $form->field($model, 'name')->textInput()->label('Category name');
                                                echo $form->field($model, 'status')->textInput()->dropDownList($itemsStatus, ['prompt' => 'Choose status'])->label('Status');
                                                echo $form->field($model, 'tree')->textInput()->dropDownList($categoryItems, ['prompt' => 'Choose category'])->label('Tree (ROOT)');
                                                echo $form->field($model, 'position')->textInput()->label('Position');
                                                echo Html::submitButton('Update category', ['id'=>'updateCat', 'class'=>'btn btn-success']);

                                                ActiveForm::end();
                                                Modal::end();

                                                return Html::a('Update', '#', ['data-toggle'=>'modal', 'data-target'=>'#editCategoryModal'.$key]);
                                            },
                                            'delete' => function($url, $model, $key){
                                                Modal::begin([
                                                    'id' => 'deleteCategoryModal'.$key,
                                                    'header' => 'Dlelete category',
                                                ]);

                                                echo '<center><h3>Are you sure to delete category with id:'.$key.'?</h3></center>';
                                                echo '<center>'.Html::a('Delete', Url::to(['admin/delete-category', 'id'=>$key,]), ['class' => 'btn btn-success']).' '.Html::a('Cancel', '#', ['class'=>'btn btn-primary', 'data-dismiss' => 'modal']).'</center>';

                                                Modal::end();
                                                return Html::a('Delete', '#', ['data-toggle' => 'modal', 'data-target'=>'#deleteCategoryModal'.$key]/*, Url::to(['admin/delete-comment', 'id'=>$key])*/);
                                            },
                                            'view' => function($url, $model, $key){

                                            }
                                    ],

                            ],

                            'id',
                            'name',
                           'status',
                            'tree',
                            'position',
                        ],
                        'options' => ['style' => 'width: 750px; padding: 10px;',]
                    ]);

                    if(isset($err))
                        echo $err;

                    Modal::begin([
                            'id' => 'addCatModal',
                        'header' => 'Add new Category'
                    ]);

                    $catTreeModel = new \app\models\Categorytree();

                    $form = ActiveForm::begin([
                            'id' => 'addNewCatForm', 'action' => ['admin/addcat'], 'method' => 'post',
                    ]);

                    $items = ArrayHelper::map(\app\models\Categorytree::find()->all(), 'tree', 'name');
                    $items[0] = 'NEW ROOT';
                    asort($items);

                    echo $form->field($catTreeModel, 'name')->textInput(['name'=>'name'])->label('Category title');
                    echo $form->field($catTreeModel, 'tree')->textInput(['name' => 'tree'])->dropDownList($items, ['prompt'=>'Choose tree', 'name'=>'ctree', ])->label('Category tree');
                    echo Html::submitButton('Add category', ['id'=>'submitCat', 'class'=>'btn btn-success']);
                    ActiveForm::end();
                    Modal::end();

                }
                if($id == 2)
                {

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

                }
                if($id == 3)
                {
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
                }
            }

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


