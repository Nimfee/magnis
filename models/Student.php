<?php

namespace app\models;

use backend\modules\admin\models\StudentToLesson;
use Yii;

/**
 * This is the model class for table "students".
 *
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property int $age
 * @property int $group
 *
 * @property StudentsClasses[] $studentsClasses
 * @property Classes[] $classes
 */
class Student extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'students';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['first_name', 'last_name', 'age', 'group'], 'required'],
            [['age', 'group'], 'integer'],
            [['first_name', 'last_name'], 'string', 'max' => 255],
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
            'age' => 'Age',
            'group' => 'Group',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStudentsClasses()
    {
        return $this->hasMany(StudentToLesson::className(), ['student_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClasses()
    {
        return $this->hasMany(Classes::className(), ['id' => 'class_id'])->viaTable('students_classes', ['student_id' => 'id']);
    }
}
