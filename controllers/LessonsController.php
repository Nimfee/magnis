<?php

namespace app\controllers;

use app\components\DataService;
use Yii;
use app\models\Lesson;
use app\models\search\LessonSearch;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;
use yii\rest\ActiveController;

/**
 * @SWG\Swagger(
 *     basePath="/",
 *     produces={"application/json"},
 *     consumes={"application/x-www-form-urlencoded"},
 *     @SWG\Info(version="1.0", title="Simple API"),
 * )
 */
class LessonsController extends ActiveController
{
    const LESSONS_LIMIT = 10;

    public $modelClass = 'app\models\Lesson';

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['verbs'] = [
            'class'   => yii\filters\VerbFilter::className(),
            'actions' => [
                'all' => ['GET', 'POST'],
                'update' => ['PUT', 'PATCH'],
                'create' => ['POST'],
            ],
        ];

        return $behaviors;
    }
    /**
     * @inheritdoc
     */
    public function actions(): array
    {
        return [
            'docs' => [
                'class' => 'yii2mod\swagger\SwaggerUIRenderer',
                'restUrl' => Url::to(['site/json-schema']),
            ],
            'json-schema' => [
                'class' => 'yii2mod\swagger\OpenAPIRenderer',
                // Тhe list of directories that contains the swagger annotations.
                'scanDir' => [
                    Yii::getAlias('@app/controllers'),
                    Yii::getAlias('@app/models'),
                ],
            ],
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * @SWG\Get(path="/users",
     *     tags={"user"},
     *     summary="获取用户列表",
     *     description="测试直接返回一个array",
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *        in = "query",
     *        name = "access_token",
     *        description = "access token",
     *        required = true,
     *        type = "string"
     *     ),
     *
     *     @SWG\Response(
     *         response = 200,
     *         description = " success"
     *     )
     * )
     *
     */
    public function actionIndex()
    {
        $searchModel = new LessonSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    public function actionView($id)
    {
        return [
            'model' => $this->findModel($id),
        ];
    }

    public function actionCreate()
    {
        $model = new Lesson();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return ['view', 'id' => $model->id];
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }


    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $out = ['model' => $model, 'success' => false, 'errors' => $model->getErrors()];
        } else {
            $out = ['model' => $model, 'success' => true];
        }

        return $out;
    }

    public function actionDelete($id)
    {
        return ['result' => $this->findModel($id)->delete()];
    }


    protected function findModel($id)
    {
        if (($model = Lesson::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }


    public function actionGetbystudent()
    {
        $studentId = Yii::$app->request->get('student_id', null);
        $page = Yii::$app->request->get('page', 0);
        $limit = Yii::$app->request->get('limit', self::LESSONS_LIMIT);

        if (null === $studentId) {
            $out = ['classes' => [], 'success' => false];
        } else {
            $service = new DataService();
            $classes = $service->getLessonsByStudent($studentId, $page, $limit);

            $out = ['classes' => $classes, 'success' => true];
        }

        return $out;
    }

    public function actionGetdailyclassesbygroup()
    {
        $group = Yii::$app->request->get('group', null);
        $page = Yii::$app->request->get('page', 0);
        $limit = Yii::$app->request->get('limit', self::LESSONS_LIMIT);

        if (null === $group) {
            $out = ['classes' => [], 'success' => false];
        } else {
            $service = new DataService();
            $classes = $service->getDailyScheduleByGivenClass($group, $page, $limit);

            $out = ['classes' => $classes, 'success' => true];
        }

        return $out;
    }
}
