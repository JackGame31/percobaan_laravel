<nav class="navbar navbar-expand-lg navbar-dark bg-danger">
    <div class="container">
        <a class="navbar-brand" href="/">Fellix's Project</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link {{ $active == 'home' ? 'active' : '' }}" href="/">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ $active == 'about' ? 'active' : '' }}" href="/about">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ $active == 'posts' ? 'active' : '' }}" href="/blog">Blog</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ $active == 'categories' ? 'active' : '' }}" href="/categories">Categories</a>
                </li>
            </ul>

            {{-- fitur menampilkan komponen ketika sudah/belum login --}}
            <ul class="navbar-nav ms-auto">
                {{-- kalau sudah login --}}
                @auth
                    <li class="nav-item dropdown">
                      {{-- cara singkat mendapatkan nama username (cara singkat oleh Laravel) --}}
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            Wellcome back, {{ auth()->user()->name }}
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="/dashboard"><i class="bi bi-layout-text-sidebar-reverse"></i> My Dashboard</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                              {{-- fitur logout --}}
                              <form action="/logout" method="post">
                                @csrf
                                <button type="submit" class="dropdown-item"><i class="bi bi-box-arrow-right"></i> Logout</button>
                              </form>
                            </li>
                        </ul>
                    </li>
                {{-- kalau belum login --}}
                @else
                    <li class="nav-item">
                        <a href="/login" class="nav-link {{ $active == 'login' ? 'active' : '' }}"><i
                                class="bi bi-box-arrow-in-right"></i> Log In</a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>
