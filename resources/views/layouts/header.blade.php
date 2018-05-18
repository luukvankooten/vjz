<header id="bar">

    <!-- Close -->
    <div id="collapse" class="item">
        <i class="fa fa-bars"></i>
    </div>

    <!-- BreadCrumb -->
    <div class="breadcrumb">
        @foreach($breadcrumps as $breadcrump)
            <a class="link" href="{{ $breadcrump['url'] }}">{{ $breadcrump['name'] }}</a>
        @endforeach
    </div>

    <!-- Settings -->
    <div class="item right">
        <i class="fa fa-cogs"></i>
        <a href="#"></a>
    </div>

    <!-- Logout -->
    <div id="logout" class="item" v-on:click="$refs.form.submit()">
        <i class="fa fa-sign-out"></i>
        <form method="post" action="{{ route('logout') }}" ref="form">
            @csrf
        </form>
    </div>
</header>