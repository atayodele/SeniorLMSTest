@extends('layouts.master')

@section('breadcrumb')
<div class="page-breadcrumb">
    <ol class="breadcrumb container">
        <li><a href="{{ url('/') }}">Home</a></li>
        <li class="active">Level</li>
    </ol>
</div>

@endsection

@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="panel panel-white">
            <div class="panel-heading clearfix">
                <h4 class="panel-title">Update Level</h4>
            </div>
            <div class="panel-body">
                <form action="{{ route('admin.level.update', $level) }}" method="POST" autocomplete="off">
                    @csrf
                    {{ method_field('PUT') }}
                    <div class="form-group">
                        <label for="exampleInputEmail1">Level Name</label>
                        <input type="text" name="level_name" class="form-control" value="{{ $level->name}}">
                    </div>
                    <a href="{{ route('admin.level.index') }}" class="btn btn-default">Back</a>
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        
    </div>
</div><!-- Row -->
@endsection