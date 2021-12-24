@extends('layouts.master')

@section('breadcrumb')
<div class="page-breadcrumb">
    <ol class="breadcrumb container">
        <li><a href="{{ url('/') }}">Home</a></li>
        <li class="active">Department</li>
    </ol>
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-white">
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-6">
                        <button type="button" class="btn btn-success btn-addon m-b-sm btn-rounded" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus"></i>Add New Department</button>
                    </div>
                    <div class="col-md-6">

                    </div>
                </div>
                <!-- Modal -->
                <form id="add-row-form" action="{{ route('admin.dept.store') }}" method="POST" autocomplete="off">
                    @csrf
                    {{ method_field('POST') }}
                    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title" id="myModalLabel">Create Department</h4>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Department Name</label>
                                        <input type="text" name="dept_name" class="form-control" id="exampleInputEmail1" value="{{ old('dept_name') }}">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-success">Add</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <!-- Modal -->
                <div class="table-responsive">
                    <table id="example" class="display table" style="width: 100%; cellspacing: 0;">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Department Name</th>
                                <th>Created</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($departments) > 0)
                                @foreach ($departments as $dept)
                                <tr>
                                    <td>{{ ($departments ->currentpage()-1) * $departments ->perpage() + $loop->index + 1 }}</td>
                                    <td>{{ ucfirst($dept->name) }}</td>
                                    <td>{{ $dept->created_at->diffForHumans() }}</td>
                                    <td>
                                        @can('editOrDelete')
                                            <a href="{{ route('admin.dept.edit', $dept->id) }}"><button class="btn btn-primary"><i class="fa fa-eye font-14"></i></button></a> | 
                                            <button type="button" data-id={{$dept->id}} class="btn btn-danger" data-toggle="modal" data-target="#exampleModal"><i class="fa fa-trash"></i></button>
                                        @endcan
                                    </td>
                                </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="4" style="font-size:14px; font-family:Trebuchet MS;"><center>No Record Found </center></td>
                                </tr>
                            @endif
                        </tbody>
                    </table>  
                </div>
                <div class="row">
                    <div class="col-md-6">
                        Showing 
                        {{($departments->currentpage()-1)*$departments->perpage()+1}} to 
                        {{$departments->currentpage()*$departments->perpage()}} of
                        {{$departments->total()}} entries
                    </div>
                    <div class="col-md-6">
                        <span class="pull-right">
                            {{ $departments->links() }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div><!-- Row -->
<!-- Delete Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.dept.destroy', 'delete') }}" method="post">
                {{ csrf_field() }}
                {{method_field('DELETE')}}
                <div class="modal-body text-center py-5">
                    <div class="modal-icon">
                        <i style="font-size: 150px; color:red;" class="fa fa-times-circle"></i>
                    </div>
                    <input type="hidden" name="id" id="id" value="">
                    <div class="add-body pt-3">
                        <p class="text-success mb-0">Are you sure?</p>
                        <p class="p-success">You won't be able to revert this!</p>
                    </div>
                    <div class="">
                        <button type="button" class="btn btn-success" data-dismiss="modal">No, cancel!</button> |
                        <button type="submit" class="btn btn-success">Yes, delete it!</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Delete Modal -->
<script src="{{ asset('assets/js/jquery.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('#exampleModal').on('show.bs.modal', function (e) {
            var button = $(e.relatedTarget);
            var cat_id = button.data('id');
            var modal = $(this);
            modal.find('.modal-body #id').val(cat_id);
        });
    });
</script>
@endsection