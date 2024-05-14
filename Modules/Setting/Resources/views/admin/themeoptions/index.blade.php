@extends('layouts.master')

@section('content-header')
<h1>
    {{ trans('setting::themeoptions.title.themeoptions') }}
</h1>
<ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
    <li class="active"><i class="fa fa-cog"></i> {{ trans('setting::themeoptions.title.themeoptions') }}</li>
</ol>
@stop

@section('content')
{!! Form::open(['route' => ['admin.themeoption.themeoptions.store'], 'method' => 'post']) !!}
<div class="row">
    <div class="sidebar-nav col-sm-2">
        <div class="box box-primary">
            <ul class="nav nav-tabs nav-pills nav-stacked">
                @foreach ($defaultThemeOptions as $module => $settings)
                @php
                $class = '';
                if($loop->first) {
                $class='active';
                }
                @endphp
                <li role="presentation" class="{{ $class }}">
                    <a href="#defaultThemeOption{{ $loop->index }}"
                        aria-controls="defaultThemeOption{{ $loop->index  }}" role="tab" data-toggle="tab">
                        {{ trans($module) }}
                    </a>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
    <div class="col-md-10">
        <div class="tab-content">
            @foreach ($defaultThemeOptions as $section => $settings)
            @php
            $class = '';
            if($loop->first) {
            $class='in active';
            }
            @endphp
            <div role="tabpanel" class="tab-pane fade  {{ $class }}" id="defaultThemeOption{{ $loop->index }}">
                @isset($settings['translatable'])
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">{{ trans('core::core.title.translatable fields') }}</h3>
                    </div>
                    <div class="box-body">
                        <div class="nav-tabs-custom">
                            @include('partials.form-tab-headers')
                            <div class="tab-content">
                                <?php $i = 0; ?>
                                <?php foreach (LaravelLocalization::getSupportedLocales() as $locale => $language): ?>
                                <?php $i++; ?>
                                <div class="tab-pane {{ App::getLocale() == $locale ? 'active' : '' }}"
                                    id="tab_{{ $i }}">
                                    @include('setting::admin.themeoptions.fields', ['settings' =>
                                    $settings['translatable'],'type'=>'translatable','theme'=>$theme])
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
                @endisset
                @isset($settings['non-translatable'])
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">{{ trans('core::core.title.non translatable fields') }}</h3>
                    </div>
                    <div class="box-body">
                        <div class="nav-tabs-custom">
                            @include('partials.form-tab-headers')
                            <div class="tab-content">
                                <?php $i = 0; ?>
                                <?php foreach (LaravelLocalization::getSupportedLocales() as $locale => $language): ?>
                                <?php $i++; ?>
                                <div class="tab-pane {{ App::getLocale() == $locale ? 'active' : '' }}"
                                    id="tab_{{ $i }}">
                                    @include('setting::admin.themeoptions.fields', [
                                    'settings' =>$settings['non-translatable'],'type'=>'plain','theme'=>$theme
                                    ])
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
                @endisset
            </div>
            @endforeach
        </div>
        <div class="box-footer">
            <button type="submit" class="btn btn-primary btn-flat">{{ trans('core::core.button.update') }}</button>
            <a class="btn btn-danger pull-right btn-flat" href="{{ route('admin.setting.settings.index')}}"><i
                    class="fa fa-times"></i> {{ trans('core::core.button.cancel') }}</a>
        </div>
    </div>
</div>
{!! Form::close() !!}
@stop

@push('js-stack')
<script>
    $( document ).ready(function() {
    $('input[type="checkbox"].flat-blue, input[type="radio"].flat-blue').iCheck({
        checkboxClass: 'icheckbox_flat-blue',
        radioClass: 'iradio_flat-blue'
    });

    $('input[type="checkbox"]').on('ifChecked', function(){
      $(this).parent().find('input[type=hidden]').remove();
    });

    $('input[type="checkbox"]').on('ifUnchecked', function(){
      var name = $(this).attr('name'),
          input = '<input type="hidden" name="' + name + '" value="0" />';
      $(this).parent().append(input);
    });
});
</script>
@endpush