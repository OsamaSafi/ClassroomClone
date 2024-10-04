@extends('layouts.parent')

@section('title','Create Classrooms')
@section('main_title','Create Classrooms')
@section('breadcrumb_start_title','Classrooms')
@section('breadcrumb_end_title','Create')

@push('styles')
@endpush

@section('content')
    <div class="col-md-12">
        <!-- general form elements -->
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Create Classroom</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form>
                <div class="card-body">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" placeholder="Enter name">
                    </div>
                    <div class="form-group">
                        <label for="subject">subject</label>
                        <input type="text" class="form-control" id="subject" placeholder="Enter subject">
                    </div>
                    <div class="form-group">
                        <label for="section">section</label>
                        <input type="text" class="form-control" id="section" placeholder="Enter section">
                    </div>
                    <div class="form-group">
                        <label for="room">room</label>
                        <input type="text" class="form-control" id="room" placeholder="Enter room">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputFile">File input</label>
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="exampleInputFile">
                                <label class="custom-file-label" for="exampleInputFile">Choose cover image</label>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
        <!-- /.card -->



    </div>


@endsection

@push('scripts')

@endpush
