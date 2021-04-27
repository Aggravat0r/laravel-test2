@extends('adminlte::page')

@section('title', 'Веб-страницы')

@section('content_header')
    {{--<h1 class="m-0 text-dark">Dashboard</h1>--}}
@stop

@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="mb-2">
            <h1 class="m-0 text-dark">Веб-страницы</h1>
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
                    <table id="pages-table" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>URL</th>
                            <th>Цена</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($pages as $page)
                            <tr>
                                <td>{{ $page->id }}</td>
                                <td>
                                    <a href="{{ $page->url }}">{{ $page->url }}</a>
                                </td>
                                <td>{{ $page->price }} $</td>
                                <td>
                                    <div class="table_actions_btns">
                                        <a href="{{ $page->hash }}" target="_blank" class="btn btn-block btn-primary">Посмотреть</a>
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
            $('#pages-table').DataTable({
                //processing: true,
                serverSide: true,
                ajax: '{!! url('pages/data') !!}',
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'url', name: 'url', orderable: false },
                    { data: 'price', name: 'price',
                        "render": (data) => {
                            return data+" $";
                        }
                    },
                    { data: null, name: 'action', orderable: false, searchable: false,
                        "render": (data) => {
                            return '<div class=\"table_actions_btns\">' +
                                '<a href=\"/'+data["hash"]+'\" target="_blank" class=\"btn btn-block btn-primary\">Посмотреть</a>' +
                               '</div>';
                        }
                    }
                ]
            });
        });
    </script>
@endpush
