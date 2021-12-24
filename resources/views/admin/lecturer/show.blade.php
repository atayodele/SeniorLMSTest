@extends('layouts.master')

@section('breadcrumb')
<div class="page-breadcrumb">
    <ol class="breadcrumb container">
        <li><a href="{{ url('/') }}">Home</a></li>
        <li class="active">Lecturer</li>
    </ol>
</div>

@endsection

@section('content')
<div class="row">
    <div class="col-md-5">
        <div class="panel panel-white">
            <div class="panel-heading clearfix">
                <h4 class="panel-title">Lecturer Courses</h4>
            </div>
            <div class="panel-body">
                <form action="{{ route('add_to_course') }}" method="POST" autocomplete="off">
                    @csrf
                    {{ method_field('POST') }}
                    <div class="form-group">
                        <label for="exampleInputEmail1">Session</label>
                        <select name="session_id" class="form-control">
                            <option value="0">Select Session</option>
                            @foreach ($sessions as $key => $value)
                                <option value="{{ $key }}" {{ (old('session_id') == $key) ? 'selected':'' }}> {{ $value }} </option>
                            @endforeach
                        </select>
                    </div>
                    <input type="hidden" name="lecturerId" value="{{ $lecturer->id }}">
                    <a href="{{ route('admin.lecturer.index') }}" class="btn btn-default">Back</a>
                    <button type="submit" class="btn btn-primary">Register Student for Course</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-7">
        <div class="panel panel-white">
            <div class="panel-heading clearfix">
                <h4 class="panel-title">Lecture Courses for <font color='red'>{{ $lecturer->user->lname }} {{ $student->lecturer->fname }}</font></h4>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table id="example" class="display table" style="width: 100%; cellspacing: 0;">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Session</th>
                                <th>Semester</th>
                                <th>Course</th>
                                <th>Level</th>
                                <th>Student</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($studentCourses) > 0)
                                @foreach ($studentCourses as $std)
                                <tr>
                                    <td>{{ ($studentCourses ->currentpage()-1) * $studentCourses ->perpage() + $loop->index + 1 }}</td>
                                    <td>{{ ucfirst($std->sessionName) }}</td>
                                    <td>{{ $std->semesterName }}</td>
                                    <td>{{ $std->courseName }}</td>
                                    <td>{{ $std->levelName }}</td>
                                </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="5" style="font-size:14px; font-family:Trebuchet MS;"><center>No Record Found </center></td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        Showing
                        {{($studentCourses->currentpage()-1)*$studentCourses->perpage()+1}} to
                        {{$studentCourses->currentpage()*$studentCourses->perpage()}} of
                        {{$studentCourses->total()}} entries
                    </div>
                    <div class="col-md-6">
                        <span class="pull-right">
                            {{ $studentCourses->links() }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div><!-- Row -->
@endsection