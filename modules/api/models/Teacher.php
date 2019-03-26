<?php

namespace app\modules\api\models;

use Yii;

/**
 *@OA\Schema(
 *  schema="Teacher",
 *  @OA\Property(
 *     property="first_name",
 *     type="string",
 *     description="First name"
 *  ),
 *  @OA\Property(
 *     property="last_name",
 *     type="string",
 *     description="Last name"
 *  ),
 *  @OA\Property(
 *     property="age",
 *     type="integer",
 *     description="Age"
 *  ),
 *  @OA\Property(
 *     property="job_title",
 *     type="string",
 *     description="Job title"
 *  )
 *)
 */
/**
 * This is the model class for table "teachers".
 *
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string $job_title
 * @property integer $age
 */
class Teacher extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'teachers';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['first_name', 'last_name', 'job_title', 'age'], 'required'],
            [['first_name', 'last_name', 'job_title'], 'string', 'max' => 255],
            [['age'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'job_title' => 'Job Title',
            'age' => 'Age',
        ];
    }
}
