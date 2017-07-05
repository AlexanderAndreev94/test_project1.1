<?php

    use yii\helpers\Html;
    use yii\widgets\Pjax;
    use yii\helpers\Url;
    $this->title = 'Home';

//$count
///переделать выдачу постов. Сделать циклом по 10 статей
?>
<?php Pjax::begin(); ?>
    <div class="articleContainer">
<?php
    //$art_sort
    foreach($articles as $article)
    {
        echo '

                <div class="article">
                    <div class="articleHeader">
                        <div class="name">
                            <p>'.Html::a($article->title, Url::to(['main/show','id'=>$article->id])).'</p>
                        </div>
                        <div class="postDate">
                            <p>'.$article->pub_date.'</p>
                        </div>
                    </div>
                </div>

        ';
        $offsetId++;
    }

?>
        <div class="nextBtn">
            <?= Html::button('Next 10 posts', ['id'=>'nextButton', 'class'=>'btn btn-lg btn-primary', 'catId'=>$catId, 'offsetId' => $offsetId]);//Html::a("Next 10 posts", ['main/home'], ['class' => 'btn btn-lg btn-primary']);
            ?>
        </div>

    </div>


<div class="catTree">
    <div class="treeHeader"><h3>Categories</h3></div>
    <div class="catList">

        <?php

        foreach($categories as $category)
        {
            if($category->status = 'active')
                echo '<div class="catItem">'.Html::a($category->title, Url::to(['main/home', 'catId'=>$category->id, 'offsetId'=>$offsetId])).'</div>';
        }


        ?>

    </div>
</div>
<?php Pjax::end(); ?>