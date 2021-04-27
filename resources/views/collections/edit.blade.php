@extends('adminlte::page')

@section('title', 'Заполнение коллекции "'.$collection->name.'"')

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
            <h3 class="card-title">Заполнение коллекции "{{ $collection->name }}"</h3>
        </div>
        <div class="card-body">
            <select id="multiGrpSel" name="data[]" multiple style="height: 500px">
                <optgroup label="Веб-страницы" id="pages">
                    @foreach($pages as $page)
                        <option value="page_{{ $page->id }}">{{ $page->url }}</option>
                    @endforeach
                </optgroup>
                <optgroup label="Приложения" id="apps">
                    @foreach($applications as $application)
                        <option value="apps_{{ $application->id }}">{{ $application->name }}</option>
                    @endforeach
                </optgroup>
            </select>
        </div>
        <div class="card-footer">
            <button type="submit" id="submit" class="btn btn-primary">Добавить</button>
        </div>
    </div>
</form>
@stop

{{--@push('scripts')
    <script>
        $(function() {
            $("#submit").click(function (){
                $('#multiGrpSel').find("option:selected").each(function(){
                    //optgroup label
                    var label = $(this).parent().attr("label");
                    //optgroup id
                    console.log('id='+$(this).parent().attr("id"));

                    // values based on each group ??
                    id = $(this).parent().attr("id");

                    // gets the value
                    console.log("label: "+label+" value: "+$(this).val())

                });
                return false;
            });
        });
    </script>
@endpush--}}
