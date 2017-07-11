<?php
/**
 * Created by PhpStorm.
 * User: alexander.andreev
 * Date: 29.06.2017
 * Time: 16:43
 */

namespace app\controllers;

use app\models\Category;
use app\models\Categorytree;
use app\models\Comment;
use app\models\Post;
use app\models\Postimage;
use app\models\UploadForm;
use yii\web\Controller;
use yii\web\UploadedFile;
use yii\web\NotFoundHttpException;
use yii\helpers\ArrayHelper;
use yii;

class AdminController extends Controller
{
    const SHOW_CATEGORIES = 1;
    const EDIT_POSTS = 2;
    const EDIT_COMMENTS = 3;
    const CATEGORY_DEFAULT_STATUS = 'active';
    const NEW_ROOT = 'NEW ROOT';

    public function actionIndex()
    {
        return $this->render('index', ['id'=>1]);
    }

    public function actionShow($id)
    {
        if($id == self::SHOW_CATEGORIES)
        {
            $model = new Category();
            $cats = $model->find()->all();

            return $this->render('index', ['id' => $id, 'categories' => $cats]);
        }
        if($id == self::EDIT_POSTS)
        {
            $posts = Post::find()->all();

            $postsAndCategory = [];
            $i=0;
            foreach ($posts as $post)
            {
                $category = (new yii\db\Query())->select('title')->from('category')->where('id=:id',[':id'=>$post->category_id])->one();
                $postsAndCategory[$i] = ['postTtl'=>$post->title, 'categoryTtl'=> $category['title'], 'postId'=>$post->id];
            }

            return $this->render('index', ['id' => $id, 'posts' => $posts, 'postsByCat' => $postsAndCategory]);
        }
        if($id == self::EDIT_COMMENTS)
        {
            $pmodel = new Post();
            $posts = $pmodel->find()->all();

            return $this->render('index', ['id' => $id, 'posts'=>$posts]);
        }
    }

    public function actionEditPost()
    {
        $post = Post::findOne(Yii::$app->request->post('postId'));
        if($post)
        {
            $model = new UploadForm();

            if (Yii::$app->request->isPost) {
                $model->imageFile = UploadedFile::getInstance($model, 'imageFile');

                $model->postid = $_POST['postid'];
                $model->upload();
            }

            $post->load(Yii::$app->request->post());
            $post->save(false);
            return $this->render('index', ['id' => self::EDIT_POSTS]);
        }
        return new NotFoundHttpException();
    }

    public function actionDeletePost($id)
    {
        $post = Post::findOne($id);

        if($post)
        {
            $post->delete();
            return $this->render('index', ['id' => 2]);
        }
        return new NotFoundHttpException();
    }

    public function actionAdd()
    {
        $model = new Post();

        if(Yii::$app->request->isPost)
        {
            $model->load(Yii::$app->request->post());
            $model->save(false);
        }
        return $this->render('index', ['id' => self::EDIT_POSTS]);
    }

    public function actionEditcomment()
    {
        if(Yii::$app->request->post())
        {
            $comment = Comment::findOne(Yii::$app->request->post('commentId'));
            if($comment)
            {
                $comment->load(Yii::$app->request->post());
                $comment->save();
                return $this->render('index', ['id'=>3]);
            }
        }
        return new NotFoundHttpException();
    }
    public function actionDeleteComment($id)
    {
        $comment = Comment::findOne($id);

        if($comment)
        {
            $comment->delete();
            return $this->render('index', ['id'=>self::EDIT_COMMENTS]);
        }
        return new NotFoundHttpException();
    }
    public function actionAddcat()
    {
        $catTitle = Yii::$app->request->post('name');
        $catTree  = Yii::$app->request->post('ctree');

        $model = new Categorytree(['name' => $catTitle]);
        $model->status = self::CATEGORY_DEFAULT_STATUS;

        $categ = Categorytree::find()->where('name=:n', [':n'=>$catTitle])->one();

        if(!$categ)
        {
            if($catTree == self::NEW_ROOT)
            {
                $model->position = 0;
                $model->makeRoot();
            } else{
                $categ = Categorytree::findOne($catTree);

                if($categ){
                    $model->appendTo($categ);

                    $categs = Categorytree::find()->where('tree=:t',[':t'=>$catTree])->all();
                    $max=0;
                    foreach ($categs as $categ)
                    {
                        if($categ->position > $max)
                        {
                            $max = $categ->position;
                        }
                    }
                    $model->position = $max + 1;
                }else{
                    $model->makeRoot();
                }
            }
            $model->save();
            return $this->render('index', ['id' => 1, 'catTree' => $catTree, 'err' => '']);
        }
        return $this->render('index', ['id'=>1, 'err' => 'Category already exists']);
    }

    public function actionUpdateCategory()
    {
        $cat = Categorytree::findOne(Yii::$app->request->post('categoryId'));

        if($cat)
        {
            $cat->load(Yii::$app->request->post());
            $cat->save(false);
            return $this->render('index', ['id'=>self::SHOW_CATEGORIES]);
        }
        return new NotFoundHttpException();
    }

    public function actionDeleteCategory($id)
    {
        $cat = Categorytree::findOne($id);

        if($cat)
        {
            $cat->delete();
            return $this->render('index', ['id'=>self::SHOW_CATEGORIES]);
        }
        return new NotFoundHttpException();
    }
}
