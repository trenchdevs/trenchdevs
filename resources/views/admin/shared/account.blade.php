<nav class="nav nav-borders mb-5">
    <a class="nav-link ml-0" href="{{route('portfolio.edit')}}">
        <div class="badge badge-cyan-soft p-3">
            <i data-feather="user"></i>
            <span class="ml-1 font-weight-bolder">Profile</span>
        </div>
    </a>
    <a class="nav-link active" href="{{route('portfolio.security')}}">
        <div class="badge badge-blue-soft p-3">
            <i data-feather="lock"></i>
            <span class="ml-1 font-weight-bolder">Security</span>
        </div>
    </a>
    {{--    <a class="nav-link" href="account-notifications.html">Notifications</a>--}}
</nav>
