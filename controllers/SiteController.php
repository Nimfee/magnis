<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\web\Controller;
use yii\filters\VerbFilter;


class SiteController extends Controller
{
    /**
     * @OA\Info(
     *   version="1.0",
     *   title="Application API",
     *   description="Server - Students API",
     *   @OA\Contact(
     *     name="John Smith",
     *     email="john@example.com",
     *   ),
     * ),
     * @OA\Server(
     *   url="http://localhost/magnis/magnis/web/api",
     *   description="main server",
     * )
     * @OA\Server(
     *   url="http://localhost/magnis/magnis/web/api",
     *   description="dev server",
     * )
     */

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
            'api-docs' => [
                'class' => 'genxoft\swagger\ViewAction',
                'apiJsonUrl' => \yii\helpers\Url::to(['/site/api-json'], true),
            ],
            'api-json' => [
                'class' => 'genxoft\swagger\JsonAction',
                'dirs' => [
                    Yii::getAlias('@app/controllers'),
                    Yii::getAlias('@app/modules/api/controllers'),
                    Yii::getAlias('@app/modules/api/models'),
                ],
            ],
        ];
    }
}
