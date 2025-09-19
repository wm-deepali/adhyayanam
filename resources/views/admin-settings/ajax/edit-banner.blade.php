@extends('layouts.app')

@section('title')
Edit|Banner Setting
@endsection

@section('content')
<div class="bg-light rounded p-3">
    <div class="card">
        <div class="card-body">
            <div class="d-flex">
                <div class="col">
                    <h5 class="card-title">Edit|Banner Setting</h5>
                    <h6 class="card-subtitle mb-2 text-muted">Edit Banner Setting</h6>
                </div>
            </div>
            <div class="mt-2">
                @include('layouts.includes.messages')
            </div>
            <form method="POST" action="{{ route('settings.banner.update') }}" id="header-form" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <p class="mb-0">Please upload image size <span class="text-danger">1366px*509px </span> for the better view. <span class="text-danger">(Maximum Image weight 200KB) </span></p>
                                <div class="custom-img-uploader mt-2">
                                    <div class="input-group">
                                        <span class="input-group-btn">
                                            <span class="btn-file">
                                                <input type="file" name="image" id="imgSec">
                                                <img id='upload-img' style="max-width:240px" class="img-upload-block" src="{{ asset('storage/'.$banner->image) }}" />
                                            </span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input type="text" name="id" value="{{$banner->id}}" style="display:none">
                        <div class="col-md-12 mt-2">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Select Banner Position</label>
                                        <select class="form-control" name="position" required="">
                                            <option value="1" {{$banner->position==1 ? 'selected':''}}>1</option>
                                            <option value="2" {{$banner->position==2 ? 'selected':''}}>2</option>
                                            <option value="3" {{$banner->position==3 ? 'selected':''}}>3</option>
                                            <option value="4" {{$banner->position==4 ? 'selected':''}}>4</option>
                                            <option value="5" {{$banner->position==5 ? 'selected':''}}>5</option>
                                            <option value="6" {{$banner->position==6 ? 'selected':''}}>6</option>
                                            <option value="7" {{$banner->position==7 ? 'selected':''}}>7</option>
                                            <option value="8" {{$banner->position==8 ? 'selected':''}}>8</option>
                                            <option value="9" {{$banner->position==9 ? 'selected':''}}>9</option>
                                            <option value="10" {{$banner->position==10 ? 'selected':''}}>10</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Banner Name</label>
                                        <input type="text" class="form-control" name="name" placeholder="Banner Name" value="{{$banner->name ?? ''}}" required="" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-4" id="manage_button_url">
                            <div class="form-group">
                                <label>Slider / Banner Link</label>
                                <input type="text" class="form-control" name="link" placeholder="Enter Button Link...." value="{{$banner->link ?? ''}}">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 mt-2">
                        <button class="btn btn-primary waves-effect waves-float waves-light" type="submit">Add Banner</button>
                    </div>
                </form>
        </div>
    </div>
</div>
@endsection
