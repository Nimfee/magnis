<?php

namespace app\controllers;

use app\components\DataService;
use Yii;
use app\models\Student;
use app\models\search\StudentSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * StudentsController implements the CRUD actions for Student model.
 */
class StudentsController extends Controller
{
    const STUDENTS_LIMIT = 10;

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'getByClass' => ['GET'],
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Student models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new StudentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Student model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Student model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Student();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Student model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Student model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

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
     * @return array
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
     * @return array
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
