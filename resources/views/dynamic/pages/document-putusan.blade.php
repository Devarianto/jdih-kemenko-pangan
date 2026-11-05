@extends('dynamic.layouts.layout')

@section('content')
  @include('dynamic.component.banner')
  <section class="middle">
    <div class="wrapper">
      
      <div class="middle__search putusan-search-card">
        {{-- Integrated Classification Filter Tabs inside Search Card --}}
        <div class="putusan-filter-bar">
          <div class="putusan-filter-label">
            <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
              <polyline points="14 2 14 8 20 8"></polyline>
              <line x1="16" y1="13" x2="8" y2="13"></line>
              <line x1="16" y1="17" x2="8" y2="17"></line>
            </svg>
            <span>Lembaga Peradilan:</span>
          </div>
          <div class="putusan-filter-tabs">
            <a href="{{ route('putusan-hukum') }}" class="putusan-pill @if(empty($court)) active @endif">
              <span class="pill-dot"></span>
              <span>Semua Putusan</span>
            </a>
            <a href="{{ route('putusan.ma') }}" class="putusan-pill @if(isset($court) && $court === 'MA') active @endif">
              <span class="pill-badge ma">MA</span>
              <span>Mahkamah Agung</span>
            </a>
            <a href="{{ route('putusan.mk') }}" class="putusan-pill @if(isset($court) && $court === 'MK') active @endif">
              <span class="pill-badge mk">MK</span>
              <span>Mahkamah Konstitusi</span>
            </a>
          </div>
        </div>

        <form action="" method="GET">
          @if(request()->filled('sort'))
            <input type="hidden" name="sort" value="{{ request()->query('sort') }}">
          @endif
          <div class="row">
            <div class="column column-65">
              <label for="putusan-search-input">{{ lang::translate('document.search-putusan.title') }}</label>
              <input type="text" id="putusan-search-input" name="search" value="{{ request()->query('search') }}" placeholder="{{ lang::translate('document.search-putusan.placeholder') }}">
            </div>
            <div class="column column-20">
              <label for="putusan-year-select">{{ lang::translate('document.search-putusan.form-title.year') }}</label>
              <select name="year" id="putusan-year-select">
                <option value="">{{ lang::translate('document.search-putusan.form-placeholder.year') }}</option>
                @foreach ($years as $data)
                  <option value="{{ $data->year }}" @selected($data->year == request()->query('year'))>{{ $data->year }}</option>
                @endforeach
              </select>
            </div>
            <div class="column column-15">
              <button type="submit" class="button-icon button-gradient">
                {{ lang::translate('document.search-putusan.button') }}
                <i class="wa-icon wa-ic-search-outline"></i>
              </button>
            </div>
          </div>
        </form>
      </div>

      <div class="filter-right">
        <form action="">
          <div class="col">
            <label for="putusan-sort-select">{{ lang::translate('global.sorting.title') }}</label>
            <select name="sort" id="putusan-sort-select">
              <option value="latest" @selected(request()->query('sort', 'latest') == 'latest')>{{ lang::translate('global.sorting.latest') }}</option>
              <option value="oldest" @selected(request()->query('sort') == 'oldest')>{{ lang::translate('global.sorting.oldest') }}</option>
            </select>
          </div>
        </form>
      </div>

      <div class="listing-rules without-bottom">
        @forelse($documents as $document)
          <a href="{{ $document->customPermalink('document-putusan') ?: url('/document-putusan/' . $document->id) }}" class="listing-rules__item">
            <figure><img src="{{ media::initial($document->thumbnail)->url }}" alt="{{ media::initial($document->thumbnail)->alt }}"></figure>
            <figcaption>
              <div class="wrap-flex">
                <div class="text">
                  <div class="tags-group" style="display: flex; gap: 8px; align-items: center; margin-bottom: 8px; flex-wrap: wrap;">
                    <span class="category" @if (!$document->status_berlaku) style="background-color: #C25A5A;" @endif>{{ $document->front_status_berlaku }}</span>
                    {!! $document->court_badge !!}
                    @if(!empty($document->no_putusan))
                      <span class="tag" style="background: rgba(15, 23, 42, 0.06); color: #334155; border: 1px solid rgba(15, 23, 42, 0.12); font-weight: 600;">No: {{ $document->no_putusan }}</span>
                    @endif
                  </div>
                  <p class="title" style="font-weight: 600; font-size: 16px; line-height: 1.45; margin-bottom: 6px;">{{ $document->translated('title') }}</p>
                  @if(!empty($document->translated('pokok_perkara')))
                    <p class="pokok-perkara" style="font-size: 13px; color: #64748b; line-height: 1.4; margin-bottom: 6px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                      <strong>Pokok Perkara:</strong> {{ $document->translated('pokok_perkara') }}
                    </p>
                  @elseif(!empty($document->translated('intro')))
                    <p class="intro" style="font-size: 13px; color: #64748b; line-height: 1.4; margin-bottom: 6px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                      {{ $document->translated('intro') }}
                    </p>
                  @endif
                </div>
                <span class="button button-outline">{{ lang::translate('document.read-more') }}</span>
              </div>
              <div class="bottom">
                <div class="bottom__left" style="display: flex; gap: 16px; align-items: center;">
                  @if(!empty($document->tanggal_dibacakan))
                    <small style="color: #64748b; font-size: 12px; display: inline-flex; align-items: center; gap: 4px;">
                      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                      Dibacakan: {{ num2string($document->tanggal_dibacakan) }}
                    </small>
                  @elseif(!empty($document->year))
                    <small style="color: #64748b; font-size: 12px; display: inline-flex; align-items: center; gap: 4px;">
                      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                      Tahun {{ $document->year }}
                    </small>
                  @endif
                  <small class="visited">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                      <path d="M8 3.5C4.967 3.5 2.399 5.388 1.5 8C2.399 10.612 4.967 12.5 8 12.5C11.033 12.5 13.601 10.612 14.5 8C13.601 5.388 11.033 3.5 8 3.5Z" stroke="#999999" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                      <path d="M8 10.5C9.38071 10.5 10.5 9.38071 10.5 8C10.5 6.61929 9.38071 5.5 8 5.5C6.61929 5.5 5.5 6.61929 5.5 8C5.5 9.38071 6.61929 10.5 8 10.5Z" stroke="#999999" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    {{ lang::translate('document.count.view', ['count' => $document->view_count]) }}
                  </small>
                </div>
              </div>
            </figcaption>
          </a>
        @empty
          <div class="empty-state-card" style="text-align: center; padding: 48px 24px; background: #ffffff; border-radius: 12px; border: 1px dashed #cbd5e1; margin: 30px 0;">
            <div style="width: 56px; height: 56px; border-radius: 50%; background: #f1f5f9; display: inline-flex; align-items: center; justify-content: center; margin-bottom: 16px; color: #64748b;">
              <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                <polyline points="14 2 14 8 20 8"></polyline>
                <line x1="9" y1="15" x2="15" y2="15"></line>
              </svg>
            </div>
            <h5 style="font-size: 18px; font-weight: 600; color: #1e293b; margin-bottom: 6px;">{{ lang::translate('global.search-not-found') }}</h5>
            <p style="font-size: 13.5px; color: #64748b; max-width: 460px; margin: 0 auto 20px;">
              @if(isset($court) && $court === 'MA')
                Belum ada dokumen Putusan Mahkamah Agung (MA) yang sesuai dengan kriteria pencarian Anda.
              @elseif(isset($court) && $court === 'MK')
                Belum ada dokumen Putusan Mahkamah Konstitusi (MK) yang sesuai dengan kriteria pencarian Anda.
              @else
                Belum ada data dokumen putusan yang sesuai dengan kata kunci pencarian.
              @endif
            </p>
            @if(request()->has('search') || request()->has('year') || !empty($court))
              <a href="{{ route('putusan-hukum') }}" class="button button-outline" style="border-radius: 9999px; font-size: 12px; padding: 8px 20px;">
                Reset Pencarian & Tampilkan Semua Putusan
              </a>
            @endif
          </div>
        @endforelse
      </div>
      {{ $documents->appends(request()->query())->links('dynamic.component.pagination') }}
    </div>
  </section>
  
  @push('head')
    <link rel="stylesheet" type="text/css" href="{{ Vite::asset('resources/assets/sass/pages/document.scss')}}" preload>
    <style>
      .putusan-search-card {
        padding: 32px 42px 28px !important;
      }
      .putusan-filter-bar {
        display: flex;
        align-items: center;
        justify-content: flex-start;
        gap: 16px;
        margin-bottom: 22px;
        padding-bottom: 18px;
        border-bottom: 1px solid rgba(0, 0, 0, 0.08);
        flex-wrap: wrap;
      }
      .putusan-filter-label {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        font-size: 12px;
        font-weight: 700;
        color: #475569;
        text-transform: uppercase;
        letter-spacing: 0.6px;
      }
      .putusan-filter-label svg {
        color: #b91c1c;
      }
      .putusan-filter-tabs {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
      }
      .putusan-pill {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 7px 16px;
        border-radius: 9999px;
        font-size: 13px;
        font-weight: 600;
        color: #475569;
        background: #ffffff;
        border: 1.5px solid #cbd5e1;
        text-decoration: none !important;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
      }
      .putusan-pill:hover {
        border-color: #94a3b8;
        color: #0f172a;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        transform: translateY(-1px);
      }
      .putusan-pill.active {
        background: linear-gradient(135deg, #b91c1c 0%, #991b1b 100%) !important;
        color: #ffffff !important;
        border-color: #7f1d1d !important;
        box-shadow: 0 4px 14px rgba(185, 28, 28, 0.35) !important;
      }
      .putusan-pill .pill-dot {
        width: 7px;
        height: 7px;
        border-radius: 50%;
        background: #94a3b8;
        transition: background 0.2s ease;
      }
      .putusan-pill.active .pill-dot {
        background: #ffffff;
        box-shadow: 0 0 6px rgba(255, 255, 255, 0.8);
      }
      .putusan-pill .pill-badge {
        display: inline-block;
        padding: 1px 7px;
        border-radius: 999px;
        font-size: 11px;
        font-weight: 800;
        letter-spacing: 0.5px;
        line-height: 1.2;
      }
      .putusan-pill .pill-badge.ma {
        background: #dbeafe;
        color: #1e40af;
      }
      .putusan-pill .pill-badge.mk {
        background: #fee2e2;
        color: #991b1b;
      }
      .putusan-pill.active .pill-badge {
        background: rgba(255, 255, 255, 0.25) !important;
        color: #ffffff !important;
      }
      
      /* Dark mode support */
      [data-theme="dark"] .putusan-search-card {
        background: #18181b !important;
        border: 1px solid rgba(255, 255, 255, 0.1) !important;
      }
      [data-theme="dark"] .putusan-filter-bar {
        border-bottom-color: rgba(255, 255, 255, 0.1);
      }
      [data-theme="dark"] .putusan-filter-label {
        color: #94a3b8;
      }
      [data-theme="dark"] .putusan-pill {
        background: #27272a;
        border-color: rgba(255, 255, 255, 0.12);
        color: #cbd5e1;
      }
      [data-theme="dark"] .putusan-pill:hover {
        background: #3f3f46;
        color: #ffffff;
      }
      [data-theme="dark"] .putusan-pill.active {
        background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%) !important;
        border-color: #ef4444 !important;
        color: #ffffff !important;
      }
      [data-theme="dark"] .empty-state-card {
        background: #18181b !important;
        border-color: rgba(255, 255, 255, 0.12) !important;
      }
      [data-theme="dark"] .empty-state-card h5 {
        color: #f1f5f9 !important;
      }
      [data-theme="dark"] .empty-state-card p {
        color: #94a3b8 !important;
      }
      [data-theme="dark"] .tag {
        background: rgba(255, 255, 255, 0.08) !important;
        color: #e2e8f0 !important;
        border-color: rgba(255, 255, 255, 0.15) !important;
      }
      [data-theme="dark"] .pokok-perkara,
      [data-theme="dark"] .intro {
        color: #94a3b8 !important;
      }
    </style>
  @endpush
  @push('footer')
    <script>
      document.addEventListener('DOMContentLoaded', function() {
        const sortSelect = document.getElementById('putusan-sort-select');
        if (sortSelect) {
          sortSelect.addEventListener('change', function() {
            const sort = this.value;
            const url = new URL(window.location.href);
            if (sort) {
              url.searchParams.set('sort', sort);
            } else {
              url.searchParams.delete('sort');
            }
            url.searchParams.set('page', '1');
            window.location.href = url.toString();
          });
        }
      });
    </script>
  @endpush
@endsection
