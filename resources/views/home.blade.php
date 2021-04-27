@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
    {{--<h1 class="m-0 text-dark">Dashboard</h1>--}}
@stop

@section('content')
    <div class="row">
        <div class="col-6">
            <form method="post" action="{{ url("pages") }}">
                @csrf
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Загрузка веб-страницы</h3>
                    </div>
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                        <div class="form-group">
                            <label for="url-input">URL</label>
                            <input type="text" name="url" class="form-control @error('url') is-invalid @enderror" id="url-input" placeholder="URL" value="">
                            @error('url')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Загрузить</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-6">
            <form method="post" action="{{ url("applications") }}">
                @csrf
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">Добавление приложения</h3>
                    </div>
                    <div class="card-body">
                        @if (session('success_app'))
                            <div class="alert alert-success">
                                {{ session('success_app') }}
                            </div>
                        @endif
                        <div class="form-group">
                            <label for="name-input">Название</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name-input" value="">
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                            <div class="form-group">
                                <label for="price-input">Цена за хранение</label>
                                <div class="input-group mb-3">
                                    <input type="number" name="price" step="0.001" min="0.001" class="form-control @error('price') is-invalid @enderror" id="price-input" value="">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                                    </div>
                                </div>
                                @error('price')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Добавить</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-6">
            <form method="post" action="{{ url("collections") }}">
                @csrf
                <div class="card card-warning">
                    <div class="card-header">
                        <h3 class="card-title">Создание коллекции</h3>
                    </div>
                    <div class="card-body">
                        @if (session('success_collection'))
                            <div class="alert alert-success">
                                {!! session('success_collection') !!}
                            </div>
                        @endif
                        <div class="form-group">
                            <label for="name-input">Название</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name-input" value="">
                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Создать коллекцию</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@stop
