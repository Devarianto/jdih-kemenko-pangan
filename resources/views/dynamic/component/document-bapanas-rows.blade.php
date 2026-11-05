@php
    $peraturanTerkait = isset($document) && method_exists($document, 'getPeraturanTerkaitList') ? $document->getPeraturanTerkaitList() : [];
    $dokumenTerkait = isset($document) && method_exists($document, 'getDokumenTerkaitList') ? $document->getDokumenTerkaitList() : [];
@endphp

<style>
    .jdih-bapanas-tr td::before {
        display: none !important;
    }
    .jdih-bapanas-tr th {
        width: 220px !important;
        vertical-align: top !important;
        padding-top: 14px !important;
        color: #1e293b !important;
        font-weight: 700 !important;
        font-size: 15px !important;
    }
    .jdih-bapanas-tr td {
        vertical-align: middle !important;
        padding: 10px 16px !important;
        font-size: 15px !important;
    }
    .jdih-bapanas-row-highlight th,
    .jdih-bapanas-row-highlight td {
        background-color: #f8fafc !important;
    }
    .jdih-bapanas-list {
        list-style: disc !important;
        padding-left: 20px !important;
        margin: 0 !important;
        line-height: 1.8 !important;
    }
    .jdih-bapanas-list li {
        margin-bottom: 6px !important;
    }
    .jdih-bapanas-list li::marker {
        color: #1e293b !important;
    }
    .jdih-bapanas-link {
        color: #0b57d0 !important;
        text-decoration: none !important;
        font-weight: 500 !important;
        line-height: 1.6 !important;
        transition: color 0.15s ease !important;
    }
    .jdih-bapanas-link:hover {
        color: #003580 !important;
        text-decoration: underline !important;
    }
    .jdih-bapanas-btn-abstract {
        display: inline-flex !important;
        align-items: center !important;
        gap: 6px !important;
        background-color: #0b57d0 !important;
        color: #ffffff !important;
        padding: 6px 16px !important;
        border-radius: 4px !important;
        font-size: 13px !important;
        font-weight: 600 !important;
        text-decoration: none !important;
        box-shadow: 0 1px 2px rgba(0,0,0,0.08) !important;
        transition: background-color 0.15s !important;
    }
    .jdih-bapanas-btn-abstract:hover {
        background-color: #0842a0 !important;
        color: #ffffff !important;
    }
    .jdih-bapanas-btn-download {
        display: inline-flex !important;
        align-items: center !important;
        gap: 6px !important;
        background-color: #eab308 !important;
        color: #ffffff !important;
        padding: 6px 16px !important;
        border-radius: 4px !important;
        font-size: 13px !important;
        font-weight: 600 !important;
        text-decoration: none !important;
        box-shadow: 0 1px 2px rgba(0,0,0,0.08) !important;
        transition: background-color 0.15s !important;
    }
    .jdih-bapanas-btn-download:hover {
        background-color: #ca8a04 !important;
        color: #ffffff !important;
    }
    [data-theme="dark"] .jdih-bapanas-row-highlight th,
    [data-theme="dark"] .jdih-bapanas-row-highlight td {
        background-color: rgba(255, 255, 255, 0.04) !important;
    }
    [data-theme="dark"] .jdih-bapanas-link {
        color: #60a5fa !important;
    }
</style>

{{-- ROW 1: PERATURAN TERKAIT --}}
<tr class="jdih-bapanas-tr jdih-bapanas-row-highlight">
    <th style="vertical-align: top; padding-top: 14px;">Peraturan Terkait</th>
    <td style="vertical-align: top; padding: 12px 16px;">
        @if(!empty($peraturanTerkait) && count($peraturanTerkait) > 0)
            <ul class="jdih-bapanas-list">
                @foreach($peraturanTerkait as $rel)
                    @php
                        $isExt = !empty($rel['is_external']);
                        $linkUrl = $isExt ? $rel['permalink'] : url($rel['permalink']);
                    @endphp
                    <li>
                        <a href="{{ $linkUrl }}" class="jdih-bapanas-link" @if($isExt) target="_blank" rel="noopener noreferrer" title="Buka tautan peraturan eksternal" @endif>
                            {{ $rel['title'] }}@if($isExt) <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block; vertical-align:middle; margin-left:3px;"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path><polyline points="15 3 21 3 21 9"></polyline><line x1="10" y1="14" x2="21" y2="3"></line></svg>@endif
                        </a>
                        @if(!empty($rel['note']))
                            <span style="color: #64748b; font-size: 13px; margin-left: 4px;">({{ $rel['note'] }})</span>
                        @endif
                    </li>
                @endforeach
            </ul>
        @else
            <span style="color: #94a3b8;">-</span>
        @endif
    </td>
