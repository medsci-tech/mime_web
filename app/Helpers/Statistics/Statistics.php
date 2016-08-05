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
        $course->thyroidClassPhase->play_count += 1;
        $course->save();
    }

    public function updateCount($courseId)
    {
        $course = ThyroidClassCourse::find($courseId);
        $this->updatePhaseCount($course);
        $this->updatePhaseCount($course);
    }
} /*class*/