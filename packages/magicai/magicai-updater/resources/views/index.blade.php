@extends('magicai-updater::layouts.master', ['stepShow' => false])

@section('template_title')
    {{ $data['title'] }}
@endsection

@section('title')
    {{ $data['title'] }}
@endsection

@section('container')
    @include($data['view'])
@endsection
