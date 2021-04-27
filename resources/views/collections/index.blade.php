@extends('adminlte::page')

@section('title', 'Коллекции')

@section('content_header')
    {{--<h1 class="m-0 text-dark">Dashboard</h1>--}}
@stop

@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="mb-2">
            <h1 class="m-0 text-dark">Коллекции</h1>
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    <table id="collections-table" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Название</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($collections as $collection)
                            <tr>
                                <td>{{ $collection->id }}</td>
                                <td>{{ $collection->name }}</td>
                                <td>
                                    <div class="table_actions_btns">
                                        <a href="{{ url("collections/".$collection->id) }}" target="_blank" class="btn btn-block btn-primary">Посмотреть</a>
                                        <a href="{{ url("collections/".$collection->id."/edit") }}" target="_blank" class="btn btn-block btn-primary">Заполнить</a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col -->
    </div>
</section>
<!-- /.content -->
@stop

@push('scripts')
    <script>
        $(function() {
            $('#collections-table').DataTable({
                //processing: true,
                serverSide: true,
                ajax: '{!! url('collections/data') !!}',
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'name', name: 'name', orderable: false },
                    { data: null, name: 'action', orderable: false, searchable: false,
                        "render": (data) => {
                            return '<div class=\"table_actions_btns\">' +
                                '<a href=\"'+window.location.origin+'/collections/'+data["id"]+'\" target="_blank" class=\"btn btn-block btn-primary\">Посмотреть</a>' +
                                '<a href=\"'+window.location.origin+'/collections/'+data["id"]+'/edit\" target="_blank" class=\"btn btn-block btn-primary\">Заполнить</a>' +
                                '</div>';
                        }
                    }
                ]
            });
        });
    </script>
@endpush
