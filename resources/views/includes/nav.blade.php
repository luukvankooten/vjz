{{-- Dashboard --}}
<li class="{{  \Request::is('/')? 'active' : null }}">
    <a href="{{ url('/') }}"><i class="fa fa-tachometer"></i>Dashboard</a>
</li>

{{-- For auto menu --}}
@if($menuitems && count($menuitems))
    @foreach($menuitems as $item)
        <li class="{{ \Request::is($item['uri'] . '*')? 'active' : null }}">
            <a href="{{ url($item['uri']) }}"><i class="fa {{ $item['icon'] }}"></i>{{ ucfirst($item['name']) }}</a>
            @if($item['expanded'])
                <div class="expand">
                    <i class="fa fa-caret-right"></i>
                    <div class="expand-content">
                        <ul>
                            @foreach($item['expanded'] as $sub)
                                <li>
                                    <a href="{{ url($sub['url']) }}">{{ ucfirst($sub['name']) }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif
        </li>
    @endforeach
@endif