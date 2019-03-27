<?php
/**
 * @author    Oleksandra Kuznetsova
 * @copyright 2019 Start ApS <info@start.dk>
 */
namespace app\modules\api\components;

use app\modules\api\models\Student;
use app\modules\api\models\Lesson;
use app\modules\api\models\StudentToLesson;

class DataService
{
    /**
     * @param int $classId
     * @param int $page
     * @param int $limit
     *
     * @return array
     */
    public function getStudentsByLesson($classId, $page, $limit)
    {
        $data = StudentToLesson::find()
            ->joinWith('student')
            ->where(['class_id' => $classId])
            ->limit($limit)
            ->offset($limit * ($page - 1))
            ->asArray()
            ->all();

        $result = [];
        if (count($data) > 0) {
            foreach ($data as $value) {
                if (isset($value['student'])) {

                    unset($value['student']['studentToLesson']);
                    $result[] = $value['student'];
                }
            }
        }

        return $result;
    }
    /**
     * @param string $group
     * @param int    $page
     * @param int    $limit
     *
     * @return array
     */
    public function getStudentsByGroup($group, $page, $limit)
    {
        return Student::find()
            ->where(['group' => $group])
            ->limit($limit)
            ->offset($limit * ($page - 1))
            ->asArray()
            ->all();
    }

    /**
     * @param int $studentId
     * @param int $page
     * @param int $limit
     *
     * @return array
     */
    public function getLessonsByStudent($studentId, $page, $limit)
    {
        $data = StudentToLesson::find()
            ->joinWith('lesson')
            ->where(['student_id' => $studentId])
            ->limit($limit)
            ->offset($limit * ($page - 1))
            ->asArray()
            ->all();

        $result = [];
        if (count($data) > 0) {
            foreach ($data as $value) {
                if (isset($value['lesson'])) {

                    unset($value['lesson']['studentToLesson']);
                    $result[] = $value['lesson'];
                }
            }
        }

        return $result;
    }

    /**
     * @param string $group
     * @param int    $page
     * @param int    $limit
     *
     * @return array
     */
    public function getDailyScheduleByGivenClass($group, $page, $limit)
    {
        $data = StudentToLesson::find()
            ->joinWith('lesson')
            ->joinWith('student')
            ->where(['students.group' => $group])
            ->orderBy(['classes.day' => SORT_ASC,'classes.starting_hours' => SORT_ASC])
            ->limit($limit)
            ->offset($limit * ($page - 1))
            ->asArray()
            ->all();

        $result = [];
        if (count($data) > 0) {
            foreach ($data as $value) {
                if (isset($value['lesson'])) {

                    unset($value['lesson']['studentToLesson']);
                    $result[] = $value['lesson'];
                }
            }
        }

        return $result;
    }
}