{{-- CMS Metadata Dinamis: baris Meta | Keterangan. Mode ganti penuh (CMS_DRIVEN) atau hanya field dinamis tambahan. --}}
@php
    $__dmReplace = \App\Helpers\DynamicMetadata::replacesStatic($document);
    $__dmRows = \App\Helpers\DynamicMetadata::publicRows($document, app()->getLocale(), !$__dmReplace);
@endphp
@foreach($__dmRows as $__row)
  <tr>
    <th>{{ $__row['label'] }}</th>
    <td>{!! $__row['value'] !!}</td>
  </tr>
@endforeach

