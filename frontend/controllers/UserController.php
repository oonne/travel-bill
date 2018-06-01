<?php

namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use common\models\Users;
use frontend\models\LoginForm;

class UserController extends Controller
{
    protected function verbs()
    {
        return [
            'login' => ['post']
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

}