@extends('adminlte::page')

@section('title', 'Коллекция "'.$collection->name.'"')

@section('content_header')
    {{--<h1 class="m-0 text-dark">Dashboard</h1>--}}
@stop

@section('content')
<!-- /.content-header -->
<form method="post" action="{{ url("collections/".$collection->id) }}">
    @csrf
    @method("PUT")

    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Коллекция "{{ $collection->name }}"</h3>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            @if(count($content) > 0)
            <table class="table table-hover text-nowrap">
                <thead>
                <tr>
                    <th>URL</th>
                    <th>Цена</th>
                </tr>
                </thead>
                <tbody>
                    @php($sum = 0)
                    @for($i = 0; $i < count($content); $i++)
                        <tr>

                            <td>{{ $content[$i]["url"] ?? $content[$i]["name"] }}</td>
                            <td>{{ $content[$i]["price"] }} $</td>
                        </tr>
                        @php($sum += $content[$i]["price"])
                    @endfor
                    <tr>
                        <td class="text-right">Сумма:</td>
                        <td>{{ $sum }} $</td>
                    </tr>
                </tbody>
            </table>
            @else
                    <div class="alert alert-info alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h5><i class="icon fas fa-info"></i> Коллекция не заполнена!</h5>
                        Для заполнения коллекции перейдите по <a
                            href="{{ url("collections/".$collection->id."/edit") }}">ссылке</a>
                    </div>
            @endif
        </div>
    </div>
</form>
@stop
