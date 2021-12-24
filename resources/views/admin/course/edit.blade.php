@extends('layouts.master')

@section('breadcrumb')
<div class="page-breadcrumb">
    <ol class="breadcrumb container">
        <li><a href="{{ url('/') }}">Home</a></li>
        <li class="active">Course</li>
    </ol>
</div>

@endsection

@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="panel panel-white">
            <div class="panel-heading clearfix">
                <h4 class="panel-title">Update Course</h4>
            </div>
            <div class="panel-body">
                <form action="{{ route('admin.course.update', $course) }}" method="POST" autocomplete="off">
                    @csrf
                    {{ method_field('PUT') }}
                    <div class="form-group">
                        <label for="exampleInputEmail1">Department</label>
                        <select name="department_id" class="form-control">
                            <option value="{{ $course->department_id }}">{{ $course->department->name }}</option>
                            @foreach ($departments as $key => $value)
                                <option value="{{ $key }}" {{ (old('department_id') == $key) ? 'selected':'' }}> {{ $value }} </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Course Code</label>
                        <input type="text" name="code" class="form-control" value="{{ $course->code}}">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Course Name</label>
                        <input type="text" name="name" class="form-control" value="{{ $course->name}}">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Unit</label>
                        <input type="text" name="unit" class="form-control" value="{{ $course->units}}">
                    </div>
                    <a href="{{ route('admin.course.index') }}" class="btn btn-default">Back</a>
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        
    </div>
</div><!-- Row -->
@endsection