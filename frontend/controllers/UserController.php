<?php

namespace frontend\controllers;

use Yii;
use common\filters\auth\HeaderParamAuth;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use common\models\Users;
use common\models\Category;
use common\models\Trip;
use common\models\Handler;
use frontend\models\LoginForm;

class UserController extends Controller
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => HeaderParamAuth::className(),
            'only' => ['get-user-info']
        ];
        return $behaviors;
    }

    protected function verbs()
    {
        return [
            'login' => ['post'],
            'get-user-info' => ['get'],
        ];
    }

    /**
     * Login
     */
    public function actionLogin()
    {
        $model = new LoginForm();
        $model->load(Yii::$app->request->post(), '');

        if ($model->login()) {
            $data = $model->user->toArray(['username', 'nickname', 'access_token']);
            $data['handler_id'] = $model->user->handler->id;
            $data['handler_name'] = $model->user->handler->handler_name;
            $data['trip_id'] = $model->user->trip->id;
            $data['trip_name'] = $model->user->trip->trip_name;


            return [
                'Ret' => 0,
                'Data' => $data
            ];
        } else {
            Yii::warning('用户登录失败！');
            return [
                'Ret' => 1,
                'Data' => [
                    'errors' => $model->getFirstErrors()
                ]
            ];
        }
    }

    /**
     * Login
     */
    public function actionGetUserInfo()
    {
        $identity = Yii::$app->user->identity;
        
        $user = $identity->toArray(['username', 'nickname', 'access_token']);
        $user['handler_id'] = $identity->handler->id;
        $user['handler_name'] = $identity->handler->handler_name;
        $user['trip_id'] = $identity->trip->id;
        $user['trip_name'] = $identity->trip->trip_name;

        $category = Category::find()
            ->select(['id', 'category_name'])
            ->orderBy(['category_sequence' => SORT_DESC])
            ->all();
        $trip = Trip::find()
            ->select(['id', 'trip_name'])
            ->orderBy(['trip_sequence' => SORT_DESC])
            ->all();
        $handler = Handler::find()
            ->select(['id', 'handler_name'])
            ->all();

        $data = [
            'user' => $user,
            'category' => $category,
            'trip' => $trip,
            'handler' => $handler,
        ];

        return [
            'Ret' => 0,
            'Data' => $data
        ];
    }

}