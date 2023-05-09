<nav class="navbar navbar-header navbar-expand-lg" data-background-color="blue2">
    <div class="container-fluid">
        <ul class="navbar-nav topbar-nav ml-md-auto align-items-center">
            <li class="nav-item dropdown hidden-caret">
                <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="false">
                    <i class="fas fa-grip-horizontal"></i>
                </a>
                <div class="dropdown-menu quick-actions quick-actions-info animated fadeIn">
                    <div class="quick-actions-header">
                        <span class="title mb-1">Pintasan</span>
                        <span class="subtitle op-8">Penambahan</span>
                    </div>
                    {{-- <div class="quick-actions-scroll scrollbar-outer">
                        <div class="quick-actions-items">
                            <div class="row m-0">
                                <a class="col-6 col-md-4 p-0" href="{{ route('Karyawan.create') }}">
                                    <div class="quick-actions-item">
                                        <i class="fas fa-user-friends"></i>
                                        <span class="text">Tambah Data Karyawan</span>
                                    </div>
                                </a>
                                <a class="col-6 col-md-4 p-0" href="{{ route('Keluarga.create') }}">
                                    <div class="quick-actions-item">
                                        <i class="fas fa-home"></i>
                                        <span class="text">Tambah Data Keluarga</span>
                                    </div>
                                </a>
                                <a class="col-6 col-md-4 p-0" href="{{ route('Training.create') }}">
                                    <div class="quick-actions-item">
                                        <i class="fas fa-medal"></i>
                                        <span class="text">Tambah Data Training</span>
                                    </div>
                                </a>
                                <a class="col-6 col-md-4 p-0" href="{{ route('Sertifikasi.create') }}">
                                    <div class="quick-actions-item">
                                        <i class="fas fa-medal"></i>
                                        <span class="text">Tambah Data Sertifikasi</span>
                                    </div>
                                </a>
                                <a class="col-6 col-md-4 p-0" href="{{ route('divisi.create') }}">
                                    <div class="quick-actions-item">
                                        <i class="fas fa-user-edit"></i>
                                        <span class="text">Tambah Tipe Pegawai</span>
                                    </div>
                                </a>
                                <a class="col-6 col-md-4 p-0" href="{{ route('Jabatan.create') }}">
                                    <div class="quick-actions-item">
                                        <i class="fas fa-users"></i>
                                        <span class="text">Tambah Jabatan</span>
                                    </div>
                                </a>
                                @if (Auth::user()->tipe_user == 'admin')
                                    <a class="col-6 col-md-6 p-0" href="{{ route('Organisasi.create') }}">
                                        <div class="quick-actions-item">
                                            <i class="fas fa-user-edit"></i>
                                            <span class="text">Tambah Organisasi</span>
                                        </div>
                                    </a>
                                    <a class="col-6 col-md-6 p-0" href="{{ route('NIP.create') }}">
                                        <div class="quick-actions-item">
                                            <i class="fas fa-user-plus"></i>
                                            <span class="text">Tambah Data NIP</span>
                                        </div>
                                    </a>
                                @else
                                    <a class="col-6 col-md-4 p-0" href="{{ route('Organisasi.create') }}">
                                        <div class="quick-actions-item">
                                            <i class="fas fa-user-edit"></i>
                                            <span class="text">Tambah Organisasi</span>
                                        </div>
                                    </a>
                                    <a class="col-6 col-md-4 p-0" href="{{ route('NIP.create') }}">
                                        <div class="quick-actions-item">
                                            <i class="fas fa-user-plus"></i>
                                            <span class="text">Tambah Data NIP</span>
                                        </div>
                                    </a>
                                @endif
                                @if (Auth::user()->tipe_user == 'superadmin')
                                    <a class="col-6 col-md-4 p-0" href="{{ route('admin.create') }}">
                                        <div class="quick-actions-item">
                                            <i class="fas fa-user-shield"></i>
                                            <span class="text">Tambah Data Admin</span>
                                        </div>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div> --}}
                </div>
            </li>
            <li class="nav-item dropdown hidden-caret">
                <a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#" aria-expanded="false">
                    <div class="avatar-sm">
                        @if (Auth::user()->foto == 'null')
                            <img src="{{ asset('img/avatar.png') }}" alt="image profile"
                                class="avatar-img rounded-circle">
                        @else
                            <img src="{{ Storage::url(Auth::user()->foto) }}" alt="image profile"
                                class="avatar-img rounded-circle">
                        @endif
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-user animated fadeIn">
                    <div class="dropdown-user-scroll scrollbar-outer">
                        <li>
                            <div class="user-box">
                                <div class="avatar-lg">
                                    @if (Auth::user()->foto == 'null')
                                        <img src="{{ asset('img/avatar.png') }}" alt="image profile"
                                            class="avatar-img rounded">
                                    @else
                                        <img src="{{ Storage::url(Auth::user()->foto) }}" alt="image profile"
                                            class="avatar-img rounded">
                                    @endif
                                </div>
                                <div class="u-text">
                                    <h4>{{ Auth::user()->nama }}</h4>
                                    <p class="text-muted">{{ Auth::user()->email }}</p>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ route('User.viewprofil') }}">Profile</a>
                            <a class="dropdown-item" href="{{ route('User.editprofil') }}">Edit Profile</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}</a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>

                        </li>
                    </div>
                </ul>
            </li>
        </ul>
    </div>
</nav>
