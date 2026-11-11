@extends('dynamic.layouts.layout')

@section('content')
  <section class="detail-pages no-banner">
    <div class="wrapper-content">
      <div class="detail-pages--top">
        <a href="{{ $menu->permalink }}" class="back">{{ lang::translate('document.back.kliping') }}</a>
        <div class="medsos">
          <label for="">{{ lang::translate('document.share') }}</label>
          <div class="wrap">
            @include('dynamic.component.share-social', ['model' => $document])
          </div>
        </div>
      </div>      
      <div class="detail-pages--title">
        <small class="date">{{ date2string($document->date) }}</small>
        <h3>{{ $document->translated('title') }}</h3>
      </div>
      <div class="slider-caption swiper with-pagination">
        @php($total_slide = widget($document->id, 'document-kliping', 'image')->count())
        <div class="swiper-wrapper">
          @foreach (widget($document->id, 'document-kliping', 'image') as $image)
          @php($cta = $image->childs('link-cta')->first())
            <div class="swiper-slide">
              <figure><img src="{{ media::initial($image->image)->url }}" alt="{{ media::initial($image->image)->alt }}"></figure>
              <div class="slider-caption__bottom">
                @if ($cta)
                <p>{{ lang::translate('document.kliping.cta') }} <a href="{{ $cta->translated('link') }}" target="{{ $cta->target }}">“{{ $cta->translated('label') }}”</a> </p>
                @endif
              </div>
            </div>
          @endforeach
        </div>
        @if ($total_slide > 1)
        <div class="slider-caption__utils">
          <div class="swiper-arrow swiper-prev"></div>
          <div class="swiper-pagination"></div>
          <div class="swiper-arrow swiper-next"></div>
        </div>
        @endif
      </div>
    </div>
    <section class="box-detail-page no-minus">
      <div class="wrapper-content">
        <h5>{{ lang::translate('document.description') }}</h5>
        <table>
          <tr>
            <th>{{ lang::translate('document.content.tipe-dokumen') }}</th>
            <td>{{ $document->document_type->label }}</td>
          </tr>
          <tr>
            <th>{{ lang::translate('document.content.judul') }}</th>
            <td>{{ $document->translated('title') }}</td>
          </tr>
          @php $__dmReplace = \App\Helpers\DynamicMetadata::replacesStatic($document); @endphp
          @unless($__dmReplace)
          <tr>
            <th>{{ lang::translate('document.content.teu-orang') }}</th>
            <td>{{ $document->translated('teu') }}</td>
          </tr>
          <tr>
            <th>{{ lang::translate('document.content.tempat-terbit') }}</th>
            <td>{{ $document->tempat_terbit }}</td>
          </tr>
          <tr>
            <th>{{ lang::translate('document.content.tahun-terbit') }}</th>
            <td>{{ $document->tahun_terbit }}</td>
          </tr>
          <tr>
            <th>{{ lang::translate('document.content.sumber') }}</th>
            <td>{!! nl2br($document->translated('sumber')) !!}</td>
          </tr>
          <tr>
            <th>{{ lang::translate('document.content.subjek') }}</th>
            <td>{{ $document->translated('subjek') }}</td>
          </tr>
          <tr>
            <th>{{ lang::translate('document.content.bahasa') }}</th>
            <td>{{ $document->translated('bahasa') }}</td>
          </tr>
          <tr>
            <th>{{ lang::translate('document.content.bidang-hukum') }}</th>
            <td>{{ $document->translated('bidang_hukum') }}</td>
          </tr>
          <tr>
            <th>{{ lang::translate('document.content.lokasi') }}</th>
            <td>{{ $document->lokasi }}</td>
          </tr>
          @endunless
          @include('dynamic.component.document-dynamic-meta-rows')
          <tr>
            <th>{{ lang::translate('document.content.lampiran') }}</th>
            <td>{!! nl2br($document->translated('lampiran')) !!}</td>
          </tr>
        </table>
      </div>
    </section>
  </section>
  @push('head')
    <link rel="stylesheet" type="text/css" href="{{ Vite::asset('resources/assets/sass/pages/document.scss')}}" preload>
  @endpush
  @push('footer')
    <script type="module" async type="text/javascript" src="{{ Vite::asset('resources/assets/js/document.js') }}"></script>
  @endpush
@endsection
