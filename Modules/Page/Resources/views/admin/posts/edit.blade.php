@extends('layouts.master')

@section('content-header')
<h1>
    {{ trans('page::posts.edit post') }}
</h1>
<ol class="breadcrumb">
    <li><a href="{{ URL::route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{
            trans('core::core.breadcrumb.home') }}</a></li>
    <li><a href="{{ URL::route('admin.post.post.index') }}">{{ trans('page::posts.posts') }}</a></li>
    <li class="active">{{ trans('page::posts.edit post') }}</li>
</ol>
@stop

@push('css-stack')
<style>
    .checkbox label {
        padding-left: 0;
    }
</style>
@endpush

@section('content')
{!! Form::open(['route' => ['admin.post.post.update',$post->id], 'method' => 'put']) !!}
<input type="hidden" name="type" value="post">
<div class="row">
    <div class="col-md-10">
        <div class="nav-tabs-custom">
            @include('partials.form-tab-headers', ['fields' => ['title', 'body']])
            <div class="tab-content">
                <?php $i = 0; ?>
                <?php foreach (LaravelLocalization::getSupportedLocales() as $locale => $language): ?>
                <?php ++$i; ?>
                <div class="tab-pane {{ App::getLocale() == $locale ? 'active' : '' }}" id="tab_{{ $i }}">
                    @include('page::admin.posts.partials.edit-fields', ['lang' => $locale])
                </div>
                <?php endforeach; ?>
                <?php if (config('asgard.page.config.partials.normal.edit') !== []): ?>
                <?php foreach (config('asgard.page.config.partials.normal.edit') as $partial): ?>
                @include($partial)
                <?php endforeach; ?>
                <?php endif; ?>

                <div class="box-footer">
                    <button type="submit" class="btn btn-primary btn-flat" name="button" value="index">
                        <i class="fa fa-angle-left"></i>
                        {{ trans('core::core.button.update and back') }}
                    </button>
                    <button type="submit" class="btn btn-primary btn-flat">
                        {{ trans('core::core.button.update') }}
                    </button>
                    <a class="btn btn-danger pull-right btn-flat" href="{{ URL::route('admin.post.post.index')}}"><i
                            class="fa fa-times"></i> {{ trans('core::core.button.cancel') }}</a>
                </div>
            </div>
        </div> {{-- end nav-tabs-custom --}}
    </div>
    <div class="col-md-2">
        <div class="box box-primary">
            <div class="box-body">
                <div class="box-category">
                    {!! Form::label("category_id", trans('page::posts.form.category_id')) !!}
                    <ul>
                        @foreach ($categories as $category)
                        <li>{!! $category['char'] !!}<input type="checkbox" name="category_id[]" {{
                                in_array($category['id'],$categorySelected) ?"checked":"" }}
                                value="{{ $category['id'] }}"> {{ $category['title'] }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        <div class="box box-primary">

            <div class="box-body">
                <div class='form-group{{ $errors->has("template") ? ' has-error' : '' }}'>
                    {!! Form::label("template", trans('page::posts.form.template')) !!}
                    {!! Form::select("template", $post_templates, old("template",$post->template), ['class' =>
                    "form-control", 'placeholder' => trans('page::posts.form.template')]) !!}
                    {!! $errors->first("template", '<span class="help-block">:message</span>') !!}
                </div>
                <hr>
                @tags('asgardcms/page',$post)
                <hr>
                @mediaSingle('page_featured_image',$post)
            </div>
        </div>
    </div>
</div>

{!! Form::close() !!}
@stop

@section('footer')
<a data-toggle="modal" data-target="#keyboardShortcutsModal"><i class="fa fa-keyboard-o"></i></a> &nbsp;
@stop
@section('shortcuts')
<dl class="dl-horizontal">
    <dt><code>b</code></dt>
    <dd>{{ trans('page::pages.navigation.back to index') }}</dd>
</dl>
@stop

@push('js-stack')
<script>
    $( document ).ready(function() {
            $(document).keypressAction({
                actions: [
                    { key: 'b', route: "<?= route('admin.post.post.index') ?>" }
                ]
            });
            $('input[type="checkbox"].flat-blue, input[type="radio"].flat-blue').iCheck({
                checkboxClass: 'icheckbox_flat-blue',
                radioClass: 'iradio_flat-blue'
            });
        });
</script>
@endpush