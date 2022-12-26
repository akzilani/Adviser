@extends('backEnd.masterPage')
@section('mainPart')    
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-6">Add Footer Menu</div>
                        <div class="col-6 text-right"> 
                            <a href="{{ url()->previous() }}" class="btn btn-info btn-sm">&larr; Back</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    {!! Form::open(['method'=>'post','url'=>'footer-menu/create','class'=>'from-control','files'=>true]) !!}                        
                        <div class="row">
                            <!-- Menu Name -->
                            <div class="col-12 col-sm-6 col-md-3">
                                <div class="form-group">
                                    <label>Menu Name</label>
                                    <input name="id" type="hidden" value="{{isset($data->id)?$data->id:null}}">
                                    <input type="text" name="menuName" value="{{isset($data->id)?$data->menuName:''}}" class="form-control" required >
                                </div>
                            </div>

                            <!-- Menu Name -->
                            <div class="col-12 col-sm-6 col-md-3">
                                <div class="form-group">
                                    <label>Display in Div</label>
                                    <input type="number" name="show" value="{{isset($data->id)?$data->show:'1'}}" min="1" max="3" class="form-control" required >
                                </div>
                            </div>

                            <!-- Menu Name -->
                            <div class="col-12 col-sm-6 col-md-3">
                                <div class="form-group">
                                    <label>Display Position</label>
                                    <input type="number" name="position" value="{{isset($data->id)?$data->position:'1'}}" min="1" max="100" class="form-control" required >
                                </div>
                            </div>

                            <!-- Publication Status -->
                            <div class="col-12 col-sm-6 col-md-3">
                                <div class="form-group">
                                    <label>Publication Status</label>
                                    <select name="publicationStatus" class="form-control" required>
                                        <option value="" selected> Select Publication Status </option>
                                        <option value="1" {{isset($data->id) &&  $data->publicationStatus == 1?'selected':''}}> Published </option>
                                        <option value="0" {{isset($data->id) &&  $data->publicationStatus == 0?'selected':''}}> Unpublished </option>
                                    </select>
                                </div>
                            </div>

                            <!-- content -->
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Page Content</label>
                                    <textarea name="content" class="form-control" id="editor" > {{isset($data->id)?$data->content:''}} </textarea>
                                </div>
                            </div>
                            <!-- content -->
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Image : </label>
                                    <input type="file" name="image" accept="image/png,image/jpeg" />
                                </div>
                            </div>
                            <div class="col-12">                                    
                                <div class="form-group">
                                    <button class="form-control btn btn-primary">Save Information</button>
                                </div>
                            </div>
                        </div>
                    {!! Form::close() !!}
                </div>                
            </div>
        </div>        
    </div>

@endsection