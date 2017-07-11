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
        <div>Edit categories</div>
        <?php
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


