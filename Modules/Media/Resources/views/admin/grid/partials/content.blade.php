<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>{{ trans('media::media.file picker') }}</title>
    {!! Theme::style('vendor/bootstrap/dist/css/bootstrap.min.css') !!}
    {!! Theme::style('vendor/admin-lte/dist/css/AdminLTE.css') !!}
    {!! Theme::style('vendor/datatables.net-bs/css/dataTables.bootstrap.min.css') !!}
    {!! Theme::style('vendor/font-awesome/css/font-awesome.min.css') !!}
    <link href="{!! Module::asset('media:css/dropzone.css') !!}" rel="stylesheet" type="text/css" />
    <style>
        body {
            background: #ecf0f5;
            margin-top: 20px;
        }

        .dropzone {
            border: 1px dashed #CCC;
            min-height: 227px;
            margin-bottom: 20px;
            display: none;
        }
    </style>
    <script>
        AuthorizationHeaderValue = 'Bearer {{ $currentUser->getFirstApiKey() }}';
    </script>
    @include('partials.asgard-globals')
</head>

<body>
    <div class="container">
        <div class="row">
            <form method="POST" class="dropzone">
                {!! Form::token() !!}
            </form>
        </div>
        <div class="clearfix"></div>
        <div class="row">
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title">{{ trans('media::media.choose file') }}</h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool jsShowUploadForm" data-toggle="tooltip" title=""
                            data-original-title="Upload new">
                            <i class="fa fa-cloud-upload"></i>
                            Upload new
                        </button>
                    </div>
                </div>
                <div class="box-body">
                    <table class="data-table table table-bordered table-hover jsFileList" id="dataTable">
                        <thead>
                            <tr>
                                <th>id</th>
                                <th>{{ trans('core::core.table.thumbnail') }}</th>
                                <th>{{ trans('media::media.table.filename') }}</th>
                                <th data-sortable="false">{{ trans('core::core.table.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    {!! Theme::script('vendor/jquery/jquery.min.js') !!}
    {!! Theme::script('vendor/bootstrap/dist/js/bootstrap.min.js') !!}
    {!! Theme::script('vendor/datatables.net/js/jquery.dataTables.min.js') !!}
    {!! Theme::script('vendor/datatables.net-bs/js/dataTables.bootstrap.min.js') !!}
    <script src="{!! Module::asset('media:js/dropzone.js') !!}"></script>
    <?php $config = config('asgard.media.config'); ?>
    <script>
        var maxFilesize = '<?php echo $config['max-file-size'] ?>',
        acceptedFiles = '<?php echo $config['allowed-types'] ?>';
    </script>
    <script src="{!! Module::asset('media:js/init-dropzone.js') !!}"></script>
    <script src="{!! Module::asset('dashboard:vendor/jquery-ui/jquery-ui.min.js') !!}"></script>
    <script src="{!! Module::asset('media:js/media-partial.js') !!}"></script>
    <script>
        $( document ).ready(function() {
        $('.jsShowUploadForm').on('click',function (event) {
            event.preventDefault();
            $('.dropzone').fadeToggle();
        });
    });
    </script>

    <?php $locale = App::getLocale(); ?>
    <script type="text/javascript">
        $( document ).ready(function() {
            function insertFile(){
                @if($isWysiwyg)
                $('.jsInsertImage').on('click', function (e) {
                    e.preventDefault();
                    function getUrlParam(paramName) {
                        var reParam = new RegExp('(?:[\?&]|&)' + paramName + '=([^&]+)', 'i');
                        var match = window.location.search.match(reParam);

                        return ( match && match.length > 1 ) ? match[1] : null;
                    }

                    var funcNum = getUrlParam('CKEditorFuncNum');

                    window.opener.CKEDITOR.tools.callFunction(funcNum, $(this).data('file-path'));
                    window.close();
                });
                @else
                $('.jsInsertImage').on('click', function (e) {
                    e.preventDefault();
                    var mediaId = $(this).data('id'),
                        filePath = $(this).data('file-path'),
                        mediaType = $(this).data('mediaType'),
                        mimetype = $(this).data('mimetype');
                        const zoneWrapper = window.opener.zoneWrapper
                    if(window.opener.old) {
                        if(window.opener.single) {
                            window.includeMediaSingleOld(mediaId, filePath);
                            window.close();
                        } else {
                            window.includeMediaMultipleOld(mediaId, filePath);
                        }
                    } else {
                        if(window.opener.single) {
                            window.includeMediaSingle(mediaId, filePath, mediaType, mimetype,zoneWrapper);
                            window.close();
                        } else {
                            window.includeMediaMultiple(mediaId, filePath, mediaType, mimetype);
                        }
                    }
                });
                @endif
            }
            const table = $('#dataTable').DataTable({
                "processing": true,
                "serverSide": true,
                "responsive": true,
                "deferRender": true,
                "ajax": "{!! route('media.grid.getFileForGird') !!}?isWysiwyg="+{{ $isWysiwyg }},
                "language": {
                        "url": '<?php echo Module::asset("core:js/vendor/datatables/{$locale}.json") ?>'
                    },
                "columns": [
                    { "data": "id" },
                    { "data": "thumbnail" },
                    { "data": "filename" },
                    { "data": "action" }
                ]
            });
            table.ajax.params({name: 'test'});
            table.on( 'draw', function () {
                insertFile()
            });
        });
    </script>