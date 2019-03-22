<?php
/**
 * @author    Oleksandra Kuznetsova
 * @copyright 2019 Start ApS <info@start.dk>
 */

namespace app\models\definitions;

/**
 * @SWG\Definition(required={"name", "room", "day", "starting_hours"})
 *
 * @SWG\Property(property="id", type="integer")
 * @SWG\Property(property="name", type="string")
 * @SWG\Property(property="room", type="string")
 * @SWG\Property(property="day", type="string")
 * @SWG\Property(property="starting_hours", type="string")
 */
class Lesson
{
}