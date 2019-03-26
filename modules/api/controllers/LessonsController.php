<?php

namespace app\modules\api\controllers;

use app\modules\api\components\DataService;
use Yii;
use app\modules\api\models\Lesson;
use yii\web\NotFoundHttpException;
use yii\rest\ActiveController;

class LessonsController extends ActiveController
{
    const LESSONS_LIMIT = 10;

    public $modelClass = 'app\modules\api\models\Lesson';

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
     * @OA\Get(path="/lessons",
     *   summary="lessons",
     *   tags={"lessons"},
     *   @OA\Response(
     *     response=200,
     *     description="Returns Lesson object",
     *     @OA\MediaType(
     *         mediaType="application/json",
     *         @OA\Schema(ref="#/components/schemas/Lesson"),
     *     ),
     *   ),
     * )
     */

    /**
     * @OA\Get(
     *   path="/lessons/{id}",
     *   summary="lessons",
     *   tags={"lessons"},
     *   @OA\Parameter(name="id",
     *     in="path",
     *     required=true,
     *     @OA\Schema(type="integer")
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Returns Lesson object",
     *     @OA\MediaType(
     *         mediaType="application/json",
     *         @OA\Schema(ref="#/components/schemas/Lesson"),
     *     ),
     *   ),
     * )
     */

    /**
     * @OA\Patch(
     *   path="/lessons/{id}",
     *   summary="lessons",
     *   tags={"lessons"},
     *   @OA\Parameter(name="id",
     *     in="path",
     *     required=true,
     *     @OA\Schema(type="integer")
     *   ),
     *   @OA\RequestBody(
     *       required=false,
     *       @OA\MediaType(
     *           mediaType="application/json",
     *           @OA\Schema(
     *               type="object",
     *               @OA\Property(
     *                   property="name",
     *                   description="Updated name of the lesson",
     *                   type="string"
     *               ),
     *               @OA\Property(
     *                   property="room",
     *                   description="Updated room of the lesson",
     *                   type="string"
     *               ),
     *               @OA\Property(
     *                   property="starting_hours",
     *                   description="Updated starting hours of the lesson",
     *                   type="string"
     *               ),
     *               @OA\Property(
     *                   property="day",
     *                   description="Updated day of the lesson",
     *                   type="string"
     *               ),
     *           )
     *       )
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Returns Lesson object",
     *     @OA\MediaType(
     *         mediaType="application/json",
     *         @OA\Schema(ref="#/components/schemas/Lesson"),
     *     ),
     *   ),
     * )
     */

    /**
     * @OA\Post(
     *   path="/lessons",
     *   summary="lessons",
     *   tags={"lessons"},
     *   @OA\RequestBody(
     *       required=false,
     *       @OA\MediaType(
     *           mediaType="application/json",
     *           @OA\Schema(
     *               type="object",
     *               @OA\Property(
     *                   property="name",
     *                   description="Set name of the lesson",
     *                   type="string"
     *               ),
     *               @OA\Property(
     *                   property="room",
     *                   description="Set room of the lesson",
     *                   type="string"
     *               ),
     *               @OA\Property(
     *                   property="starting_hours",
     *                   description="Set room of the lesson",
     *                   type="string"
     *               ),
     *               @OA\Property(
     *                   property="day",
     *                   description="Set room of the lesson",
     *                   type="integer"
     *               ),
     *           )
     *       )
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Returns Lesson object",
     *     @OA\MediaType(
     *         mediaType="application/json",
     *         @OA\Schema(ref="#/components/schemas/Lesson"),
     *     ),
     *   ),
     * )
     */

    /**
     * @OA\Delete(
     *     path="/lessons/{id}",
     *     summary="Deletes a lesson",
     *     description="",
     *     tags={"lessons"},
     *     @OA\Parameter(
     *         description="Lesson id to delete",
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Lesson not found"
     *     )
     * )
     */

    protected function findModel($id)
    {
        if (($model = Lesson::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * @OA\Get(path="/lessons/getbystudent",
     *   summary="lessons",
     *   tags={"lessons"},
     *   @OA\Parameter(name="student_id",
     *     in="query",
     *     required=true,
     *     @OA\Schema(type="integer")
     *   ),
     *   @OA\Parameter(name="page",
     *     in="query",
     *     required=false,
     *     @OA\Schema(type="integer")
     *   ),
     *   @OA\Parameter(name="limit",
     *     in="query",
     *     required=false,
     *     @OA\Schema(type="integer")
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Returns Lesson object",
     *     @OA\MediaType(
     *         mediaType="application/json",
     *         @OA\Schema(ref="#/components/schemas/Lesson"),
     *     ),
     *   ),
     * )
     */
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

    /**
     * @OA\Get(path="/lessons/getdailyclassesbygroup",
     *   summary="lessons",
     *   tags={"lessons"},
     *   @OA\Parameter(name="group",
     *     in="query",
     *     required=true,
     *     @OA\Schema(type="integer")
     *   ),
     *   @OA\Parameter(name="page",
     *     in="query",
     *     required=false,
     *     @OA\Schema(type="integer")
     *   ),
     *   @OA\Parameter(name="limit",
     *     in="query",
     *     required=false,
     *     @OA\Schema(type="integer")
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Returns Lesson object",
     *     @OA\MediaType(
     *         mediaType="application/json",
     *         @OA\Schema(ref="#/components/schemas/Lesson"),
     *     ),
     *   ),
     * )
     */
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
