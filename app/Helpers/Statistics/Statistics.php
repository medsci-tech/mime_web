<?php

namespace App\Helpers\Statistics;

use App\Models\ThyroidClass\ThyroidClassCourse;

/**
 * Class Statistics
 * @package App\Helpers\Statistics
 */
class Statistics
{
    /**
     * @param $course
     */
    protected function updateCourseCount($course)
    {
        $course->play_count += 1;
        $course->save();
    }

    protected function updatePhaseCount($course)
    {
        $phase = $course->thyroidClassPhase;
        $phase->play_count += 1;
        $phase->save();
    }

    public function updateCount($courseId)
    {
        $course = ThyroidClassCourse::find($courseId);
        $this->updateCourseCount($course);
        $this->updatePhaseCount($course);
    }
} /*class*/