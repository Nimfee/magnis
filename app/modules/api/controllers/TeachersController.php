<?php

namespace app\modules\api\controllers;

use Yii;
use yii\rest\ActiveController;

class TeachersController extends ActiveController
{
    public $modelClass = 'app\modules\api\models\Teacher';

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['verbs'] = [
            'class'   => yii\filters\VerbFilter::className(),
        ];

        return $behaviors;
    }

    /**
     * @OA\Get(path="/teachers",
     *   summary="teachers",
     *   tags={"teachers"},
     *   @OA\Response(
     *     response=200,
     *     description="Returns Teacher object",
     *     @OA\MediaType(
     *         mediaType="application/json",
     *         @OA\Schema(ref="#/components/schemas/Teacher"),
     *     ),
     *   ),
     * )
     */

    /**
     * @OA\Get(
     *   path="/teachers/{id}",
     *   summary="teachers",
     *   tags={"teachers"},
     *   @OA\Parameter(name="id",
     *     in="path",
     *     required=true,
     *     @OA\Schema(type="integer")
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Returns Teacher object",
     *     @OA\MediaType(
     *         mediaType="application/json",
     *         @OA\Schema(ref="#/components/schemas/Teacher"),
     *     ),
     *   ),
     * )
     */

    /**
     * @OA\Patch(
     *   path="/teachers/{id}",
     *   summary="teachers",
     *   tags={"teachers"},
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
     *                   description="Updated first name of the teacher",
     *                   type="string"
     *               ),
     *               @OA\Property(
     *                   property="last_name",
     *                   description="Updated last name of the teacher",
     *                   type="string"
     *               ),
     *               @OA\Property(
     *                   property="age",
     *                   description="Updated age of the teacher",
     *                   type="integer"
     *               ),
     *               @OA\Property(
     *                   property="job_title",
     *                   description="Updated job title of the teacher",
     *                   type="integer"
     *               ),
     *           )
     *       )
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Returns Teacher object",
     *     @OA\MediaType(
     *         mediaType="application/json",
     *         @OA\Schema(ref="#/components/schemas/Teacher"),
     *     ),
     *   ),
     * )
     */

    /**
     * @OA\Post(
     *   path="/teachers",
     *   summary="teachers",
     *   tags={"teachers"},
     *   @OA\RequestBody(
     *       required=false,
     *       @OA\MediaType(
     *           mediaType="application/json",
     *           @OA\Schema(
     *               type="object",
     *               @OA\Property(
     *                   property="first_name",
     *                   description="Set first name of the teacher",
     *                   type="string"
     *               ),
     *               @OA\Property(
     *                   property="last_name",
     *                   description="Set last name of the teacher",
     *                   type="string"
     *               ),
     *               @OA\Property(
     *                   property="age",
     *                   description="Set age of the teacher",
     *                   type="integer"
     *               ),
     *               @OA\Property(
     *                   property="job_title",
     *                   description="Set job title of the teacher",
     *                   type="string"
     *               ),
     *           )
     *       )
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Returns Teacher object",
     *     @OA\MediaType(
     *         mediaType="application/json",
     *         @OA\Schema(ref="#/components/schemas/Teacher"),
     *     ),
     *   ),
     * )
     */

    /**
     * @OA\Delete(
     *     path="/teachers/{id}",
     *     summary="Deletes a teacher",
     *     description="",
     *     tags={"teachers"},
     *     @OA\Parameter(
     *         description="Teacher id to delete",
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
     *         description="Teacher not found"
     *     )
     * )
     */
}
