@extends('cactuar::admin.layout-master')

@section('content')
<div class="box box-primary card">
    <div class="box-header card-header">
        <h3 class="box-title card-title">Privilege Data</h3><br/><br>
        <a href="{{ admin::url('privilege/create') }}" class="btn btn-flat bg-blue btn-info"><i class="fa fa-plus"></i> Create</a>
    </div>
    <div class="box-body card-body">
        <div class="table-responsive no-padding">

            @include('cactuar::admin.filter')

            <table class="table table-hover">
                <caption>privilege list</caption>
                <tr>
                    <th>Label</th>
                    <th>User count</th>
                    <th class="list-date">Create</th>
                    <th class="list-date">Update</th>
                    <th class="list-act">Action</th>
                </tr>
                @forelse ($listing AS $item)
                    <tr>
                        <td>{{ $item->label }}</td>
                        <td>{{ $item->users->count() }}</td>
                        <td>{{ $item->created_at }}</td>
                        <td>{{ $item->updated_at }}</td>
                        <td key-name="action"><a href="{{ admin::url('privilege/edit?unique='.$item->id) }}" class="btn bg-purple btn-flat btn-primary">
                            <i class="fa fa-edit"></i> Edit</a>
                            @if ($item->delAble)
                                <a href="{{ admin::url('privilege/delete?unique='.$item->id) }}" 
                                class="btn bg-red btn-flat need-confirm btn-danger" 
                                data-confirm="Are you sure to delete this item?">
                                <i class="fa fa-trash"></i> Delete</a>
                            @endif
                        </td>
                    </tr>
                @empty
                <tr>
                    <td colspan="5" style="background-color:#aff;text-align:center;"><em>---- Empty data</em></td>
                </tr>
                @endforelse
            </table>
        </div>
        
    </div>
</div>

{!! $listing->appends(request()->query())->render('cactuar::admin.paginate') !!}

@endsection