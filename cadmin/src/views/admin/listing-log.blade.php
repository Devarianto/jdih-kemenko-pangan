@extends('cactuar::admin.layout-master')

@section('content')

<div class="card">
    <div class="card-header box-header">
      <h3 class="card-title box-title">Log Viewer</h3>
      <br />
      <br />
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-hover">
          <caption>listing log</caption>
          <thead>
            <tr>
              <th>Files</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($logFiles as $lf)
            <tr>
              <td>{{ $lf->getFilename() }} | {{ helper::formatBytes($lf->getSize()) }}</td>
              <td>&nbsp;<a href="{{ url()->admin('logviewer/view') }}?file={{ $lf->getFilename() }}" class="btn bg-purple btn-flat btn-primary">
                <i class="fa fa-eye"></i> view</a>
                &nbsp;<a href="{{ url()->admin('logviewer/download') }}?file={{ $lf->getFilename() }}" class="btn bg-green btn-flat btn-success">
                    <i class="fa fa-download"></i> Download</a>
                &nbsp;<a href="{{ url()->admin('logviewer/delete') }}?file={{ $lf->getFilename() }}" class="btn bg-red btn-flat btn-danger" onclick="return confirm('Are you sure delete this item?')">
                    <i class="fa fa-trash"></i> Delete</a>
            </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
    <div class="card-footer clearfix"></div>
</div>

@endsection
