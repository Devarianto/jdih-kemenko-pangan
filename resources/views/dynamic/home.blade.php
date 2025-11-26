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
      <h6>{{ $banner->translated('title') }}</h6>
      @if ($menus['peraturan'] != null)
      <form action="{{ $menus['peraturan']->permalink }}" id="frm-search">
        <div class="wrap-input">
          <input type="text" id="searchPeraturan" name="search" value="{{ request()->query('search') }}" class="search-top" placeholder="{{ lang::translate('home.search-peraturan.placeholder') }}">
          <button type="button" class="voice" id="btnToggle">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="21" viewBox="0 0 20 21" fill="none">
              <path d="M10 17.375C8.3424 17.375 6.75269 16.7165 5.58058 15.5444C4.40848 14.3723 3.75 12.7826 3.75 11.125C3.75 10.9592 3.81585 10.8003 3.93306 10.6831C4.05027 10.5658 4.20924 10.5 4.375 10.5C4.54076 10.5 4.69973 10.5658 4.81694 10.6831C4.93415 10.8003 5 10.9592 5 11.125C5 12.4511 5.52678 13.7229 6.46447 14.6605C7.40215 15.5982 8.67392 16.125 10 16.125C11.3261 16.125 12.5979 15.5982 13.5355 14.6605C14.4732 13.7229 15 12.4511 15 11.125C15 10.9592 15.0658 10.8003 15.1831 10.6831C15.3003 10.5658 15.4592 10.5 15.625 10.5C15.7908 10.5 15.9497 10.5658 16.0669 10.6831C16.1842 10.8003 16.25 10.9592 16.25 11.125C16.25 12.7826 15.5915 14.3723 14.4194 15.5444C13.2473 16.7165 11.6576 17.375 10 17.375Z" fill="#2063D2" stroke="#2063D2" stroke-width="0.2"/>
              <path d="M10 19.875C9.83424 19.875 9.67527 19.8092 9.55806 19.6919C9.44085 19.5747 9.375 19.4158 9.375 19.25V16.75C9.375 16.5842 9.44085 16.4253 9.55806 16.3081C9.67527 16.1908 9.83424 16.125 10 16.125C10.1658 16.125 10.3247 16.1908 10.4419 16.3081C10.5592 16.4253 10.625 16.5842 10.625 16.75V19.25C10.625 19.4158 10.5592 19.5747 10.4419 19.6919C10.3247 19.8092 10.1658 19.875 10 19.875Z" fill="#2063D2" stroke="#2063D2" stroke-width="0.2"/>
              <path d="M10 14.875C9.00544 14.875 8.05161 14.4799 7.34835 13.7767C6.64509 13.0734 6.25 12.1196 6.25 11.125V4.875C6.25 3.88044 6.64509 2.92661 7.34835 2.22335C8.05161 1.52009 9.00544 1.125 10 1.125C10.9946 1.125 11.9484 1.52009 12.6517 2.22335C13.3549 2.92661 13.75 3.88044 13.75 4.875V11.125C13.75 12.1196 13.3549 13.0734 12.6517 13.7767C11.9484 14.4799 10.9946 14.875 10 14.875ZM10 2.375C9.33696 2.375 8.70107 2.63839 8.23223 3.10723C7.76339 3.57607 7.5 4.21196 7.5 4.875V11.125C7.5 11.788 7.76339 12.4239 8.23223 12.8928C8.70107 13.3616 9.33696 13.625 10 13.625C10.663 13.625 11.2989 13.3616 11.7678 12.8928C12.2366 12.4239 12.5 11.788 12.5 11.125V4.875C12.5 4.21196 12.2366 3.57607 11.7678 3.10723C11.2989 2.63839 10.663 2.375 10 2.375Z" fill="#2063D2" stroke="#2063D2" stroke-width="0.2"/>
            </svg>
          </button>
          <button type="submit" class="search">
            {{ lang::translate('home.search-peraturan.button') }}
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="21" viewBox="0 0 20 21" fill="none">
              <path d="M9.16667 16.3333C12.8486 16.3333 15.8333 13.3486 15.8333 9.66667C15.8333 5.98477 12.8486 3 9.16667 3C5.48477 3 2.5 5.98477 2.5 9.66667C2.5 13.3486 5.48477 16.3333 9.16667 16.3333Z" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
              <path d="M17.625 17.625L14 14" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
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
            <figure><img src="{{ media::initial($document->thumbnail)->url }}" alt="{{ media::initial($document->thumbnail)->alt }}"></figure>
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
      alt="{{ media::initial($data->image)->alt }}">
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
      <div class="tema__listing">
        @foreach ($rule_themes as $data)
        <a href="{{ $menus['peraturan']->permalink.'?theme='.$data->id }}" class="tema__listing--item">
          <figure><img src="{{ media::initial($data->image)->url }}" alt="{{ media::initial($data->image)->alt }}"></figure>
          <figcaption>
            <span class="ico"><img src="{{ media::initial($data->icon)->url }}" alt="{{ media::initial($data->icon)->alt }}"></span>
            <h6>{{ $data->label }}</h6>
          </figcaption>
        </a>
        @endforeach
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
                <figure><img src="{{ media::initial($document->thumbnail)->url }}" alt="{{ media::initial($document->thumbnail)->alt }}"></figure>
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
              <a href="{{ $menus['monografi']->permalink }}" class="readmore">{{ lang::translate('home.read-more') }}</a>
            </div>
            <div class="listing-card">
              @foreach ($document_peraturan as $document)
              <a href="{{ $document->permalink_document }}" class="listing-card__item">
                <figure><img src="{{ media::initial($document->thumbnail)->url }}" alt="{{ media::initial($document->thumbnail)->alt }}"></figure>
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
                <figure><img src="{{ media::initial($document->thumbnail)->url }}" alt="{{ media::initial($document->thumbnail)->alt }}"></figure>
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
                <figure><img src="{{ media::initial($document->thumbnail)->url }}" alt="{{ media::initial($document->thumbnail)->alt }}"></figure>
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
                <figure><img src="{{ media::initial($document->thumbnail)->url }}" alt="{{ media::initial($document->thumbnail)->alt }}"></figure>
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
                <figure><img src="{{ media::initial($document->thumbnail)->url }}" alt="{{ media::initial($document->thumbnail)->alt }}"></figure>
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
              <a href="{{ $menus['monografi']->permalink }}" class="readmore">{{ lang::translate('home.read-more') }}</a>
            </div>
            <div class="listing-card">
              @foreach ($document_naskah as $document)
              <a href="{{ $document->permalink_document }}" class="listing-card__item">
                <figure><img src="{{ media::initial($document->thumbnail)->url }}" alt="{{ media::initial($document->thumbnail)->alt }}"></figure>
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
            <figure><img src="{{ media::initial($document->thumbnail)->url }}" alt="{{ media::initial($document->thumbnail)->alt }}"></figure>
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
          <img src="{{ media::initial($news_first->thumbnail_home_large)->url }}" alt="{{ media::initial($news_first->thumbnail_home_large)->alt }}">
        </figure>
        <div class="grid__item--caption">
          <span class="date">{{ date2string($news_first->date) }}</span>
          <h4>{{ $news_first->translated('title') }}</h4>
          <a href="{{ $news_first->permalink }}" class="readmore">{{ lang::translate('news.read-more') }}</a>
        </div>
        <div class="highlight">
          @foreach ($news_others as $news)
          <a href="{{ $news->permalink }}" class="highlight-item">
            <figure><img src="{{ media::initial($news->thumbnail_home_small)->url }}" alt="{{ media::initial($news->thumbnail_home_small)->alt }}"></figure>
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
        <figure><img src="{{ media::initial($gallery_image->thumbnail)->url }}" alt="{{ media::initial($gallery_image->thumbnail)->alt }}"></figure>
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
          <img src="{{ media::initial($gallery_video->thumbnail)->url }}" alt="{{ media::initial($gallery_video->thumbnail)->alt }}">
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
      <div class="swiper-wrapper">
        @foreach ($data->childs('institution-images') as $image)
        <a href="{{ $image->link }}" target="__BLANK" class="swiper-slide">
          <img src="{{ media::initial($image->image)->url }}" alt="{{ media::initial($image->image)->alt }}">
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
            <div class="column column-100 recaptcha-container">
              <div id="recaptcha-container">
              </div>
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
    <link rel="stylesheet" type="text/css" href="{{ Vite::asset('resources/assets/sass/pages/home.scss')}}" preload>
    <style>
      button.is-disabled {
        background: grey !important;
        pointer-events: none;
      }
    </style>
  @endpush
  @push('footer')
    <script type="module" async type="text/javascript" src="{{ Vite::asset('resources/assets/js/document.js') }}"></script>
    <script src="https://www.google.com/recaptcha/api.js?hl={{\App::getLocale()}}" async defer></script>
    <script>
      const ratingData = {
        average: {{ $avg_rating }},
        total: {{ $total_rating }},
        breakdown: {!! $rating !!}
      };
    </script>
    <script type="module" async type="text/javascript" src="{{ Vite::asset('resources/assets/js/home.js') }}"></script>
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
                    // let intervalExp = 60*1000; // in minutes
                    let intervalExp = 60*60*1000; // in hour
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

        let recaptchaWidget = null;
        document.getElementById('button-open-rating').addEventListener('click', function (e) {
          if (recaptchaWidget != null) {
            recaptchaWidget = grecaptcha.reset(recaptchaWidget);
          }

          const old = document.getElementById('recaptcha-container');
          if (old) old.remove();

          const newBox = document.createElement('div');
          newBox.id = 'recaptcha-container';
          document.querySelector('.recaptcha-container').prepend(newBox);

          openPopup('#popup-rating');
          // Render ulang
          recaptchaWidget = grecaptcha.render('recaptcha-container', {
              sitekey: "{{ config('cadmin.cadmin.recaptcha.key') }}"
          });
        })

        document.querySelector('#frm-specific-search').addEventListener('submit', function(e) {
          e.preventDefault();

          const inputValue = document.querySelector('.search-top').value;
          document.querySelector('.hidden-search').value = inputValue;

          this.submit();
        });

        if (!window.SpeechRecognition) {
          alert('Browser Anda tidak mendukung Speech Recognition.');
        } else {
          const rec = new window.SpeechRecognition();
          rec.lang = 'id-ID';
          rec.continuous = true;
          rec.interimResults = true;

          const btn = document.getElementById('btnToggle');
          const input = document.getElementById('searchPeraturan');
          let recognizing = false;
          let finalTranscript = '';

          rec.onresult = (event) => {
            let interim = '';
            for (let i = event.resultIndex; i < event.results.length; i++) {
              const result = event.results[i];
              if (result.isFinal) finalTranscript += result[0].transcript + ' ';
              else interim += result[0].transcript;
            }
            input.value = finalTranscript + interim;
          };

          rec.onerror = (e) => console.error(e);
          rec.onstart = () => recognizing = true;
          rec.onend = () => recognizing = false;

          btn.addEventListener('click', () => {
            if (!recognizing) {
              finalTranscript = input.value || '';
              rec.start();
              // btn.textContent = 'Berhenti';
            } else {
              rec.stop();
              // btn.textContent = 'Mulai Bicara';
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

          const recaptchaField = document.querySelector("textarea[name='g-recaptcha-response']");
          if (recaptchaField) {
              const recaptchaValue = recaptchaField.value.trim();

              if (recaptchaValue === "") {
                  // tampilkan error recaptcha di bagian custom
                  const recaptchaContainer = document.querySelector(".recaptcha-container");
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
