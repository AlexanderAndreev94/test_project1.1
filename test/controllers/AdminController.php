<?php
/**
 * Created by PhpStorm.
 * User: alexander.andreev
 * Date: 29.06.2017
 * Time: 16:43
 */

namespace app\controllers;

use app\models\Category;
use app\models\Comment;
use app\models\Post;
use app\models\Postimage;
use app\models\UploadForm;
use yii\web\Controller;
use yii\web\UploadedFile;
use yii;

class AdminController extends Controller
{
    const SHOW_CATEGORIES = 1;
    const EDIT_POSTS = 2;
    const EDIT_COMMENTS = 3;

    public function actionIndex()
    {
        return $this->render('index');
    }
    public function actionUpload()
    {
        $model = new UploadForm();

        if (Yii::$app->request->isPost) {
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
            $data =  Yii::$app->request->post();
            $model->postid = $_POST['postid'];
            if ($model->upload()) {
                // file is uploaded successfully
                return $this->render('upload', ['model' => $model]);
            }
        }

        return $this->render('upload', ['model' => $model]);
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
            $pmodel = new Post();
            $posts = $pmodel->find()->all();

            $cmodel = new Category();

            return $this->render('index', ['id' => $id, 'posts' => $posts, 'categories' => $cmodel]);
        }
        if($id == self::EDIT_COMMENTS)
        {
            $pmodel = new Post();
            $posts = $pmodel->find()->all();

            return $this->render('index', ['id' => $id, 'posts'=>$posts]);
        }
    }

    public function actionEdit($id)
    {


            $model = new Post();
            $model->load(Yii::$app->request->post());
            $model->save();


    }

    public function actionDelete($id)
    {
        $post = Post::findOne($id);

        if($post)
        {
            $post->delete();
        }

    }

    public function actionAdd()
    {
        $model = new Post();

        if(Yii::$app->request->isPost)
        {
            $model->load(Yii::$app->request->post());
            $model->save();
        }
        return $this->render('index');
    }

    public function actionEditcomment()
    {
        $model = new Comment();

        if(Yii::$app->request->post())
        {
            $model->load(Yii::$app->request->post());
            $model->save();
        }
        return $this->render('index');
    }
}