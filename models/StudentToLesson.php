<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "students_classes".
 *
 * @property int $id
 * @property int $student_id
 * @property int $class_id
 */
class StudentToLesson extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'students_classes';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['student_id', 'class_id'], 'required'],
            [['student_id', 'class_id'], 'integer'],
            [
                ['student_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Student::className(),
                'targetAttribute' => ['student_id' => 'id']
            ],
            [
                ['class_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Lesson::className(),
                'targetAttribute' => ['class_id' => 'id']
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            ['class' => TimestampBehavior::className()]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'student_id' => 'Student ID',
            'class_id' => 'Class ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStudent()
    {
        return $this->hasOne(Student::className(), ['id' => 'student_id'])->inverseOf('studentToLesson');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLesson()
    {
        return $this->hasOne(Lesson::className(), ['id' => 'class_id'])->inverseOf('studentToLesson');
    }
}
