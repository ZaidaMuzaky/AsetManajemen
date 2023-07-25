<div class="sidebar sidebar-style-2">
    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
            <div class="user">
                <div class="avatar-sm float-left mr-2">
                    @if (Auth::user()->foto == 'null')
                        <img src="{{ asset('img/avatar.png') }}" alt="image profile" class="avatar-img rounded-circle">
                    @else
                        <img src="{{ Storage::url(Auth::user()->foto) }}" alt="image profile"
                            class="avatar-img rounded-circle">
                    @endif
                </div>
                <div class="info">
                    <a href="{{ route('User.viewprofil') }}" aria-expanded="true">
                        <span>
                            {{ Auth::user()->nama }}
                            <span class="user-level">{{ Auth::user()->tipe_user }}</span>
                        </span>
                    </a>
                    <div class="clearfix"></div>
                </div>
            </div>
            <ul class="nav nav-primary">
                <li class="nav-item @yield('statusdashboard')">
                    <a href="{{ route('dashboard') }}">
                        <i class="fas fa-home"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-item @yield('statusmutasi')">
                    <a data-toggle="collapse" href="#base">
                        <i class="fa-solid fa-right-left"></i>
                        <p>Data Mutasi</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="base">
                        <ul class="nav nav-collapse">
                            <li class="@yield('statusmutasi')">
                                <a href="{{ route('data-mutasi.index') }}">
                                    <span class="sub-item">Data Mutasi</span>
                                </a>
                            </li>
                            <li class="@yield('statusmutasi')">
                                <a href="{{ route('memo.index') }}">
                                    <span class="sub-item">Memo</span>
                                </a>
                            </li>
                            <li class="@yield('statusmutasi')">
                                <a href="{{ route('berita-acara.index') }}">
                                    <span class="sub-item">Berita Acara</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item @yield('detail-aset')">
                    <a href="{{ route('detail-aset.index') }}">
                        <i class="fa-solid fa-computer"></i>
                        <p>Data Aset</p>
                    </a>
                </li>
                <li class="nav-item @yield('monitoring')">
                    <a href="{{ route('monitoring.index') }}">
                        <i class="fa-solid fa-pen-to-square"></i>
                        <p>Monitoring</p>
                    </a>
                </li>
                <li class="nav-item @yield('cetak-label')">
                    <a href="{{ route('cetak-label.index') }}">
                        <i class="fa-solid fa-print"></i>
                        <p>Cetak Label</p>
                    </a>
                </li>
                <li class="nav-item @yield('statusJenisBarang')">
                    <a href="{{ route('JenisBarang.index') }}">
                        <i class="fa-solid fa-box"></i>
                        <p>Jenis Barang</p>
                    </a>
                </li>
                <li class="nav-item @yield('statusdivisi')">
                    <a href="{{ route('divisi.index') }}">
                        <i class="fas fa-user-edit"></i>
                        <p>Daftar Divisi</p>
                    </a>
                </li>
                <li class="nav-item @yield('statusDaftarPengguna')">
                    <a href="{{ route('DaftarPengguna.index') }}">
                        <i class="fas fa-user"></i>
                        <p>Daftar Pengguna</p>
                    </a>
                </li>
                @if (Auth::user()->tipe_user == 'superadmin')
                    <li class="nav-item @yield('statusadmin')">
                        <a href="{{ route('admin.index') }}">
                            <i class="fas fa-user-shield"></i>
                            <p>Data Admin</p>
                        </a>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</div>
