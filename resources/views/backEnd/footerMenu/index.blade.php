@extends('backEnd.masterPage')
@section('mainPart')    
    <div class="row">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-6">Footer Menu</div>
                    <div class="col-6 text-right"> 
                        <a href="{{url('footer-menu/create')}}" class="btn btn-info btn-sm"> + Add Page</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="col-12 table-responsive">
                    <table class="table table-responsive table-striped">
                        <tr class=" bg-primary">
                            <td>Sn.</td>
                            <td>Menu Name</td>
                            <td>Image</td>
                            <td>Show In Div</td>
                            <td>Position</td>
                            <td>Publication Status</td>
                            <td>Action</td>
                        </tr>
                        @foreach($data as $menu)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{$menu->menuName}}</td>
                            <td> <img src="{{asset($menu->image)}}" width="60" height="30" alt="Image"> </td>
                            <td> {{ $menu->show }} </td>
                            <td> {{ $menu->position }} </td>
                            <td>{{$menu->publicationStatus == 1?'Publiahed':'Unpublished'}}</td>
                            <td>
                                <a href="{{url('footer-menu/edit/'.$menu->id)}}" class="btn btn-info"><span class="fa fa-edit"></span></a>
                                <a href="{{url('footer-menu/delete/'.$menu->id)}}" class="btn btn-danger" onclick="return confirm('Are you sure to delete???')"><span class="fa fa-trash"></span></a>
                            </td>
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>        
    </div>

@endsection
