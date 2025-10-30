@php($profile = widget($menu->id,'menu','profile-column-content'))
@if ($profile->count() >= 1)
    @foreach ($profile as $pc)
    <div class="section-content">
        <div class="wrapper-content">
            <div class="content-pages">
                <h3><b>{{ $pc->translated('title') }}</b></h3>
                <h5>{{ $pc->translated('intro') }}</h5>
                <p>{{ $pc->translated('description') }}</p>
            </div>
            @php($profile_child = $pc->childs('profile-column-profile'))

            @if ($profile_child->count() >= 1)
            <div class="profile-column">
                <div class="row row-wrap">
                    @foreach ($profile_child as $pcp)
                    <div class="column column-33">
                        <figure><img src="{{ media::url($pcp->image) }}" alt="{{ media::initial($pcp->image)->alt }}"></figure>
                        <h5>{{ $pcp->name }}</h5>
                        <span>{{ $pcp->translated('position') }}</span>
                        <a href="javascript:void(0)" class="readmore" onclick="openPopup('#popup-box-large{{ $pcp->id }}')">{{ lang::translate('blocks.profile-column.read-more') }}<i class="wa-ic-chevron-right-solid"></i></a>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>
    @endforeach
@endif

@php($profile = widget($menu->id,'menu','profile-column-content'))
@if ($profile->count() >= 1)
    @foreach ($profile as $pc)
        @php($profile_child = $pc->childs('profile-column-profile'))

        @if ($profile_child->count() >= 1)
        @foreach ($profile_child as $pcp)
        <div class="popup" id="popup-box-large{{ $pcp->id }}">
        <div class="popup__overlay"></div>
        <div class="popup__box popup__box--large">
            <div class="popup__close">
            <i class="wa-ic-close-solid"></i>
            </div>
            <div class="popup__content">
            <h6>{{ $pcp->translated('title') }}</h6>
            <div class="popup__overflow">
                <div class="row">
                <div class="column column-50">
                    <figure><img src="{{ media::url($pcp->image) }}" alt="{{ media::initial($pcp->image)->alt }}"></figure>
                </div>
                <div class="column column-50">
                    <h4>{{ $pcp->name }}</h4>
                    <h5>{{ $pcp->translated('position') }}</h5>
                    {!! $pcp->translated('description') !!}
                </div>
                </div>
            </div>
            </div>
        </div>
        </div>
        @endforeach
        @endif
    @endforeach
@endif

