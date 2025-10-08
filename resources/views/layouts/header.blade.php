<nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #343a40;">
    <div class="container">
        <a class="navbar-brand text-white" href="{{ url('/') }}">MyApp</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <!-- <li class="nav-item"><a class="nav-link" href="{{ url('/dashboard') }}">Dashboard</a></li> -->
            <li class="nav-item">
                <form method="POST" action="{{ route('logout') }}" class="d-inline">
                    @csrf
                    <button type="submit" class="nav-link btn btn-link" style="display:inline; padding:0; border:none; background:none;">
                        Logout
                    </button>
                </form>
            </li>
            </ul>
        </div>
    </div>
</nav>
