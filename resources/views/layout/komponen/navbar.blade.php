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
