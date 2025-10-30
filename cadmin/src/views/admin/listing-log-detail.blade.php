@extends('cactuar::admin.layout-master')

@section('content')

<a href="{{ url()->admin('logviewer') }}" class="btn btn-app">
    <i class="fa fa-list"></i>
    Back
</a>

@php($arr = [])

@foreach (file($path) as $pt)
    @php($arr[] = $pt)
@endforeach

@foreach (array_reverse($arr) as $value)
    @if (substr($value,0,2) == '[2')
        <div class="card">
            <div class="card-body">
                {{ $value }}
            </div>
        </div>
    @endif
@endforeach

@endsection
