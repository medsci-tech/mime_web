<?php

namespace App\Helpers\Statistics;

use App\Models\ThyroidClass\ThyroidClassCourse;
use App\Models\ThyroidClassPhase;

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
        $phase = ThyroidClassPhase::find($course->thyroid_class_phase_id);
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