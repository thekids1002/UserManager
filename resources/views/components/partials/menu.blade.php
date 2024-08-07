<!-- Sidebar -->
<aside class="main-sidebar border bg-gradient-white">
    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-sidebar flex-column pt-5">
                <li class="nav-item">
                    <a class="nav-link text-decoration-underline {{ (request()->is('admin/user*')) ? 'active bg-blue ' : '' }}" href="{{ route('admin.userList') }}" id= "menu-userList">User List</a>
                </li>
                @if (Auth::check() && Auth::user()->position_id == 0)
                    <li class="nav-item">
                        <a class="nav-link text-decoration-underline  {{ (request()->is('admin/group*')) ? 'active bg-blue ' : '' }}" href="{{ route('admin.groupList') }}">Group
                            List</a>
                    </li>
                @endif
            </ul>
        </nav>
    </div>
</aside>
<!-- /Sidebar -->
