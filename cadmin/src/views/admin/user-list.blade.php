@extends('cactuar::admin.layout-master')

@section('content')

<div class="col-md-12 ">
    <a href="{{ admin::url('user/email-template') }}" class="btn btn-app"><i class="fa fa-envelope"></i> Email Template</a>
</div>

<div class="box box-primary card">
    <div class="box-header card-header">
        <h3 class="box-title card-title">User Data</h3><br/><br/>
        <a href="{{ admin::url('user/create') }}" class="btn btn-flat bg-blue btn-info"><i class="fa fa-plus"></i> Create</a>
    </div>
    <div class="box-body card-body">
    
        <div class="table-responsive no-padding">
            
            @include('cactuar::admin.filter')

            <table class="table table-hover">
                <caption>user list</caption>
                <tr>
                    <th>Login Name</th>
                    <th>Display Name</th>
                    <th>Email</th>
                    <th>Privilege</th>
                    <th>Enable</th>
                    <th class="list-date">Create</th>
                    <th class="list-date">Update</th>
                    <th class="list-act">Action</th>
                </tr>
                @forelse ($listing AS $item)
                    <tr>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->display_name }}</td>
                        <td>{{ $item->email }}</td>
                        <td>
                            @if (admin::moduleExists('privilege') && Auth::user()->allow('privilege', 'edit'))
                            <a href="{{ admin::url('privilege/edit?unique='.$item->privilege_id) }}">{{ $item->privilege->label }}</a>
                            @else
                            {{ $item->privilege->label }}
                            @endif
                        </td>
                        <td>
                            @if ($item->is_enable == 'Yes')
                                <span class="label label-success">Yes</span>
                            @else
                                <span class="label label-danger">No</span>
                            @endif
                        </td>
                        <td>{{ $item->created_at }}</td>
                        <td>{{ $item->updated_at }}</td>
                        <td key-name="action">
                            <a href="{{ admin::url('user/edit?unique='.$item->id) }}" class="btn bg-purple btn-flat btn-primary">
                                <i class="fa fa-edit"></i> Edit</a>
                            <a href="{{ admin::url('user/delete?unique='.$item->id) }}" 
                                class="btn bg-red btn-flat need-confirm btn-danger" 
                                data-confirm="Are you sure to delete this item?">
                            <i class="fa fa-trash"></i> Delete</a>
                            
                            @if (admin::moduleExists('admin-log') && Auth::user()->allow('admin-log', 'index'))
                            <a href="{{ admin::url('admin-log?user_id='.$item->id) }}" class="btn btn-flat bg-green btn-success"><i class="fa fa-terminal"></i> Log</a>
                            @endif
                        </td>
                    </tr>
                @empty
                <tr>
                    <td colspan="8" style="background-color:#aff;text-align:center;"><em>---- Empty data</em></td>
                </tr>
                @endforelse
            </table>
        </div>
    </div>
    
    {!! $listing->appends(request()->query())->render('cactuar::admin.paginate') !!}
</div>
    

@endsection