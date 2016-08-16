<?php

namespace App\Helpers\Statistics;

use App\Models\PlayLog;
use App\Models\ThyroidClassCourse;

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

    public function updateCount($courseId, $date)
    {
        $course = ThyroidClassCourse::find($courseId);
        $this->updateCourseCount($course);
        $this->updatePhaseCount($course);

        $studentId = \Session::get('studentId');
        $playLog = PlayLog::where('student_id',  $studentId)->where('thyroid_class_course_id', $courseId)->first();
        $logId = 'student_course_id:' . $studentId.'-'.$course->id;
        if($playLog) {
            if (!\Redis::command('HEXISTS', [$logId, $date])) {
                \Redis::command('HSET', [$logId, $date, 0]);
                $playLog->play_times += 1;
                $playLog->save();
            }
        } else {
            $logData = [
                'student_id' => $studentId,
                'teacher_id' => $course->teacher_id,
                'thyroid_class_phase_id' => $course->thyroidClassPhase->id,
                'thyroid_class_course_id' => $course->id,
                'play_times' => 1,
                'play_duration' =>  30,
                'student_course_id' =>  $studentId.'-'.$course->id
            ];
            PlayLog::create($logData);

            if (!\Redis::command('HEXISTS', [$logId, $date])) {
                \Redis::command('HSET', [$logId, $date, 0]);
            }
        }
    }

    function getClickedAt($logId, &$date) {
        if (\Redis::command('HEXISTS', [$logId, $date])) {
            $date = date('Y-m-d H:i:s',strtotime('+1 second',strtotime($date)));;
            $this->getClickedAt($logId, $date);
        } else {
            return;
        }
    }
} /*class*/