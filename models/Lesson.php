<?php

namespace app\models;

use backend\modules\admin\models\StudentToLesson;
use Yii;

/**
 * This is the model class for table "classes".
 *
 * @property int $id
 * @property string $name
 * @property string $room
 * @property int $day
 * @property string $starting_hours
 *
 * @property StudentsClasses[] $studentsClasses
 * @property Students[] $students
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
    public function getStudentsClasses()
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
