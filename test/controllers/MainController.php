<?php
/**
 * Created by PhpStorm.
 * User: alexander.andreev
 * Date: 28.06.2017
 * Time: 14:37
 */

namespace app\controllers;


use app\models\Category;
use app\models\Comment;
use app\models\LoginForm;
use app\models\Post;
use app\models\Postimage;
use app\models\UserIdentity;
use yii\web\Controller;
use yii\helpers\Json;
use yii;


class MainController extends  Controller
{
    const ROLE_USER = 'user';
    const STATUS = 1;
    const DEFAULT_CATEGORY = 1;

    public function actionRegistration()
    {
        $model = new UserIdentity();

        if(Yii::$app->request->isPjax)
        {
            $model->load(Yii::$app->request->post());
            $model->datetime_registration = date("Y-m-d H:i:s");
            $model->role = self::ROLE_USER;
            $model->status = self::STATUS;

            $result = UserIdentity::find($model->username)->one();

            if($result->username != $model->username)
            {
                $model->save();

                $lmodel = new LoginForm();
                if ($lmodel->load(Yii::$app->request->post()) && $lmodel->login()) {
                    $session = Yii::$app->session;
                    if(!$session->isActive)
                    {
                        $session->open();
                        $session->set('username', $model->username);
                    }
                    return true;
                }
                /*
                */

                return $this->render('about');
            }
        }

        return false;
    }

    public function actionLogin()
    {
        $model = new LoginForm();

        if(Yii::$app->request->isPjax)
        {
            if ($model->load(Yii::$app->request->post()) && $model->login()) {
                return true;
            }
        }


        return false;
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->render('about');
    }

    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionHome($catId, $offsetId)
    {
        if($catId === null)
        {
            $catId = self::DEFAULT_CATEGORY;
        }

        $postModel = new Post();

        if($offsetId <= 10)
        {
            $offsetId = 0;
        }
        if($offsetId % 10 == 0 && $offsetId >= 10)
        {
            $offsetId++;
        }
        $articles = $postModel->find()->where('category_id=:id', [':id'=>$catId])->andWhere(['like', 'status', 'active'])->andWhere('pub_date<:date', [':date'=>date("Y-m-d H:i:s")])->orWhere('pub_date=:date', [':date'=>date("Y-m-d H:i:s")])->limit(10)->offset($offsetId)->orderBy(['pub_date' => SORT_DESC])->all();

        $categories = Category::find()->where(['like', 'status', 'active'])->all();

        if(Yii::$app->request->isAjax)
        {
            $articlesJson = [];
            $i =0;
            foreach($articles as $article)
            {
                $articlesJson[$i] = ['title' => $article->title, 'pub_date' => $article->pub_date];
                $i++;
            }

            return Json::encode($articles);
        }

        return $this->render('home', ['articles' => $articles, 'categories' => $categories, 'offsetId' => $offsetId, 'catId'=>$catId]);
    }

    public function actionContact()
    {
        return $this->render('contact');
    }

    public function actionShow($id)
    {
        $comments = new Comment();

        if(Yii::$app->request->isPjax)
        {
            $comments->load(Yii::$app->request->post());
            $comments->save();
        }

        $articles = new Post();
        $article = $articles->find()->where('id=:id', [':id'=>$id])->one();

        $img = new Postimage();
        $image = $img->find()->where('post_id=:id', [':id'=>$id])->one();

        if($article && $image)
        {

            $commentsObj = $comments->find()->where('post_id=:id', [':id'=>$id])->all();

            $users = new UserIdentity();

            $toCommentsQry = (new yii\db\Query())->select('user_id')->from('comment')->where('post_id=:id', [':id'=>$id]);

            $usersObj = $users->find()->where(['id'=>$toCommentsQry])->all();

            $userId = Yii::$app->user->id;
            return $this->render('article', ['article'=>$article,'post_id'=>$id, 'image' => $image, 'comments' => $commentsObj, 'user_id' => $userId, 'users'=>$usersObj]);
         //   return $this->render('article', ['article'=>$article,'post_id'=>$id, 'users'=>$allUsers, 'image' => $image, 'comments' => $comments_ar, 'user_id' => $user_id]);
        }
        return false;

    }


}