<nav class="main-header navbar navbar-expand navbar-white navbar-light m-0 border py-4">
    <!-- Left navbar links -->
    <ul class="navbar-nav d-lg-none">
        <li class="nav-item" id="mobile-toggle">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
    </ul>
    <ul class="navbar-nav">
        <li>
            <div class="info d-flex gap-5">
                <a href="" id="internTrainingLink" class="text-decoration-none ms-4 fs-5 text-dark">

                </a>
            </div>
        </li>
    </ul>

    <ul class="navbar-nav mx-auto">
        <li>
            <div class="info d-flex">
                <h4>{{$title}}</h4>
            </div>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav">
        <li>
            <div class="info d-flex">
                {{ Str::limit(\Illuminate\Support\Facades\Auth::user()->name , 50);}}

                <a href="{{ route('logout') }}" class="px-2">Logout</a>
            </div>
        </li>
    </ul>
</nav>
