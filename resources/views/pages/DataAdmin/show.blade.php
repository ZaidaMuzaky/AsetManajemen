@extends('layout.master')
@section('statusadmin','active')
@section('content')
<div class="page-inner">
    <div class="page-header">
        <h4 class="page-title">Admin</h4>
        <ul class="breadcrumbs">
            <li class="nav-home">
                <a href="{{route('dashboard')}}">
                    <i class="flaticon-home"></i>
                </a>
            </li>
            <li class="separator">
                <i class="flaticon-right-arrow"></i>
            </li>
            <li class="nav-item">
                <a href="{{route('admin.index')}}">Admin</a>
            </li>
            <li class="separator">
                <i class="flaticon-right-arrow"></i>
            </li>
            <li class="nav-item">
                <a href="{{route('admin.show', $user->id_user)}}">Detail</a>
            </li>
        </ul>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Detail Admin</div>
                </div>
                <div class="card-body">
                    <div class="tab-content mt-2 mb-3" id="pills-with-icon-tabContent">
                        <div class="tab-pane fade show active" id="pills-home-icon" role="tabpanel" aria-labelledby="pills-home-tab-icon">
                            <div class="row">
                                <!-- Foto -->
                                <div class="col-3">
                                    <div class="card">
                                        <div class="card-header" style="font-weight: bold;">Foto Data Admin</div>
                                        <div class="card-body bg-grey1">
                                            @if(empty($user->foto))
                                            <img src="{{ asset('img/avatar.png')}}" alt="image profile" class="avatar-img img-responsive rounded">
                                            @else
                                            <img src="{{ Storage::url($user->foto)}}" alt="image profile" class="avatar-img img-responsive rounded">
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-9">
                                    <div class="form-group form-inline">
                                        <label for="nip" class="col-md-4 col-form-label">Username</label>
                                        <div class="col-md-8 p-0">
                                            <input type="text" value="{{$user->nama}}" class="form-control input-full" id="nama" style="background-color:#E5EBFF;color: black;" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group form-inline">
                                        <label for="nama" class="col-md-4 col-form-label">Email</label>
                                        <div class="col-md-8 p-0">
                                            <input type="text" value="{{$user->email}}" class="form-control input-full" id="email" style="background-color:#E5EBFF; color: black;" disabled style="background-color:#E5EBFF;color: black;" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group form-inline">
                                        <label for="inlineinput" class="col-md-4 col-form-label">Tipe
                                            User</label>
                                        <div class="col-md-8 p-0">
                                            <input type="text" value="{{$user->tipe_user}}" class="form-control input-full" id="inlineinput" style="background-color:#E5EBFF; color: black;" disabled style="background-color:#E5EBFF;
																color: black;" disabled>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-action">
                <a class="btn btn-danger" href="{{route('admin.index')}}">Kembali</a>
            </div>
        </div>
    </div>
</div>
@endsection