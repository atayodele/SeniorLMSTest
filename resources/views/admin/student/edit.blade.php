@extends('layouts.master')

@section('breadcrumb')
<div class="page-breadcrumb">
    <ol class="breadcrumb container">
        <li><a href="{{ url('/') }}">Home</a></li>
        <li class="active">Student</li>
    </ol>
</div>

@endsection

@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="panel panel-white">
            <div class="panel-heading clearfix">
                <h4 class="panel-title">Update Student</h4>
            </div>
            <div class="panel-body">
                <form action="{{ route('admin.student.update', $student) }}" method="POST" autocomplete="off">
                    @csrf
                    {{ method_field('PUT') }}
                    <div class="form-group">
                        <label for="exampleInputEmail1">Department</label>
                        <select name="department_id" class="form-control">
                            <option value="{{ $student->department_id }}">{{ $student->department->name }}</option>
                            @foreach ($departments as $key => $value)
                                <option value="{{ $key }}" {{ (old('department_id') == $key) ? 'selected':'' }}> {{ $value }} </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Registration Number</label>
                        <input type="text" name="regNo" class="form-control" id="exampleInputEmail1" value="{{ $student->RegNo }}">
                        <input type="hidden" name="userId" value="{{ $student->user_id }}">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">First Name</label>
                        <input type="text" name="fname" class="form-control" id="exampleInputEmail1" value="{{ $student->user->fname }}">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Last Name</label>
                        <input type="text" name="lname" class="form-control" id="exampleInputEmail1" value="{{ $student->user->lname }}">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Email</label>
                        <input type="email" name="email" class="form-control" id="exampleInputEmail1" value="{{ $student->user->email }}" readonly>
                    </div>
                    <a href="{{ route('admin.student.index') }}" class="btn btn-default">Back</a>
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        
    </div>
</div><!-- Row -->
@endsection