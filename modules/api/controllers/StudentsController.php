<?php

namespace app\modules\api\controllers;

use app\modules\api\components\DataService;
use Yii;
use app\modules\api\models\Student;
use yii\rest\ActiveController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * StudentsController implements the CRUD actions for Student model.
 */
class StudentsController extends ActiveController
{
    const STUDENTS_LIMIT = 10;

    public $modelClass = 'app\modules\api\models\Student';

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['verbs'] = [
            'class'   => yii\filters\VerbFilter::className(),
                'actions' => [
                    'getByClass' => ['GET'],
                    'all' => ['GET', 'POST'],
                    'update' => ['PUT', 'PATCH'],
                    'create' => ['POST'],
                ],
        ];

        return $behaviors;
    }

    /**
     * @OA\Get(path="/students",
     *   summary="students",
     *   tags={"students"},
     *   @OA\Response(
     *     response=200,
     *     description="Returns Hello object",
     *     @OA\MediaType(
     *         mediaType="application/json",
     *         @OA\Schema(ref="#/components/schemas/Student"),
     *     ),
     *   ),
     * )
     */

    /**
     * @OA\Get(
     *   path="/students/{id}",
     *   summary="students",
     *   tags={"students"},
     *   @OA\Parameter(name="id",
     *     in="path",
     *     required=true,
     *     @OA\Schema(type="integer")
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Returns Hello object",
     *     @OA\MediaType(
     *         mediaType="application/json",
     *         @OA\Schema(ref="#/components/schemas/Student"),
     *     ),
     *   ),
     * )
     */

    /**
     * @OA\Patch(
     *   path="/students/{id}",
     *   summary="students",
     *   tags={"students"},
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
     *                   property="first_name",
     *                   description="Updated name of the student",
     *                   type="string"
     *               ),
     *               @OA\Property(
     *                   property="last_name",
     *                   description="Updated name of the student",
     *                   type="string"
     *               ),
     *               @OA\Property(
     *                   property="age",
     *                   description="Updated room of the student",
     *                   type="integer"
     *               ),
     *               @OA\Property(
     *                   property="group",
     *                   description="Updated room of the student",
     *                   type="integer"
     *               ),
     *           )
     *       )
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Returns Hello object",
     *     @OA\MediaType(
     *         mediaType="application/json",
     *         @OA\Schema(ref="#/components/schemas/Student"),
     *     ),
     *   ),
     * )
     */

    /**
     * @OA\Post(
     *   path="/students",
     *   summary="students",
     *   tags={"students"},
     *   @OA\RequestBody(
     *       required=false,
     *       @OA\MediaType(
     *           mediaType="application/json",
     *           @OA\Schema(
     *               type="object",
     *               @OA\Property(
     *                   property="first_name",
     *                   description="Updated name of the student",
     *                   type="string"
     *               ),
     *               @OA\Property(
     *                   property="last_name",
     *                   description="Updated name of the student",
     *                   type="string"
     *               ),
     *               @OA\Property(
     *                   property="age",
     *                   description="Updated room of the student",
     *                   type="integer"
     *               ),
     *               @OA\Property(
     *                   property="group",
     *                   description="Updated room of the student",
     *                   type="integer"
     *               ),
     *           )
     *       )
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Returns Hello object",
     *     @OA\MediaType(
     *         mediaType="application/json",
     *         @OA\Schema(ref="#/components/schemas/Student"),
     *     ),
     *   ),
     * )
     */

    /**
     * @OA\Delete(
     *     path="/students/{id}",
     *     summary="Deletes a student",
     *     description="",
     *     tags={"students"},
     *     @OA\Parameter(
     *         description="Student id to delete",
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
     *         description="Student not found"
     *     )
     * )
     */
    /**
     * Finds the Student model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Student the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Student::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }


    /**
     * @OA\Get(path="/students/getbyclass",
     *   summary="students",
     *   tags={"students"},
     *   @OA\Parameter(name="class_id",
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
     *     description="Returns Student object",
     *     @OA\MediaType(
     *         mediaType="application/json",
     *         @OA\Schema(ref="#/components/schemas/Student"),
     *     ),
     *   ),
     * )
     */
    public function actionGetbyclass()
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;

        $out = ['students' => [], 'success' => false];
        $classId = Yii::$app->request->get('class_id', null);
        $page = Yii::$app->request->get('page', 0);
        $limit = Yii::$app->request->get('limit', self::STUDENTS_LIMIT);
        $service = new DataService();
        $students = $service->getStudentsByLesson($classId, $page, $limit);
        $out['students'] = $students;
        $out['success'] = true;

        return $out;
    }

    /**
     * @OA\Get(path="/students/getbygroup",
     *   summary="students",
     *   tags={"students"},
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
     *     description="Returns Student object",
     *     @OA\MediaType(
     *         mediaType="application/json",
     *         @OA\Schema(ref="#/components/schemas/Student"),
     *     ),
     *   ),
     * )
     */
    public function actionGetbygroup()
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;

        $out = ['students' => [], 'success' => false];
        $group = Yii::$app->request->get('group', null);
        $page = Yii::$app->request->get('page', 0);
        $limit = Yii::$app->request->get('limit', self::STUDENTS_LIMIT);
        $service = new DataService();
        $students = $service->getStudentsByGroup($group, $page, $limit);
        $out['students'] = $students;
        $out['success'] = true;

        return $out;
    }
}
