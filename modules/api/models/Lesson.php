<?php

namespace app\modules\api\models;

use app\modules\api\models\StudentToLesson;
use Yii;

/**
 *@OA\Schema(
 *  schema="Lesson",
 *  @OA\Property(
 *     property="name",
 *     type="string",
 *     description="Name"
 *  ),
 *  @OA\Property(
 *     property="room",
 *     type="string",
 *     description="Room"
 *  ),
 *  @OA\Property(
 *     property="starting_hours",
 *     type="string",
 *     description="Starting hours"
 *  ),
 *  @OA\Property(
 *     property="day",
 *     type="integer",
 *     description="Day"
 *  )
 *)
 */
class Lesson extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'classes';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'room', 'day', 'starting_hours'], 'required'],
            [['day'], 'integer'],
            [['starting_hours'], 'safe'],
            [['name', 'room'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'room' => 'Room',
            'day' => 'Day',
            'starting_hours' => 'Starting Hours',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStudentToLesson()
    {
        return $this->hasMany(StudentToLesson::className(), ['class_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStudents()
    {
        return $this->hasMany(Students::className(), ['id' => 'student_id'])->viaTable('students_classes', ['class_id' => 'id']);
    }
}
