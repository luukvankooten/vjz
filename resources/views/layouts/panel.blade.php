<div id="sidebar" class="expended">

    <div class="side-head">
        <!-- Logo -->
        <img src="{{ asset('/images/logo.svg') }}" height="20">
    </div>

    <div class="side">
        <div class="user clearfix">
            <!-- User-image -->
            <div class="image">
                <img src="{{ asset('/images/dummy-profile-pic.png') }}">
            </div>

            <!-- Name -->
            <div class="name">
                <h2>{{ ucfirst(Auth::user()->name) }}</h2>
            </div>
        </div>

        <nav class="items">
            <ul>
                @include('includes.nav')
            </ul>
        </nav>
    </div>

</div>