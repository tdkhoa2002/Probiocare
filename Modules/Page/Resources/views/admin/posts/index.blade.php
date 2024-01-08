@extends('layouts.master')

@section('content-header')
<h1>
    {{ trans('page::posts.posts') }}
</h1>
<ol class="breadcrumb">
    <li><a href="{{ URL::route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{
            trans('core::core.breadcrumb.home') }}</a></li>
    <li class="active">{{ trans('page::posts.posts') }}</li>
</ol>
@stop

@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="row">
            <div class="btn-group pull-right" style="margin: 0 15px 15px 0;">
                <a href="{{ URL::route('admin.post.post.create') }}" class="btn btn-primary btn-flat"
                    style="padding: 4px 10px;">
                    <i class="fa fa-pencil"></i> {{ trans('page::posts.create post') }}
                </a>
            </div>
        </div>
        <div class="box box-primary">
            <div class="box-header">
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <table class="data-table table table-bordered table-hover" id="dataTable">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>{{ trans('page::posts.table.title') }}</th>
                            <th>{{ trans('page::posts.table.slug') }}</th>
                            <th>{{ trans('core::core.table.created at') }}</th>
                            <th data-sortable="false">{{ trans('core::core.table.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Id</th>
                            <th>{{ trans('page::posts.table.title') }}</th>
                            <th>{{ trans('page::posts.table.slug') }}</th>
                            <th>{{ trans('core::core.table.created at') }}</th>
                            <th>{{ trans('core::core.table.actions') }}</th>
                        </tr>
                    </tfoot>
                </table>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
    </div>
</div>
@include('core::partials.delete-modal')
@stop

@section('footer')
<a data-toggle="modal" data-target="#keyboardShortcutsModal"><i class="fa fa-keyboard-o"></i></a> &nbsp;
@stop
@section('shortcuts')
<dl class="dl-horizontal">
    <dt><code>c</code></dt>
    <dd>{{ trans('page::pages.title.create page') }}</dd>
</dl>
@stop

@push('js-stack')
<?php $locale = App::getLocale(); ?>
<script type="text/javascript">
    $( document ).ready(function() {
            $(document).keypressAction({
                actions: [
                    { key: 'c', route: "<?= route('admin.post.post.create') ?>" }
                ]
            });
            $('#dataTable').DataTable({
                "processing": true,
                "serverSide": true,
                "responsive": true,
                "deferRender": true,
                "ajax": "{!! route('admin.post.post.getListPost') !!}",
                "language": {
                        "url": '<?php echo Module::asset("core:js/vendor/datatables/{$locale}.json") ?>'
                    },
                "columns": [
                    { "data": "id" },
                    { "data": "title" },
                    { "data": "slug" },
                    { "data": "created_at" },
                    { "data": "action" }
                ]
            });
        });
</script>
@endpush