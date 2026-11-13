@extends('dynamic.layouts.layout')

@section('content')
  <!-- middle -->
  @foreach(widget($home->id, 'menu', 'banner-home') as $banner)
  <div class="banner-homepage">
    <figure>
      <img src="{{ media::initial($banner->image)->url }}" 
          data-img-large="{{ media::initial($banner->image)->url }}" 
          data-img-medium="{{ media::initial($banner->value('image-medium'))->url }}" 
          data-img-small="{{ media::initial($banner->value('image-small'))->url }}" alt="{{ media::initial($banner->image)->alt }}">
    </figure>
    <div class="banner-homepage__caption">
      <h3>{{ $banner->translated('subtitle') }}</h3>
      <h1>{{ $banner->translated('title') }}</h1>
      @if ($menus['peraturan'] != null)
      <form action="{{ $menus['peraturan']->permalink }}" id="frm-search">
        <div class="wrap-input">
          <input type="text" id="searchPeraturan" name="search" value="{{ request()->query('search') }}" class="search-top" placeholder="{{ lang::translate('home.search-peraturan.placeholder') }}">
          <button type="button" class="voice" id="btnToggle">
            <img src="{{ asset('images/material/voice.svg') }}" width="20" height="20" decoding="async" alt="">
          </button>
          <button type="submit" class="search button-icon">
            {{ lang::translate('home.search-peraturan.button') }}
            <i class="wa-icon wa-ic-search-outline"></i>
          </button>
        </div>
      </form>
      <div class="wrap-filter">
        <a href="">{{ lang::translate('home.search-peraturan.specific-search.title') }}</a>
        <div class="filter">
          <div class="filter__title">
            <h6>{{ lang::translate('home.search-peraturan.specific-search.title') }}</h6>
            <div class="filter__close"></div>
          </div>
          <form action="{{ $menus['peraturan']->permalink }}" id="frm-specific-search">
            <input type="hidden" name="search" class="hidden-search" value="{{ request()->query('search') }}">
            <div class="row">
              <div class="column column-35">
                <label for="">{{ lang::translate('home.search-peraturan.specific-search.form-title.rule-type') }}</label>
                <select name="rule_type">
                  <option value="" selected disabled>{{ lang::translate('home.search-peraturan.specific-search.form-placeholder.rule-type') }}</option>
                  @foreach ($rule_types as $data)
                  <option value="{{ $data->id }}" @selected($data->id == request()->query('rule_type'))>{{ $data->label }}</option>
                  @endforeach
                </select>
              </div>
              <div class="column column-30">
                <label for="">{{ lang::translate('home.search-peraturan.specific-search.form-title.theme') }}</label>
                <select name="theme">
                  <option value="" selected disabled>{{ lang::translate('home.search-peraturan.specific-search.form-placeholder.theme') }}</option>
                  @foreach ($rule_themes as $data)
                  <option value="{{ $data->id }}" @selected($data->id == request()->query('theme'))>{{ $data->label }}</option>
                  @endforeach
                </select>
              </div>
              <div class="column column-20">
                <label for="">{{ lang::translate('home.search-peraturan.specific-search.form-title.year') }}</label>
                <select name="year">
                  <option value="" selected disabled>{{ lang::translate('home.search-peraturan.specific-search.form-placeholder.year') }}</option>
                  @foreach ($year_peraturan as $data)
                  <option value="{{ $data->year }}" @selected($data->year == request()->query('year'))>{{ $data->year }}</option>
                  @endforeach
                </select>
              </div>
              <div class="column column-15">
                <button type="submit" class="button button-gradient">{{ lang::translate('home.search-peraturan.button') }}</button>
              </div>
            </div>
          </form>
        </div>
      </div>
      @endif

      <div class="banner-stats">
        <div class="banner-stats__row">
          <a href="{{ $menus['peraturan'] ? url($menus['peraturan']->permalink) : url('/peraturan-hukum') }}" class="banner-stats__item" title="Lihat Peraturan">
            <span class="banner-stats__icon">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                <polyline points="14 2 14 8 20 8"></polyline>
                <line x1="16" y1="13" x2="8" y2="13"></line>
                <line x1="16" y1="17" x2="8" y2="17"></line>
                <polyline points="10 9 9 9 8 9"></polyline>
              </svg>
            </span>
            <span class="banner-stats__label">Peraturan</span>
            <span class="banner-stats__badge">{{ number_format($peraturan_count, 0, ',', '.') }}</span>
          </a>

          <a href="{{ $menus['monografi'] ? url($menus['monografi']->permalink) : url('/monografi-hukum') }}" class="banner-stats__item" title="Lihat Monografi">
            <span class="banner-stats__icon">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"></path>
                <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"></path>
              </svg>
            </span>
            <span class="banner-stats__label">Monografi</span>
            <span class="banner-stats__badge">{{ number_format($monografi_count, 0, ',', '.') }}</span>
          </a>

          <a href="{{ $menus['jurnal'] ? url($menus['jurnal']->permalink) : ($menus['majalah'] ? url($menus['majalah']->permalink) : url('/jurnal-hukum')) }}" class="banner-stats__item" title="Lihat Artikel Hukum">
            <span class="banner-stats__icon">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M16 2H8a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2z"></path>
                <path d="M9 7h6"></path>
                <path d="M9 11h6"></path>
                <path d="M9 15h4"></path>
                <path d="M4 6h2"></path>
                <path d="M4 10h2"></path>
                <path d="M4 14h2"></path>
                <path d="M4 18h2"></path>
              </svg>
            </span>
            <span class="banner-stats__label">Artikel Hukum</span>
            <span class="banner-stats__badge">{{ number_format($artikel_count, 0, ',', '.') }}</span>
          </a>

          <a href="{{ $menus['putusan'] ? url($menus['putusan']->permalink) : url('/putusan-hukum') }}" class="banner-stats__item" title="Lihat Putusan">
            <span class="banner-stats__icon">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M3 21h18"></path>
                <path d="M3 10h18"></path>
                <path d="M12 3L2 10h20L12 3z"></path>
                <path d="M6 10v11"></path>
                <path d="M10 10v11"></path>
                <path d="M14 10v11"></path>
                <path d="M18 10v11"></path>
              </svg>
            </span>
            <span class="banner-stats__label">Putusan</span>
            <span class="banner-stats__badge">{{ number_format($putusan_count, 0, ',', '.') }}</span>
          </a>
        </div>
      </div>
    </div>
    <div class="wave">
      <svg xmlns="http://www.w3.org/2000/svg"
        width="100%" height="140"
        viewBox="0 180 2500 200"
        fill="#EEF4FE"
        preserveAspectRatio="none">
        <path class="st1"
          d="M 0 250 C 1200 320 1200 100 3000 250 L 3000 550 L 0 550 L 0 250">
          <animate attributeName="d" dur="5s"
            values="M 0 250 C 1200 320 1200 100 3000 250 L 3000 550 L 0 550 L 0 250;
                    M 0 250 C 400 100 400 320 3000 250 L 3000 550 L 0 550 L 0 250;
                    M 0 250 C 1200 280 1200 100 3000 250 L 3000 550 L 0 550 L 0 250"
            repeatCount="indefinite" />
        </path>
      </svg>
    </div>
  </div>
  @endforeach
  <section class="document animating-scroll" data-animate-trigger=".trigger-1">
    <div class="trigger trigger-1"></div>
    <div class="wrapper">
      <div class="document__title">
        <h4>{{ lang::translate('home.newest-document') }}</h4>
        <div class="arrow">
          <div class="swiper-arrow swiper-prev"></div>
          <div class="swiper-arrow swiper-next"></div>
        </div>
      </div>
      <div class="document__listing swiper">
        <div class="swiper-wrapper">
          @foreach ($newest_documents as $document)
          <a href="{{ $document->permalink_document }}" class="document__listing--item swiper-slide">
            <figure><img src="{{ media::initial($document->thumbnail)->url }}" alt="{{ media::initial($document->thumbnail)->alt }}" loading="lazy" decoding="async" width="80" height="105"></figure>
            <figcaption>
              <span class="tag" style="background-color: #D2E3FF; color: {{ $document->tag_color_home }};">{{ $document->master_document->label }}</span>
              <p>{{ $document->translated('title') }}</p>
              <small class="visited">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                  <path d="M8 3.5C4.967 3.5 2.399 5.388 1.5 8C2.399 10.612 4.967 12.5 8 12.5C11.033 12.5 13.601 10.612 14.5 8C13.601 5.388 11.033 3.5 8 3.5Z" stroke="#999999" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                  <path d="M8 10.5C9.38071 10.5 10.5 9.38071 10.5 8C10.5 6.61929 9.38071 5.5 8 5.5C6.61929 5.5 5.5 6.61929 5.5 8C5.5 9.38071 6.61929 10.5 8 10.5Z" stroke="#999999" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                {{ lang::translate('document.count.view', ['count' => $document->view_count]) }}
              </small>
            </figcaption>
          </a>
          @endforeach
        </div>
      </div>
    </div>
  </section>
  @foreach (widget($home->id, 'menu', 'rule-theme') as $data)
  <section class="tema animating-scroll" data-animate-trigger=".trigger-2">
    <div class="trigger trigger-2"></div>
    <div class="bg">
      <img 
      src="{{ media::initial($data->image)->url }}" 
      data-img-large="{{ media::initial($data->image)->url }}"
      data-img-medium="{{ media::initial($data->value('image-medium'))->url }}"
      data-img-small="{{ media::initial($data->value('image-small'))->url }}"
      loading="lazy" decoding="async" alt="{{ media::initial($data->image)->alt }}">
    </div>
    <div class="wave">
      <svg xmlns="http://www.w3.org/2000/svg" widht="5000" height="200" viewBox="0 180 2500 200" fill="#F8F8F8">
        <path class="st1" d="M 0 250 C 1200 400 1200 50 3000 250 L 3000 550 L 0 550 L 0 250">
          <animate attributeName="d" dur="5s" values="
            M 0 250 C 1200 400 1200 50 3000 250 L 3000 550 L 0 550 L 0 250;
            M 0 250 C 400 100 400 400 3000 250 L 3000 550 L 0 550 L 0 250;
            M 0 250 C 1200 400 1200 50 3000 250 L 3000 550 L 0 550 L 0 250" 
            keyTimes="0; 0.5; 1" repeatCount="indefinite">
          </animate>
        </path>
      </svg>
    </div>
    <div class="wrapper">
      <div class="tema__title">
        <h3>{{ $data->translated('title') }}</h3>
        <p>{{ $data->translated('subtitle') }}</p>
      </div>
      @if ($menus['peraturan'] != null)
      <div class="tema-slider">
        <div class="navigation">
          <div class="swiper-arrow swiper-button-prev"></div>
          <div class="swiper-arrow swiper-button-next"></div>
        </div>
        <div class="swiper">
          <div class="tema__listing swiper-wrapper">
            @foreach ($rule_themes as $data)
            <a href="{{ $menus['peraturan']->permalink.'?theme='.$data->id }}" class="tema__listing--item swiper-slide">
              <figure><img src="{{ media::initial($data->image)->url }}" loading="lazy" alt="{{ media::initial($data->image)->alt }}" decoding="async"
              width="280" height="220"></figure>
              <figcaption>
                <span class="ico"><img src="{{ media::initial($data->icon)->url }}" alt="{{ media::initial($data->icon)->alt }}" width="48" height="48"></span>
                <h6>{{ $data->label }}</h6>
              </figcaption>
            </a>
            @endforeach
          </div>
        </div>
      </div>
      @endif
    </div>
  </section>
  @endforeach
  <section class="artikel animating-scroll" data-animate-trigger=".trigger-3">
    <div class="trigger trigger-3"></div>
    <div class="wrapper">
      <div class="artikel__left">
        <div class="list">
          @if ($menus['monografi'] != null)
          <div class="list-monografi">
            <div class="list-title">
              <h5>{{ lang::translate('home.document.monografi') }} ({{ $monografi_count }})</h5>
              <a href="{{ $menus['monografi']->permalink }}" class="readmore">{{ lang::translate('home.read-more') }}</a>
            </div>
            <div class="listing-card without-box">
              @foreach ($document_monografi as $document)
              <a href="{{ $document->permalink_document }}" class="listing-card__item">
                <figure><img src="{{ media::initial($document->thumbnail)->url }}" width="218" height="281" decoding="async" loading="lazy" alt="{{ media::initial($document->thumbnail)->alt }}"></figure>
                <figcaption>
                  <p>{{ $document->translated('title') }}</p>
                  <small class="visited">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                      <path d="M8 3.5C4.967 3.5 2.399 5.388 1.5 8C2.399 10.612 4.967 12.5 8 12.5C11.033 12.5 13.601 10.612 14.5 8C13.601 5.388 11.033 3.5 8 3.5Z" stroke="#999999" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                      <path d="M8 10.5C9.38071 10.5 10.5 9.38071 10.5 8C10.5 6.61929 9.38071 5.5 8 5.5C6.61929 5.5 5.5 6.61929 5.5 8C5.5 9.38071 6.61929 10.5 8 10.5Z" stroke="#999999" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    {{ lang::translate('document.count.view', ['count' => $document->view_count]) }}
                  </small>
                </figcaption>
              </a>
              @endforeach
            </div>
          </div>
          @endif
          @if ($menus['peraturan'] != null)
          <div class="list-rules">
            <div class="list-title">
              <h5>{{ lang::translate('home.document.peraturan') }} ({{ $peraturan_count }})</h5>
              <a href="{{ $menus['peraturan']->permalink }}" class="readmore">{{ lang::translate('home.read-more') }}</a>
            </div>
            <div class="listing-card">
              @foreach ($document_peraturan as $document)
              <a href="{{ $document->permalink_document }}" class="listing-card__item">
                <figure><img src="{{ media::initial($document->thumbnail)->url }}" width="218" height="120"
                loading="lazy" decoding="async" alt="{{ media::initial($document->thumbnail)->alt }}"></figure>
                <figcaption>
                  <p>{{ $document->translated('title') }}</p>
                  <span>{{ $document->translated('intro') }}</span>
                  <small class="visited">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                      <path d="M8 3.5C4.967 3.5 2.399 5.388 1.5 8C2.399 10.612 4.967 12.5 8 12.5C11.033 12.5 13.601 10.612 14.5 8C13.601 5.388 11.033 3.5 8 3.5Z" stroke="#999999" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                      <path d="M8 10.5C9.38071 10.5 10.5 9.38071 10.5 8C10.5 6.61929 9.38071 5.5 8 5.5C6.61929 5.5 5.5 6.61929 5.5 8C5.5 9.38071 6.61929 10.5 8 10.5Z" stroke="#999999" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    {{ lang::translate('document.count.view', ['count' => $document->view_count]) }}
                  </small>
                </figcaption>
              </a>
              @endforeach
            </div>
          </div>
          @endif
          @if ($menus['putusan'] != null)
          <div class="list-putusan">
            <div class="list-title">
              <h5>{{ lang::translate('home.document.putusan') }} ({{ $putusan_count }})</h5>
              <a href="{{ $menus['putusan']->permalink }}" class="readmore">{{ lang::translate('home.read-more') }}</a>
            </div>
            <div class="listing-card">
              @foreach ($document_putusan as $document)
              <a href="{{ $document->permalink_document }}" class="listing-card__item">
                <figure><img src="{{ media::initial($document->thumbnail)->url }}" width="218" height="120" loading="lazy" decoding="async" alt="{{ media::initial($document->thumbnail)->alt }}"></figure>
                <figcaption>
                  <small class="tag">{{ $document->translated('jenis_peradilan') }}</small>
                  <p>{{ $document->translated('title') }}</p>
                  <small class="visited">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                      <path d="M8 3.5C4.967 3.5 2.399 5.388 1.5 8C2.399 10.612 4.967 12.5 8 12.5C11.033 12.5 13.601 10.612 14.5 8C13.601 5.388 11.033 3.5 8 3.5Z" stroke="#999999" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                      <path d="M8 10.5C9.38071 10.5 10.5 9.38071 10.5 8C10.5 6.61929 9.38071 5.5 8 5.5C6.61929 5.5 5.5 6.61929 5.5 8C5.5 9.38071 6.61929 10.5 8 10.5Z" stroke="#999999" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    {{ lang::translate('document.count.view', ['count' => $document->view_count]) }}
                  </small>
                </figcaption>
              </a>
              @endforeach
            </div>
          </div>
          @endif
          @if ($menus['majalah'] != null)
          <div class="list-artikel">
            <div class="list-title">
              <h5>{{ lang::translate('home.document.majalah') }} ({{ $majalah_count }})</h5>
              <a href="{{ $menus['majalah']->permalink }}" class="readmore">{{ lang::translate('home.read-more') }}</a>
            </div>
            <div class="listing-card">
              @foreach ($document_majalah as $document)
              <a href="{{ $document->permalink_document }}" class="listing-card__item">
                <figure><img src="{{ media::initial($document->thumbnail)->url }}" width="218" height="120" loading="lazy" decoding="async" alt="{{ media::initial($document->thumbnail)->alt }}"></figure>
                <figcaption>
                  <small class="date">{{ $document->translated('edisi') }}</small>
                  <p>{{ $document->translated('title') }}</p>
                  <small class="visited">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                      <path d="M8 3.5C4.967 3.5 2.399 5.388 1.5 8C2.399 10.612 4.967 12.5 8 12.5C11.033 12.5 13.601 10.612 14.5 8C13.601 5.388 11.033 3.5 8 3.5Z" stroke="#999999" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                      <path d="M8 10.5C9.38071 10.5 10.5 9.38071 10.5 8C10.5 6.61929 9.38071 5.5 8 5.5C6.61929 5.5 5.5 6.61929 5.5 8C5.5 9.38071 6.61929 10.5 8 10.5Z" stroke="#999999" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    {{ lang::translate('document.count.view', ['count' => $document->view_count]) }}
                  </small>
                </figcaption>
              </a>
              @endforeach
            </div>
          </div>
          @endif
          @if ($menus['kliping'] != null)
          <div class="list-artikel">
            <div class="list-title">
              <h5>{{ lang::translate('home.document.kliping') }} ({{ $kliping_count }})</h5>
              <a href="{{ $menus['kliping']->permalink }}" class="readmore">{{ lang::translate('home.read-more') }}</a>
            </div>
            <div class="listing-card">
              @foreach ($document_kliping as $document)
              <a href="{{ $document->permalink_document }}" class="listing-card__item">
                <figure><img src="{{ media::initial($document->thumbnail)->url }}" width="218" height="120" loading="lazy" decoding="async" alt="{{ media::initial($document->thumbnail)->alt }}"></figure>
                <figcaption>
                  <span class="date">{{ date2string($document->created_at) }}</span>
                  <p>{{ $document->translated('title') }}</p>
                  <small class="visited">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                      <path d="M8 3.5C4.967 3.5 2.399 5.388 1.5 8C2.399 10.612 4.967 12.5 8 12.5C11.033 12.5 13.601 10.612 14.5 8C13.601 5.388 11.033 3.5 8 3.5Z" stroke="#999999" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                      <path d="M8 10.5C9.38071 10.5 10.5 9.38071 10.5 8C10.5 6.61929 9.38071 5.5 8 5.5C6.61929 5.5 5.5 6.61929 5.5 8C5.5 9.38071 6.61929 10.5 8 10.5Z" stroke="#999999" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    {{ lang::translate('document.count.view', ['count' => $document->view_count]) }}
                  </small>
                </figcaption>
              </a>
              @endforeach
            </div>
          </div>
          @endif
          @if ($menus['jurnal'] != null)
          <div class="list-artikel">
            <div class="list-title">
              <h5>{{ lang::translate('home.document.jurnal') }} ({{ $jurnal_count }})</h5>
              <a href="{{ $menus['jurnal']->permalink }}" class="readmore">{{ lang::translate('home.read-more') }}</a>
            </div>
            <div class="listing-card">
              @foreach ($document_jurnal as $document)
              <a href="{{ $document->permalink_document }}" class="listing-card__item">
                <figure><img src="{{ media::initial($document->thumbnail)->url }}" width="218" height="120" loading="lazy" decoding="async" alt="{{ media::initial($document->thumbnail)->alt }}"></figure>
                <figcaption>
                  <small class="date">{{ $document->translated('edisi') }}</small>
                  <p>{{ $document->translated('title') }}</p>
                  <small class="visited">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                      <path d="M8 3.5C4.967 3.5 2.399 5.388 1.5 8C2.399 10.612 4.967 12.5 8 12.5C11.033 12.5 13.601 10.612 14.5 8C13.601 5.388 11.033 3.5 8 3.5Z" stroke="#999999" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                      <path d="M8 10.5C9.38071 10.5 10.5 9.38071 10.5 8C10.5 6.61929 9.38071 5.5 8 5.5C6.61929 5.5 5.5 6.61929 5.5 8C5.5 9.38071 6.61929 10.5 8 10.5Z" stroke="#999999" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    {{ lang::translate('document.count.view', ['count' => $document->view_count]) }}
                  </small>
                </figcaption>
              </a>
              @endforeach
            </div>
          </div>
          @endif
          @if ($menus['naskah'] != null)
          <div class="list-rules">
            <div class="list-title">
              <h5>{{ lang::translate('home.document.naskah') }} ({{ $naskah_count }})</h5>
              <a href="{{ $menus['naskah']->permalink }}" class="readmore">{{ lang::translate('home.read-more') }}</a>
            </div>
            <div class="listing-card">
              @foreach ($document_naskah as $document)
              <a href="{{ $document->permalink_document }}" class="listing-card__item">
                <figure><img src="{{ media::initial($document->thumbnail)->url }}" width="218" height="120" loading="lazy" decoding="async" alt="{{ media::initial($document->thumbnail)->alt }}"></figure>
                <figcaption>
                  <p>{{ $document->translated('title') }}</p>
                  <span>{{ $document->translated('intro') }}</span>
                  <small class="visited">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                      <path d="M8 3.5C4.967 3.5 2.399 5.388 1.5 8C2.399 10.612 4.967 12.5 8 12.5C11.033 12.5 13.601 10.612 14.5 8C13.601 5.388 11.033 3.5 8 3.5Z" stroke="#999999" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                      <path d="M8 10.5C9.38071 10.5 10.5 9.38071 10.5 8C10.5 6.61929 9.38071 5.5 8 5.5C6.61929 5.5 5.5 6.61929 5.5 8C5.5 9.38071 6.61929 10.5 8 10.5Z" stroke="#999999" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    {{ lang::translate('document.count.view', ['count' => $document->view_count]) }}
                  </small>
                </figcaption>
              </a>
              @endforeach
            </div>
          </div>
          @endif
        </div>
      </div>
      <div class="artikel__right">
        <div class="artikel__right-title">
          <h5>
            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 22 22" fill="none">
              <g clip-path="url(#clip0_7898_1134)">
                <path d="M19.9375 4.8125L11.6875 13.0625L8.25 9.625L2.0625 15.8125" stroke="#2063D2" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M19.9375 10.3125V4.8125H14.4375" stroke="#2063D2" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              </g>
              <defs>
                <clipPath id="clip0_7898_1134">
                  <rect width="22" height="22" fill="white"/>
                </clipPath>
              </defs>
            </svg>
            {{ lang::translate('home.document.popular') }}
          </h5>
        </div>
        <div class="document__listing">
          @foreach ($popular_documents as $document)
          <a href="{{ $document->permalink_document }}" class="document__listing--item ">
            <figure><img src="{{ media::initial($document->thumbnail)->url }}" loading="lazy" alt="{{ media::initial($document->thumbnail)->alt }}" decoding="async" width="80" height="105"></figure>
            <figcaption>
              <span class="tag" style="background-color: #D2E3FF; color:{{ $document->tag_color_home }};">{{ $document->master_document->label ?? '' }}</span>
              <p>{{ $document->translated('title') }}</p>
              <small class="visited">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                  <path d="M8 3.5C4.967 3.5 2.399 5.388 1.5 8C2.399 10.612 4.967 12.5 8 12.5C11.033 12.5 13.601 10.612 14.5 8C13.601 5.388 11.033 3.5 8 3.5Z" stroke="#999999" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                  <path d="M8 10.5C9.38071 10.5 10.5 9.38071 10.5 8C10.5 6.61929 9.38071 5.5 8 5.5C6.61929 5.5 5.5 6.61929 5.5 8C5.5 9.38071 6.61929 10.5 8 10.5Z" stroke="#999999" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                {{ lang::translate('document.count.view', ['count' => $document->view_count]) }}
              </small>
            </figcaption>
          </a>
          @endforeach
        </div>
      </div>
    </div>
  </section>
  <section class="news animating-scroll" data-animate-trigger=".trigger-4">
    <div class="trigger trigger-4"></div>
    <div class="grid">
      <div class="grid__item">
        <div class="tag news">
          <svg xmlns="http://www.w3.org/2000/svg" width="12" height="13" viewBox="0 0 12 13" fill="none">
            <path d="M9.6175 1.375H2.3825C1.5515 1.375 0.875 2.051 0.875 2.8825V10.118C0.875 10.949 1.551 11.6255 2.3825 11.6255H9.618C10.449 11.6255 11.1255 10.9495 11.1255 10.118V2.8825C11.125 2.051 10.449 1.375 9.6175 1.375ZM10.522 10.1175C10.522 10.616 10.1165 11.022 9.6175 11.022H2.3825C1.884 11.022 1.478 10.6165 1.478 10.1175V9.027L3.911 6.3235L7.1975 9.311L9.015 7.7965L10.5225 9.0525L10.522 10.1175ZM10.522 8.268L9.0145 7.012L7.214 8.512L3.8685 5.47L1.478 8.126V2.8825C1.478 2.384 1.8835 1.978 2.3825 1.978H9.618C10.1165 1.978 10.5225 2.3835 10.5225 2.8825L10.522 8.268Z" fill="white" stroke="white" stroke-width="0.6"/>
            <path d="M8.11102 5.89684C8.94202 5.89684 9.61852 5.22084 9.61852 4.38934C9.61852 3.55784 8.94252 2.88184 8.11102 2.88184C7.28002 2.88184 6.60352 3.55784 6.60352 4.38934C6.60352 5.22084 7.27952 5.89684 8.11102 5.89684ZM8.11102 3.48534C8.60952 3.48534 9.01552 3.89084 9.01552 4.38984C9.01552 4.88884 8.61002 5.29434 8.11102 5.29434C7.61202 5.29434 7.20652 4.88884 7.20652 4.38984C7.20652 3.89084 7.61202 3.48534 8.11102 3.48534Z" fill="white" stroke="white" stroke-width="0.6"/>
          </svg>
          {{ lang::translate('home.news') }}
        </div>
        <figure>
          <img src="{{ media::initial($news_first->thumbnail_home_large)->url }} "width="1270" height="720" loading="lazy" decoding="async" alt="{{ media::initial($news_first->thumbnail_home_large)->alt }}">
        </figure>
        <div class="grid__item--caption">
          <span class="date">{{ date2string($news_first->date) }}</span>
          <h4>{{ $news_first->translated('title') }}</h4>
          <a href="{{ $news_first->permalink }}" class="readmore">{{ lang::translate('news.read-more') }}</a>
        </div>
        <div class="highlight">
          @foreach ($news_others as $news)
          <a href="{{ $news->permalink }}" class="highlight-item">
            <figure><img src="{{ media::initial($news->thumbnail_home_small)->url }}" width="84" height="84" loading="lazy" decoding="async" alt="{{ media::initial($news->thumbnail_home_small)->alt }}"></figure>
            <figcaption>
              <p>{{ $news->translated('title') }}</p>
              <small class="date">{{ date2string($news->date) }}</small>
            </figcaption>
          </a>
          @endforeach
        </div>
      </div>
      @if ($gallery_image != null)
      <div class="grid__item photo" onclick="openPopup('#popup-photo')">
        <div class="tag photo">
          <svg xmlns="http://www.w3.org/2000/svg" width="12" height="13" viewBox="0 0 12 13" fill="none">
            <path d="M9.6175 1.375H2.3825C1.5515 1.375 0.875 2.051 0.875 2.8825V10.118C0.875 10.949 1.551 11.6255 2.3825 11.6255H9.618C10.449 11.6255 11.1255 10.9495 11.1255 10.118V2.8825C11.125 2.051 10.449 1.375 9.6175 1.375ZM10.522 10.1175C10.522 10.616 10.1165 11.022 9.6175 11.022H2.3825C1.884 11.022 1.478 10.6165 1.478 10.1175V9.027L3.911 6.3235L7.1975 9.311L9.015 7.7965L10.5225 9.0525L10.522 10.1175ZM10.522 8.268L9.0145 7.012L7.214 8.512L3.8685 5.47L1.478 8.126V2.8825C1.478 2.384 1.8835 1.978 2.3825 1.978H9.618C10.1165 1.978 10.5225 2.3835 10.5225 2.8825L10.522 8.268Z" fill="white" stroke="white" stroke-width="0.6"/>
            <path d="M8.11102 5.89684C8.94202 5.89684 9.61852 5.22084 9.61852 4.38934C9.61852 3.55784 8.94252 2.88184 8.11102 2.88184C7.28002 2.88184 6.60352 3.55784 6.60352 4.38934C6.60352 5.22084 7.27952 5.89684 8.11102 5.89684ZM8.11102 3.48534C8.60952 3.48534 9.01552 3.89084 9.01552 4.38984C9.01552 4.88884 8.61002 5.29434 8.11102 5.29434C7.61202 5.29434 7.20652 4.88884 7.20652 4.38984C7.20652 3.89084 7.61202 3.48534 8.11102 3.48534Z" fill="white" stroke="white" stroke-width="0.6"/>
          </svg>
          {{ lang::translate('home.gallery-image') }}
        </div>
        <figure><img src="{{ media::initial($gallery_image->thumbnail)->url }}" width="635" height="360" loading="lazy" decoding="async" alt="{{ media::initial($gallery_image->thumbnail)->alt }}"></figure>
        <figcaption>
          <span class="date">{{ date2string($gallery_image->date) }}</span>
          <p>{{ $gallery_image->translated('title') }}</p>
        </figcaption>
      </div>
      @endif
      @if ($gallery_video != null)
      <div class="grid__item" data-video="{{ $gallery_video->iframe }}">
        <div class="tag video">
          <svg xmlns="http://www.w3.org/2000/svg" width="12" height="13" viewBox="0 0 12 13" fill="none">
            <path d="M9.6175 1.375H2.3825C1.5515 1.375 0.875 2.051 0.875 2.8825V10.118C0.875 10.949 1.551 11.6255 2.3825 11.6255H9.618C10.449 11.6255 11.1255 10.9495 11.1255 10.118V2.8825C11.125 2.051 10.449 1.375 9.6175 1.375ZM10.522 10.1175C10.522 10.616 10.1165 11.022 9.6175 11.022H2.3825C1.884 11.022 1.478 10.6165 1.478 10.1175V9.027L3.911 6.3235L7.1975 9.311L9.015 7.7965L10.5225 9.0525L10.522 10.1175ZM10.522 8.268L9.0145 7.012L7.214 8.512L3.8685 5.47L1.478 8.126V2.8825C1.478 2.384 1.8835 1.978 2.3825 1.978H9.618C10.1165 1.978 10.5225 2.3835 10.5225 2.8825L10.522 8.268Z" fill="white" stroke="white" stroke-width="0.6"/>
            <path d="M8.11102 5.89684C8.94202 5.89684 9.61852 5.22084 9.61852 4.38934C9.61852 3.55784 8.94252 2.88184 8.11102 2.88184C7.28002 2.88184 6.60352 3.55784 6.60352 4.38934C6.60352 5.22084 7.27952 5.89684 8.11102 5.89684ZM8.11102 3.48534C8.60952 3.48534 9.01552 3.89084 9.01552 4.38984C9.01552 4.88884 8.61002 5.29434 8.11102 5.29434C7.61202 5.29434 7.20652 4.88884 7.20652 4.38984C7.20652 3.89084 7.61202 3.48534 8.11102 3.48534Z" fill="white" stroke="white" stroke-width="0.6"/>
          </svg>
          {{ lang::translate('home.gallery-video') }}
        </div>
        <figure>
          <img src="{{ media::initial($gallery_video->thumbnail)->url }}" width="635" height="360" loading="lazy" decoding="async" loading="lazy" alt="{{ media::initial($gallery_video->thumbnail)->alt }}">
        </figure>
        <figcaption>
          <span class="date">{{ date2string($gallery_video->date) }}</span>
          <p>{{ $gallery_video->translated('title') }}</p>
        </figcaption>
        <div class="icon-play">
          <svg xmlns="http://www.w3.org/2000/svg" width="66" height="66" viewBox="0 0 66 66" fill="none">
            <path d="M64.6206 17.1146C63.8616 14.2748 61.6256 12.0387 58.7858 11.2798C53.6383 9.90039 32.9997 9.90039 32.9997 9.90039C32.9997 9.90039 12.3612 9.90039 7.21359 11.2798C4.37443 12.0387 2.13778 14.2748 1.37878 17.1146C0 22.2616 0 33.0005 0 33.0005C0 33.0005 0 43.7394 1.37878 48.8859C2.13778 51.7257 4.37443 53.9624 7.21359 54.7212C12.3612 56.1001 32.9997 56.1001 32.9997 56.1001C32.9997 56.1001 53.6383 56.1001 58.7858 54.7212C61.6256 53.9624 63.8616 51.7257 64.6206 48.8859C66 43.7394 66 33.0005 66 33.0005C66 33.0005 66 22.2616 64.6206 17.1146Z" fill="#ED1F24"/>
            <path d="M26.4004 42.9018L43.5472 33.0017L26.4004 23.1016V42.9018Z" fill="white"/>
          </svg>
        </div>
      </div>
      @endif
    </div>
  </section>
  <section class="statistik animating-scroll" data-animate-trigger=".trigger-5">
    <div class="trigger trigger-5"></div>
    <div class="wrapper">
      @foreach(widget($home->id, 'menu', 'statistik') as $statistik)
      <div class="statistik__left box">
        <h5>{{ $statistik->translated('title') }}</h5>
        <div class="wrap-chart">
          <canvas id="statusChart"></canvas>
        </div>
        @php($cta = $statistik->childs('button-cta')->first())
        @if ($cta)
        <a href="{{ $cta->translated('link') }}" target="{{ $cta->target }}" class="button button-outline">
          <span>{{ $cta->translated('label') }}</span>
          <div class="wave"></div>
        </a>
        @endif
      </div>
      @endforeach
      @foreach(widget($home->id, 'menu', 'rating') as $home_rating)
      <div class="statistik__right box">
        <h5>{{ $home_rating->translated('title') }}</h5>
        <div class="rating-box">
          <div class="rating-summary">
            <h2 id="average">0.0</h2>
            <div class="stars" id="stars"></div>
            <small id="total-reviews" data-title="{{ lang::translate('home.rating.total') }}">0 Penilaian</small>
          </div>
          <div class="rating-breakdown" id="ratingBreakdown"></div>
        </div>
        <p>{{ $home_rating->translated('intro') }}</p>
        <a href="javascript:void(0)" class="button button-outline" id="button-open-rating">
          <span>{{ $home_rating->translated('button') }}</span>
          <div class="wave"></div>
        </a>
      </div>
      @endforeach
    </div>
  </section>
  @foreach (widget($home->id, 'menu', 'institution') as $data)
  <section class="partner animating-scroll" data-animate-trigger=".trigger-6">
    <div class="trigger trigger-6"></div>
    <div class="wrapper">
      <h5>{{ $data->translated('title') }}</h5>
    </div>
    <div class="logo-slider swiper">
      <div class="swiper-arrow swiper-prev"></div>
      <div class="swiper-arrow swiper-next"></div>
      <div class="swiper-wrapper">
        @foreach ($data->childs('institution-images') as $image)
        <a href="{{ $image->link }}" target="__BLANK" class="swiper-slide">
          <img src="{{ media::initial($image->image)->url }}" loading="lazy" decoding="async" alt="{{ media::initial($image->image)->alt }}">
        </a>
        @endforeach
      </div>
    </div>
  </section>
  @endforeach
  <div class="popup popup-rating" id="popup-rating">
    <div class="popup__overlay"></div>
    <div class="popup__box popup__box--large">
      <div class="popup__content box-form">
        <h6>{{ lang::translate('home.rating.popup.title') }}</h6>
        <form action="{{ lang::url('rating/submit') }}" id="form-rating" method="POST">
          @csrf
          <div class="row row-wrap">
            <div class="column column-100">
              <label for="">{{ lang::translate('home.rating.popup.form.title.rating') }}<i>*</i></label>
              <div class="rates">
                <input type="radio" id="starR5" name="rating" value="5" data-required-radio="rating">
                <label for="starR5">
                <svg xmlns="http://www.w3.org/2000/svg" width="26.522" height="24.864" viewBox="0 0 26.522 24.864">
                    <path id="star" d="M12.539,1.515a.8.8,0,0,1,1.444,0L17.05,7.951a.8.8,0,0,0,.624.45l7.138.884a.8.8,0,0,1,.445,1.381L20.025,15.5a.8.8,0,0,0-.242.74L21.133,23.2a.8.8,0,0,1-1.167.856l-6.324-3.432a.8.8,0,0,0-.763,0L6.555,24.055A.8.8,0,0,1,5.388,23.2l1.351-6.956A.8.8,0,0,0,6.5,15.5L1.265,10.667A.8.8,0,0,1,1.71,9.285L8.847,8.4a.8.8,0,0,0,.624-.45Z" fill="#e6e6e6"/>
                </svg>
                </label>
                <input type="radio" id="starR4" name="rating" value="4" data-required-radio="rating">
                <label for="starR4">
                <svg xmlns="http://www.w3.org/2000/svg" width="26.522" height="24.864" viewBox="0 0 26.522 24.864">
                    <path id="star" d="M12.539,1.515a.8.8,0,0,1,1.444,0L17.05,7.951a.8.8,0,0,0,.624.45l7.138.884a.8.8,0,0,1,.445,1.381L20.025,15.5a.8.8,0,0,0-.242.74L21.133,23.2a.8.8,0,0,1-1.167.856l-6.324-3.432a.8.8,0,0,0-.763,0L6.555,24.055A.8.8,0,0,1,5.388,23.2l1.351-6.956A.8.8,0,0,0,6.5,15.5L1.265,10.667A.8.8,0,0,1,1.71,9.285L8.847,8.4a.8.8,0,0,0,.624-.45Z" fill="#e6e6e6"/>
                </svg>
                </label>
                <input type="radio" id="starR3" name="rating" value="3" data-required-radio="rating">
                <label for="starR3">
                <svg xmlns="http://www.w3.org/2000/svg" width="26.522" height="24.864" viewBox="0 0 26.522 24.864">
                    <path id="star" d="M12.539,1.515a.8.8,0,0,1,1.444,0L17.05,7.951a.8.8,0,0,0,.624.45l7.138.884a.8.8,0,0,1,.445,1.381L20.025,15.5a.8.8,0,0,0-.242.74L21.133,23.2a.8.8,0,0,1-1.167.856l-6.324-3.432a.8.8,0,0,0-.763,0L6.555,24.055A.8.8,0,0,1,5.388,23.2l1.351-6.956A.8.8,0,0,0,6.5,15.5L1.265,10.667A.8.8,0,0,1,1.71,9.285L8.847,8.4a.8.8,0,0,0,.624-.45Z" fill="#e6e6e6"/>
                </svg>
                </label>
                <input type="radio" id="starR2" name="rating" value="2" data-required-radio="rating">
                <label for="starR2">
                <svg xmlns="http://www.w3.org/2000/svg" width="26.522" height="24.864" viewBox="0 0 26.522 24.864">
                    <path id="star" d="M12.539,1.515a.8.8,0,0,1,1.444,0L17.05,7.951a.8.8,0,0,0,.624.45l7.138.884a.8.8,0,0,1,.445,1.381L20.025,15.5a.8.8,0,0,0-.242.74L21.133,23.2a.8.8,0,0,1-1.167.856l-6.324-3.432a.8.8,0,0,0-.763,0L6.555,24.055A.8.8,0,0,1,5.388,23.2l1.351-6.956A.8.8,0,0,0,6.5,15.5L1.265,10.667A.8.8,0,0,1,1.71,9.285L8.847,8.4a.8.8,0,0,0,.624-.45Z" fill="#e6e6e6"/>
                </svg>
                </label>
                <input type="radio" id="starR1" name="rating" value="1" data-required-radio="rating">
                <label for="starR1">
                <svg xmlns="http://www.w3.org/2000/svg" width="26.522" height="24.864" viewBox="0 0 26.522 24.864">
                    <path id="star" d="M12.539,1.515a.8.8,0,0,1,1.444,0L17.05,7.951a.8.8,0,0,0,.624.45l7.138.884a.8.8,0,0,1,.445,1.381L20.025,15.5a.8.8,0,0,0-.242.74L21.133,23.2a.8.8,0,0,1-1.167.856l-6.324-3.432a.8.8,0,0,0-.763,0L6.555,24.055A.8.8,0,0,1,5.388,23.2l1.351-6.956A.8.8,0,0,0,6.5,15.5L1.265,10.667A.8.8,0,0,1,1.71,9.285L8.847,8.4a.8.8,0,0,0,.624-.45Z" fill="#e6e6e6"/>
                </svg>
                </label>
                <div class="supporting-text">@error('name'){{ $message }}@enderror</div>
              </div>
            </div>
            <div class="column column-100">
              <label for="">{{ lang::translate('home.rating.popup.form.title.name') }}<i>*</i></label>
              <input type="text" name="name" class="required" maxlength="255" placeholder="{{ lang::translate('home.rating.popup.form.placeholder.name') }}">
              <div class="supporting-text">@error('name'){{ $message }}@enderror</div>
            </div>
            <div class="column column-100">
              <label for="">{{ lang::translate('home.rating.popup.form.title.email') }}<i>*</i></label>
              <input type="text" name="email" class="required email" maxlength="255" placeholder="{{ lang::translate('home.rating.popup.form.placeholder.email') }}">
              <div class="supporting-text">@error('email'){{ $message }}@enderror</div>
            </div>
            <div class="column column-100">
              <label for="">{{ lang::translate('home.rating.popup.form.title.comment') }}<i>*</i></label>
              <textarea name="comment" class="required" maxlength="500" placeholder="{{ lang::translate('home.rating.popup.form.placeholder.comment') }}"></textarea>
              <div class="supporting-text">@error('comment'){{ $message }}@enderror</div>
            </div>
            <div class="column column-100 recaptcha-validate">
              <div class="recaptcha-container"></div>
              <div class="supporting-text">@error('g-recaptcha-response'){{ $message }}@enderror</div>
            </div>
            <div class="column column-100">
              <button type="submit" class="button button-gradient">{{ lang::translate('home.rating.popup.form.button') }}</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
  <div class="popup popup-video" id="popup-video">
    <div class="popup__overlay"></div>
    <div class="popup__box popup__box--large">
      <div class="popup__content">
        <div class="wrap-video">
          <iframe src="" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture;" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
        </div>
      </div>
    </div>
  </div>
  @if($gallery_image != null)
  <div class="popup popup-photo" id="popup-photo">
    <div class="popup__overlay"></div>
    <div class="popup__box popup__box--large">
      <div class="popup__close">
        <i class="wa-icon wa-ic-close-solid"></i>
      </div>
      <div class="popup__content">
        <div class="wrap-slider">
          <div class="swiper photo-slider">
            <div class="swiper-wrapper">
              @foreach(widget($gallery_image->id, 'information-gallery', 'image') as $image)
              <div class="swiper-slide">
                <figure>
                  <img src="{{ media::initial($image->image)->url }}" alt="{{ media::initial($image->image)->alt }}">
                  <figcaption>
                    <span class="date">{{ date2string($gallery_image->date) }}</span>
                    <p>{{ $image->translated('title') }}</p>
                  </figcaption>
                </figure>
              </div>
              @endforeach
            </div>
          </div>
          <div class="photo-slider-thumbs swiper">
            <div class="swiper-wrapper">
              @foreach(widget($gallery_image->id, 'information-gallery', 'image') as $image)
              <div class="swiper-slide">
                <figure>
                  <img src="{{ media::initial($image->thumbnail)->url }}" alt="{{ media::initial($image->thumbnail)->alt }}">
                </figure>
              </div>
              @endforeach
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  @endif
  @if($popup->active == 'yes')
    @include('dynamic.component.popup-information')
  @endif
  @if (Session::has('success'))
  <div class="popup" id="popup-center">
    <div class="popup__overlay"></div>
    <div class="popup__box">
      <div class="popup__close">
        <i class="wa-icon wa-ic-close-solid"></i>
      </div>
      <div class="popup__content popup__content--center">
        <img src="{{asset('images/material/checklist-bullet.svg')}}" alt="">
        <h3>{{ lang::translate('home.rating.popup-success.title') }}</h3>
        <p>{{ lang::translate('home.rating.popup-success.message') }}</p>
        <a href="" class="button button-gradient">{{ lang::translate('home.rating.popup-success.button') }}</a>
      </div>
    </div>
  </div>
  @endif
  <!-- end of middle -->
  @push('head')
    <link rel="preload" href="{{ Vite::asset('resources/assets/sass/pages/home.scss') }}"
      as="style"
      onload="this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="{{ Vite::asset('resources/assets/sass/pages/home.scss') }}"></noscript>
    <style>
      button.is-disabled {
        background: grey !important;
        pointer-events: none;
      }
      .banner-homepage__caption .wrap-filter {
        position: relative;
        z-index: 5 !important;
      }
      .banner-homepage__caption .wrap-filter .filter {
        z-index: 6 !important;
      }
      .banner-stats {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 12px;
        margin-top: 24px;
        width: 100%;
        position: relative;
        z-index: 1;
      }
      .banner-stats__row {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 12px;
        flex-wrap: nowrap;
      }
      .banner-stats__item {
        display: inline-flex;
        align-items: center;
        gap: 9px;
        white-space: nowrap;
        background: rgba(30, 48, 88, 0.55);
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);
        border: 1px solid rgba(255, 255, 255, 0.16);
        border-radius: 9999px;
        padding: 7px 12px 7px 16px;
        color: #ffffff;
        text-decoration: none;
        box-shadow: 0 4px 14px rgba(0, 0, 0, 0.15);
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        cursor: pointer;
      }
      .banner-stats__item:hover {
        background: rgba(45, 70, 125, 0.75);
        border-color: rgba(255, 255, 255, 0.35);
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.25);
        color: #ffffff;
      }
      .banner-stats__item:active {
        transform: translateY(0);
      }
      .banner-stats__icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: rgba(255, 255, 255, 0.9);
        line-height: 1;
      }
      .banner-stats__icon svg {
        width: 16px;
        height: 16px;
        display: block;
      }
      .banner-stats__label {
        font-size: 14px;
        font-weight: 500;
        color: #ffffff;
        line-height: 1;
        letter-spacing: 0.1px;
      }
      .banner-stats__badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 24px;
        padding: 3px 9px;
        background: #F5A623;
        color: #1A2238;
        font-size: 12px;
        font-weight: 700;
        line-height: 1.2;
        border-radius: 9999px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.15);
      }
      @media all and (max-width: 767px) {
        .banner-stats {
          margin-top: 16px;
          gap: 8px;
        }
        .banner-stats__row {
          gap: 8px;
          flex-wrap: wrap;
        }
        .banner-stats__item {
          padding: 6px 10px 6px 12px;
          gap: 7px;
        }
        .banner-stats__label {
          font-size: 12.5px;
        }
        .banner-stats__badge {
          font-size: 11px;
          padding: 2px 7px;
        }
      }
    </style>
  @endpush
  @push('footer')
    <script type="module" async type="text/javascript" src="{{ Vite::asset('resources/assets/js/home.js') }}"></script>
    <script src="https://www.google.com/recaptcha/api.js?hl={{\App::getLocale()}}" async defer></script>
    <script>
      const ratingData = {
        average: {{ $avg_rating }},
        total: {{ $total_rating }},
        breakdown: {!! $rating !!}
      };
    </script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
      document.addEventListener("DOMContentLoaded", function(event) { 
        @if (Session::has('success'))
        openPopup('#popup-center');
        @else
        @if($popup->active == 'yes')
          @if($popup->sessionDisplay == 'yes')
            function checkCookie() {
                    var username = getCookie("popupinfo");
                    if (username == "") {
                        setCookie("popupinfo", "ok", {{ is_null($popup->sessionTime) ? 2 : $popup->sessionTime }});
                        openPopup('#popup-home');
                    }
                }

                function setCookie(cname, cvalue, exdays) {
                    var d = new Date();
                    let intervalExp = 60*1000; // in minutes
                    // let intervalExp = 60*60*1000; // in hour
                    d.setTime(d.getTime() + (exdays*intervalExp));
                    var expires = "expires="+ d.toUTCString();
                    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
                }

                function getCookie(cname) {
                    var name = cname + "=";
                    var decodedCookie = decodeURIComponent(document.cookie);
                    var ca = decodedCookie.split(';');
                    for(var i = 0; i < ca.length; i++) {
                        var c = ca[i];
                        while (c.charAt(0) == ' ') {
                            c = c.substring(1);
                        }
                        if (c.indexOf(name) == 0) {
                            return c.substring(name.length, c.length);
                        }
                    }
                  return "";
                }

                checkCookie();
          @else
            openPopup('#popup-home');
          @endif
        @endif
        @endif

        document.getElementById('button-open-rating').addEventListener('click', function (e) {
          openPopup('#popup-rating')
          resetRecaptcha('.recaptcha-container');
        })

        document.querySelector('#frm-specific-search').addEventListener('submit', function(e) {
          e.preventDefault();

          const inputValue = document.querySelector('.search-top').value;
          document.querySelector('.hidden-search').value = inputValue;

          this.submit();
        });

        // Normalisasi SpeechRecognition
        const SpeechRecognition =
          window.SpeechRecognition ||
          window.webkitSpeechRecognition ||
          window.mozSpeechRecognition ||
          window.msSpeechRecognition;

        const btn = document.getElementById('btnToggle');
        const input = document.getElementById('searchPeraturan');

        if (!SpeechRecognition) {
          // alert hanya saat klik tombol
          btn.addEventListener('click', () => {
            alert('Browser Anda tidak mendukung Speech Recognition.');
          });
        } else {
          // --- BUAT INSTANCE SEKALI ---
          const rec = new SpeechRecognition();
          rec.lang = 'id-ID';
          rec.continuous = true;
          rec.interimResults = true;

          let recognizing = false;
          let finalTranscript = '';

          // --- EVENT HANDLERS ---

          rec.onstart = () => {
            recognizing = true;
          };

          rec.onend = () => {
            recognizing = false;
          };

          rec.onerror = (e) => {
            console.error('SpeechRecognition Error:', e);
          };

          rec.onresult = (event) => {
            let interim = '';
            for (let i = event.resultIndex; i < event.results.length; i++) {
              const result = event.results[i];
              if (result.isFinal) finalTranscript += result[0].transcript + ' ';
              else interim += result[0].transcript;
            }
            input.value = finalTranscript + interim;
          };

          // --- BUTTON CLICK ---

          btn.addEventListener('click', () => {
            if (!recognizing) {
              finalTranscript = input.value || '';
              rec.start();
            } else {
              rec.stop();
            }
          });
        }

        const ctx = $("#statusChart");
        new Chart(ctx, {
          type: "bar",
          data: {
            labels: @json($get_chart['berlaku']['year']),
            datasets: [
              {
                label: "{{ lang::translate('home.chart.berlaku') }}",
                data: @json($get_chart['berlaku']['data']),
                backgroundColor: "#2063D2",
                borderRadius: 8,
                barPercentage: 0.8,
                categoryPercentage: 0.8
              },
              {
                label: "{{ lang::translate('home.chart.tidak-berlaku') }}",
                data: @json($get_chart['tidak-berlaku']['data']),
                backgroundColor: "#8DB7FF",
                borderRadius: 8,
                barPercentage: 0.8,
                categoryPercentage: 0.8
              }
            ]
          },
          options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
              x: {
                grid: {
                  color: "#E5E7EB", // Warna garis halus
                  drawBorder: false,
                  offset: false
                },
                ticks: {
                  font: {
                    size: 14
                  },
                  color: "#333"
                },
                border: {
                  display: true,
                  color: "#000"
                }
              },
              y: {
                beginAtZero: true,
                max: 100,
                grid: {
                  color: "#E5E7EB"
                },
                ticks: {
                  stepSize: 20,
                  font: {
                    size: 13
                  },
                  color: "#333"
                },
                border: {
                  display: false
                }
              }
            },
            plugins: {
            legend: {
              position: "bottom",
              align:"start",
              labels: {
                usePointStyle: true,
                pointStyle: "circle",
                boxWidth: 11,
                boxHeight: 11,
                textAlign: "left",
                padding: 20,
                font: { size: 11 },
                color: "#373737",
                boxPadding: 6  
              }
            }
          }
          }
        });

        document.getElementById("form-rating").addEventListener("submit", function (e) {
          let valid = true;
          const submitBtn = this.querySelector('button[type=submit]');
          submitBtn.textContent = "{{ lang::translate('home.rating.popup.form.process') }}";
          submitBtn.disabled = true;
          submitBtn.classList.add("is-disabled");

          // ambil semua input di dalam form
          const inputs = this.querySelectorAll(".column input, .column textarea");
          inputs.forEach(input => {
            const parent = input.closest(".column");
            const msgBox = parent.querySelector(".supporting-text");

            // reset error terlebih dahulu
            parent.classList.remove("error-field");
            msgBox.textContent = "";

            const value = input.value.trim();

            // RULE: required
            if (input.classList.contains("required") && value === "") {
                parent.classList.add("error-field");
                msgBox.textContent = "{{ lang::translate('global.form-error.required') }}";
                valid = false;
                // return;
            }

            // RULE: email
            if (input.classList.contains("email") && value !== "" && !validateEmail(value)) {
                parent.classList.add("error-field");
                msgBox.textContent = "{{ lang::translate('global.form-error.email') }}";
                valid = false;
                // return;
            }

            // RULE: maxlength (baru)
            const max = input.getAttribute("maxlength");
            if (max && value.length > parseInt(max)) {
                parent.classList.add("error-field");
                msgBox.textContent = `{{ lang::translate('global.form-error.maxlength') }}`;
                msgBox.textContent = msgBox.textContent.replace(':max', max);
                valid = false;
                // return;
            }

            // RULE: minlength (baru)
            const min = input.getAttribute("minlength");
            if (min && value.length < parseInt(min)) {
              parent.classList.add("error-field");
              msgBox.textContent = `{{ lang::translate('global.form-error.minlength') }}`;
              msgBox.textContent = msgBox.textContent.replace(':min', min);
              valid = false;
              // return;
            }

            // --- VALIDASI REQUIRED RADIO (khusus rating) ---
            let ratingRadios = parent.querySelectorAll("input[data-required-radio='rating']");
            if (ratingRadios.length > 0) {
              let checked = Array.from(ratingRadios).some(r => r.checked);
              if (!checked) {
                valid = false;

                // Tambahkan error ke wrapper .rates
                let errBox = parent.querySelector(".rates .supporting-text");
                if (errBox) errBox.textContent = "Harap pilih rating.";

                // Tandai radio dg class error (opsional)
                parent.classList.add("error-field");
              }
            }
          });

          const recaptchaField = document.querySelector(".recaptcha-validate textarea[name='g-recaptcha-response']");
          if (recaptchaField) {
              const recaptchaValue = recaptchaField.value.trim();

              if (recaptchaValue === "") {
                  // tampilkan error recaptcha di bagian custom
                  const recaptchaContainer = document.querySelector(".recaptcha-validate");
                  if (recaptchaContainer) {
                      recaptchaContainer.classList.add("error-field");

                      let msg = recaptchaContainer.querySelector(".supporting-text");
                      if (!msg) {
                          msg = document.createElement("div");
                          msg.classList.add("supporting-text");
                          recaptchaContainer.appendChild(msg);
                      }

                      msg.textContent = "{{ lang::translate('global.form-error.recaptcha') }}";
                  }

                  valid = false;
              }
          }

          // jika tidak valid, cegah submit
          if (!valid) {
            e.preventDefault();
            submitBtn.textContent = "{{ lang::translate('home.rating.popup.form.button') }}";
            submitBtn.disabled = false;
            submitBtn.classList.remove("is-disabled");
          }
        });

        // fungsi regex email
        function validateEmail(email) {
            const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return re.test(email);
        }
      })
   
    </script>
  @endpush
@endsection
