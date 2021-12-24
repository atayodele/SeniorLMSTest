<?php

namespace App\Traits;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use App\Course;

trait MyDataTrait{

    public function paginate($items, $perPage = 10, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, ['path' => request()->url()]);
    }

    public function getDepartments()
    {
        return DB::table('departments')->pluck("name", "id");
    }

    public function UpdateUserRecord($userId, $fname, $lname)
    {
        $update = DB::select("UPDATE `users` SET fname='$fname', lname='$lname' WHERE id='$userId'");
       return $update;
    }

    public function GetSessions()
    {
        return DB::table('sessions')->pluck("name", "id");
    }

    public function GetSemester()
    {
        return DB::table('semesters')->pluck("name", "id");
    }

    public function GetLevels()
    {
        return DB::table('levels')->pluck("name", "id");
    }    

    public function GetCourses()
    {
        return  Course::select(
                DB::raw("CONCAT(code,' - ',name) AS name"),'id')
                ->pluck('name', 'id');
    }

    public function GetStudentId($id)
    {
        return DB::table("students")
                        ->where("user_id", "=", $id)
                        ->first();
    }

    public function CourseRegistrationList($id)
    {
        return DB::select(
            "SELECT
                cr.id as id, ss.name as sessionName, l.name as levelName,
                s.name as semesterName, c.name as courseName
            FROM
                course_registrations as cr
                JOIN sessions ss ON ss.id = cr.session_id
                JOIN semesters s ON s.id = cr.semester_id
                JOIN courses c ON c.id = cr.course_id
                JOIN levels l ON l.id = cr.level_id
            WHERE cr.student_id=$id
            ORDER BY cr.created_at DESC"
        );
    }

    public function LecturerCourseList($id)
    {
        return DB::select(
            "SELECT
                cr.id as id, ss.name as sessionName, l.name as levelName,
                s.name as semesterName, c.name as courseName
            FROM
                course_registration_lecturers as crl
                JOIN course_registrations cr ON cr.id = crl.course_registration_id
                JOIN sessions ss ON ss.id = cr.session_id
                JOIN semesters s ON s.id = cr.semester_id
                JOIN courses c ON c.id = cr.course_id
                JOIN levels l ON l.id = cr.level_id
            WHERE crl.lecturer_id=$id
            ORDER BY crl.created_at DESC"
        );
    }
}