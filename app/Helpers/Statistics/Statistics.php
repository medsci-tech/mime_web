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
    protected function updateCourseCount($courseId)
    {
        $course = ThyroidClassCourse::find($courseId);
        $course->play_count += 1;
        $course->save();
    }

    protected function updatePhaseCount($courseId)
    {
        $course = ThyroidClassCourse::find($courseId);
        $phase = ThyroidClassPhase::find($course->phase_id)->play_count += 1;
        $phase->save();
    }

    public function updateCount($courseId)
    {
        $this->updateCourseCount($courseId);
        $this->updatePhaseCount($courseId);
    }
} /*class*/