@php
    $peraturanTerkait = isset($document) && method_exists($document, 'getPeraturanTerkaitList') ? $document->getPeraturanTerkaitList() : [];
    $dokumenTerkait = isset($document) && method_exists($document, 'getDokumenTerkaitList') ? $document->getDokumenTerkaitList() : [];
@endphp

@if(count($peraturanTerkait) > 0 || count($dokumenTerkait) > 0)
<div class="box-detail-relations" style="margin-top: 36px; margin-bottom: 30px; font-family: inherit;">
    <style>
        .jdih-front-card { background: #ffffff; border: 1px solid #e2e8f0; border-radius: 10px; padding: 22px; margin-bottom: 24px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); }
        .jdih-front-card__header { display: flex; align-items: center; margin-bottom: 16px; border-bottom: 2px solid #0086A7; padding-bottom: 10px; }
        .jdih-front-card__title { font-size: 19px; font-weight: 700; color: #091D77; margin: 0; }
        .jdih-front-table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        .jdih-front-table th { background: #f8fafc; color: #475569; font-weight: 700; font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px; padding: 12px 14px; border-bottom: 2px solid #e2e8f0; text-align: left; }
        .jdih-front-table td { padding: 14px; font-size: 14px; color: #1e293b; border-bottom: 1px solid #f1f5f9; vertical-align: middle; }
        .jdih-front-table tr:hover td { background: #f8fafc; }
        .jdih-badge-relation { display: inline-block; padding: 4px 12px; border-radius: 14px; font-size: 12px; font-weight: 600; border: 1px solid transparent; white-space: nowrap; }
        .jdih-link-doc { color: #091D77; font-weight: 600; text-decoration: none; line-height: 1.4; display: block; }
        .jdih-link-doc:hover { color: #0086A7; text-decoration: underline; }
        .jdih-btn-action { display: inline-flex; align-items: center; gap: 4px; padding: 6px 14px; border-radius: 6px; font-size: 12px; font-weight: 600; text-decoration: none; border: 1px solid #091D77; color: #091D77; transition: all 0.2s; white-space: nowrap; }
        .jdih-btn-action:hover { background: #091D77; color: #ffffff; }
        @media (max-width: 768px) {
            .jdih-front-table { display: block; overflow-x: auto; }
        }
    </style>

    {{-- BAGIAN 1: PERATURAN TERKAIT --}}
    @if(count($peraturanTerkait) > 0)
    <div class="jdih-front-card">
        <div class="jdih-front-card__header">
            <h4 class="jdih-front-card__title">Peraturan Terkait</h4>
            <span style="margin-left: auto; font-size: 13px; color: #64748b; font-weight: 500;">
                {{ count($peraturanTerkait) }} peraturan terhubung
            </span>
        </div>
        <div style="overflow-x: auto;">
            <table class="jdih-front-table">
                <thead>
                    <tr>
                        <th style="width: 50px;">No</th>
                        <th>Judul Dokumen Peraturan</th>
                        <th style="width: 120px;">Nomor</th>
                        <th style="width: 80px;">Tahun</th>
                        <th style="width: 170px;">Status Hubungan</th>
                        <th style="width: 120px; text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($peraturanTerkait as $idx => $item)
                    <tr>
                        <td><strong>{{ $idx + 1 }}</strong></td>
                        <td>
                            <a href="{{ url($item['permalink']) }}" class="jdih-link-doc">
                                {{ $item['title'] }}
                            </a>
                            <small style="color: #64748b; display: block; margin-top: 3px;">
                                {{ $item['jenis_peraturan'] }}
                                @if(!empty($item['note']))
                                    — <em>{{ $item['note'] }}</em>
                                @endif
                            </small>
                        </td>
                        <td>{{ $item['no_peraturan'] }}</td>
                        <td>{{ $item['year'] }}</td>
                        <td>
                            <span class="jdih-badge-relation" style="background: {{ $item['colors']['bg'] }}; color: {{ $item['colors']['text'] }}; border-color: {{ $item['colors']['border'] }};">
                                {{ $item['relation_label'] }}
                            </span>
                        </td>
                        <td style="text-align: center;">
                            <a href="{{ url($item['permalink']) }}" class="jdih-btn-action">
                                Detail &rarr;
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif

    {{-- BAGIAN 2: DOKUMEN TERKAIT (LINTAS KATEGORI) --}}
    @if(count($dokumenTerkait) > 0)
    <div class="jdih-front-card">
        <div class="jdih-front-card__header" style="border-bottom-color: #059669;">
            <h4 class="jdih-front-card__title" style="color: #065f46;">Dokumen Terkait</h4>
            <span style="margin-left: auto; font-size: 13px; color: #64748b; font-weight: 500;">
                {{ count($dokumenTerkait) }} dokumen lintas kategori
            </span>
        </div>
        <div style="overflow-x: auto;">
            <table class="jdih-front-table">
                <thead>
                    <tr>
                        <th style="width: 50px;">No</th>
                        <th>Judul Dokumen</th>
                        <th style="width: 160px;">Kategori Dokumen</th>
                        <th style="width: 120px;">Nomor</th>
                        <th style="width: 80px;">Tahun</th>
                        <th style="width: 170px;">Status Hubungan</th>
                        <th style="width: 120px; text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($dokumenTerkait as $idx => $item)
                    <tr>
                        <td><strong>{{ $idx + 1 }}</strong></td>
                        <td>
                            <a href="{{ url($item['permalink']) }}" class="jdih-link-doc">
                                {{ $item['title'] }}
                            </a>
                            @if(!empty($item['note']))
                            <small style="color: #64748b; display: block; margin-top: 3px;">
                                <em>{{ $item['note'] }}</em>
                            </small>
                            @endif
                        </td>
                        <td>
                            <span style="display: inline-block; padding: 3px 8px; border-radius: 4px; background: #f1f5f9; color: #334155; font-size: 12px; font-weight: 600;">
                                {{ $item['kategori'] }}
                            </span>
                        </td>
                        <td>{{ $item['nomor'] }}</td>
                        <td>{{ $item['year'] }}</td>
                        <td>
                            <span class="jdih-badge-relation" style="background: {{ $item['colors']['bg'] }}; color: {{ $item['colors']['text'] }}; border-color: {{ $item['colors']['border'] }};">
                                {{ $item['relation_label'] }}
                            </span>
                        </td>
                        <td style="text-align: center;">
                            <a href="{{ url($item['permalink']) }}" class="jdih-btn-action" style="border-color: #059669; color: #059669;">
                                Detail &rarr;
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif
</div>
@endif

