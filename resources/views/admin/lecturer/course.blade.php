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
    <div class="col-md-8">
        <div class="panel panel-white">
            <div class="panel-heading clearfix">
                <h4 class="panel-title">Lecturer Courses</h4>
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
                            <tr>
                                <td colspan="6" style="font-size:14px; font-family:Trebuchet MS;"><center>No Record Found </center></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="row">
                    
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        

    </div>
</div><!-- Row -->
@endsection