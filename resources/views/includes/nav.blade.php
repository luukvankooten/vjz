{{-- Dashboard --}}
<li class="{{  \Request::is('/')? 'active' : null }}">
    <div class="item">
        <a href="{{ url('/') }}"><i class="fa fa-tachometer"></i>Dashboard</a>
    </div>
</li>

{{-- For auto menu --}}
@if($menuitems && count($menuitems))
    @foreach($menuitems as $item)
        <li class="{{ \Request::is($item['uri'] . '*')? 'active' : null }}">
            <div class="item">
                <a href="{{ url($item['uri']) }}">
                    <i class="fa {{ $item['icon'] }}"></i>{{ ucfirst($item['name']) }}
                </a>
                @if($item['expanded'])
                    <i class="fa fa-caret-down" @click="subMenu($event)"></i>
                @endif
            </div>
            @if($item['expanded'] && count($item['expanded']))
                <div class="expand-content">
                    <ul>
                        @foreach($item['expanded'] as $sub)
                            <li>
                                <a href="{{ url($sub['url']) }}">{{ ucfirst($sub['name']) }}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </li>
    @endforeach
@endif