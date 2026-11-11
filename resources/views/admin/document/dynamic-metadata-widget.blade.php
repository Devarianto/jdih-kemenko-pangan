@php
    $fields = $fields ?? collect();
    $values = $values ?? [];
@endphp

@if($fields->isNotEmpty())
<div class="card card-outline card-primary shadow-sm mt-4 mb-4" id="section-dynamic-metadata" style="border-radius: 6px;">
    <div class="card-header bg-light" style="padding: 12px 18px;">
        <h5 class="mb-0 font-weight-bold" style="font-size: 15px;">
            <i class="fa fa-tags mr-1"></i> Metadata Tambahan
        </h5>
        <small class="text-muted">Field ini diatur di menu <em>Master Dokumen &rsaquo; Pengaturan Metadata</em>. Kosongkan jika tidak ada (tampil sebagai "-" di website).</small>
    </div>
    <div class="card-body p-4">
        @foreach($fields as $f)
            @php
                $name = 'dm[' . $f->id . ']';
                $val = old('dm.' . $f->id, $values[$f->id] ?? '');
                $req = $f->is_required ? 'required' : '';
            @endphp
            <div class="form-group row">
                <label class="col-md-3 col-form-label font-weight-bold" for="dm-{{ $f->id }}">
                    {{ $f->label }} @if($f->is_required)<span class="text-danger">*</span>@endif
                    @if($f->label_en)<br><small class="text-muted font-weight-normal">{{ $f->label_en }}</small>@endif
                </label>
                <div class="col-md-9">
                    @if($f->type === 'textarea')
                        <textarea id="dm-{{ $f->id }}" name="{{ $name }}" rows="3" class="form-control" {{ $req }}>{{ $val }}</textarea>
                    @elseif($f->type === 'select')
                        <select id="dm-{{ $f->id }}" name="{{ $name }}" class="form-control" {{ $req }}>
                            <option value="">-- Pilih --</option>
                            @foreach($f->option_list as $opt)
                                <option value="{{ $opt }}" {{ (string) $val === (string) $opt ? 'selected' : '' }}>{{ $opt }}</option>
                            @endforeach
                        </select>
                    @elseif($f->type === 'number')
                        <input type="number" step="any" id="dm-{{ $f->id }}" name="{{ $name }}" value="{{ $val }}" class="form-control" {{ $req }}>
                    @elseif($f->type === 'date')
                        <input type="text" id="dm-{{ $f->id }}" name="{{ $name }}" value="{{ $val }}" class="form-control datepicker" autocomplete="off" {{ $req }}>
                    @elseif($f->type === 'url')
                        <input type="url" id="dm-{{ $f->id }}" name="{{ $name }}" value="{{ $val }}" class="form-control" placeholder="https://" {{ $req }}>
                    @else
                        <input type="text" id="dm-{{ $f->id }}" name="{{ $name }}" value="{{ $val }}" class="form-control" {{ $req }}>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
</div>
@endif

