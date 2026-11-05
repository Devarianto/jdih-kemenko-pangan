@php
$active = $activeModule ?? admin::module();
foreach(config('cadmin.menu') as $k=>$v) {
    if (array_get($v, 'merge') && $active == $k)
        $active = $v['merge'];
}
@endphp

<nav id="sidebar" class="sidebar js-sidebar">
    <div class="sidebar-content js-simplebar">
        <a class="sidebar-brand be-load-logo" href="{{ url(ADMIN) }}" data-logo="{{ media::url($website->logo) }}" style="background-color: #076E95;">
            <span class="align-middle">&nbsp;</span>
        </a>
        
        <ul class="sidebar-nav">
            <li class="sidebar-header"></li>
            @php($no = 1)
            @foreach ($menu AS $k => $v)
                @if(!is_array(array_get($v, 'child'))) 
                    @if(!array_get($v, 'merge'))
                        <li
                            @if ($active == $k)
                                class="sidebar-item active"
                            @else
                                class="sidebar-item"
                            @endif 
                        >
                            <a class="sidebar-link" href="{{ admin::url(''.$k . ((array_get($v, 'default-action')) ? '/'.array_get($v, 'default-action') : '')) }}">
                                <i class="fa @if (array_get($v, 'fa')) fa-{!! array_get($v, 'fa') !!} @else fa-list @endif"></i> 
                                <span class="align-middle">{!! array_get($v, 'label') !!}</span>
                                @if (array_get($v, 'counter-label'))
                                    <span class="sidebar-badge badge bg-primary">{{ array_get($v, 'counter-label') }}</span>
                                @endif
                            </a>
                        </li>
                    @endif
                @else
                    <li class="sidebar-item @if (in_array($active, array_keys(array_get($v, 'child')))) active @endif">
                        <a data-bs-target="#{{ $k }}-{{ $no }}" data-bs-toggle="collapse" class="sidebar-link collapsed">
                            <i class="fa @if (array_get($v, 'fa')) fa-{!! array_get($v, 'fa') !!} @else fa-list @endif"></i>
                            <span class="align-middle">{!! array_get($v, 'label') !!}</span>
                        </a>
                        <ul id="{{ $k }}-{{ $no }}" class="sidebar-dropdown list-unstyled collapse @if (in_array($active, array_keys(array_get($v, 'child')))) show @endif" data-bs-parent="#sidebar">
                            @foreach (array_get($v, 'child') AS $kk => $vv)
                                @if(!array_get($vv,'merge'))
							        <li class="sidebar-item @if ($active == $kk) active @endif">
                                        <a class="sidebar-link" href="{{ admin::url(''. $kk . ((array_get($vv, 'default-action')) ? '/'.array_get($vv, 'default-action') : '')) }}">
                                            {!! array_get($vv, 'label') !!}
                                            @if (array_get($vv, 'counter-label'))
                                                <span class="sidebar-badge badge bg-primary">{{ array_get($vv, 'counter-label') }}</span>
                                            @endif
                                        </a>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </li>
                @endif
                @php($no++)
            @endforeach
        </ul>
    </div>
</nav>