</tr>

{{-- ROW 2: ABSTRAK --}}
<tr class="jdih-bapanas-tr">
    <th>Abstrak</th>
    <td>
        @if(!empty($document->abstract) && \Illuminate\Support\Facades\Storage::exists($document->abstract))
            <a href="{{ route('document.stream', ['type' => 'abstract', 'id' => $document->id]) }}" target="_blank" class="jdih-bapanas-btn-abstract">
                Lihat Abstrak
            </a>
        @elseif(!empty($document->abstract))
            <a href="{{ url('storage/' . $document->abstract) }}" target="_blank" class="jdih-bapanas-btn-abstract">
                Lihat Abstrak
            </a>
        @else
            <span style="color: #94a3b8;">-</span>
        @endif
    </td>
</tr>

{{-- ROW 3: LAMPIRAN --}}
<tr class="jdih-bapanas-tr">
    <th>Lampiran</th>
    <td>
        @if(!empty($document->attachment) && \Illuminate\Support\Facades\Storage::exists($document->attachment))
            <a href="{{ route('document.download', ['type' => 'attachment', 'id' => $document->id]) }}?token={{ Str::random(15) }}" target="_blank" class="jdih-bapanas-btn-download">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                Unduh Dokumen
            </a>
        @elseif(!empty($document->pdf) && \Illuminate\Support\Facades\Storage::exists($document->pdf))
            <a href="{{ route('document.download', ['type' => 'pdf', 'id' => $document->id]) }}?token={{ Str::random(15) }}" target="_blank" class="jdih-bapanas-btn-download">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                Unduh Dokumen
            </a>
        @else
            <span style="color: #94a3b8;">-</span>
        @endif
    </td>
</tr>

{{-- ROW 4: PERATURAN PELAKSANAAN --}}
<tr class="jdih-bapanas-tr">
    <th>Peraturan Pelaksanaan</th>
    <td>
        @php
            $pelaksanaan = collect($peraturanTerkait)->filter(function($r) {
                $type = strtolower($r['relationship_type'] ?? '');
                $lbl = strtolower($r['relation_label'] ?? '');
                return str_contains($type, 'pelaksanaan') || str_contains($lbl, 'pelaksanaan') || str_contains($type, 'melaksanakan');
            });
        @endphp
        @if($pelaksanaan->count() > 0)
            <ul class="jdih-bapanas-list">
                @foreach($pelaksanaan as $p)
                    @php
                        $isExt = !empty($p['is_external']);
                        $linkUrl = $isExt ? $p['permalink'] : url($p['permalink']);
                    @endphp
                    <li>
                        <a href="{{ $linkUrl }}" class="jdih-bapanas-link" @if($isExt) target="_blank" rel="noopener noreferrer" title="Buka tautan peraturan eksternal" @endif>
                            {{ $p['title'] }}@if($isExt) <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block; vertical-align:middle; margin-left:3px;"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path><polyline points="15 3 21 3 21 9"></polyline><line x1="10" y1="14" x2="21" y2="3"></line></svg>@endif
                        </a>
                    </li>
                @endforeach
            </ul>
        @else
            <span style="color: #94a3b8;">-</span>
        @endif
    </td>
</tr>

{{-- ROW 5: DOKUMEN TERKAIT --}}
<tr class="jdih-bapanas-tr jdih-bapanas-row-highlight">
    <th style="vertical-align: top; padding-top: 14px;">Dokumen Terkait</th>
    <td style="vertical-align: top; padding: 12px 16px;">
        @if(!empty($dokumenTerkait) && count($dokumenTerkait) > 0)
            <ul class="jdih-bapanas-list">
                @foreach($dokumenTerkait as $rel)
                    @php
                        $isExt = !empty($rel['is_external']);
                        $linkUrl = $isExt ? $rel['permalink'] : url($rel['permalink']);
                    @endphp
                    <li>
                        <a href="{{ $linkUrl }}" class="jdih-bapanas-link" @if($isExt) target="_blank" rel="noopener noreferrer" title="Buka tautan dokumen eksternal" @endif>
                            {{ $rel['title'] }}@if(!$isExt && !empty($rel['pdf']) && !str_ends_with(strtolower($rel['title']), '.pdf')).pdf @elseif($isExt) <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block; vertical-align:middle; margin-left:3px;"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path><polyline points="15 3 21 3 21 9"></polyline><line x1="10" y1="14" x2="21" y2="3"></line></svg>@endif
                        </a>
                    </li>
                @endforeach
            </ul>
        @else
            <span style="color: #94a3b8;">-</span>
        @endif
    </td>
</tr>
