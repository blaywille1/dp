<?php
// BAD
$student_obj = new Student();
$teacher_obj = new Teacher();
$classroom_obj = new Classroom($student_obj, $teacher_obj);

// GOOD
class Classroom_Factory {
    public static function get_instance() {
        $student_obj = new Student();
        $teacher_obj = new Teacher();
        return new Classroom($student_obj, $teacher_obj);
    }
}

$classroom_obj = Classroom_Factory::get_instance();
