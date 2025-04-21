@extends('adminlte::page')

@section('title', '商品登録完了画面')

@section('content_header')
    <h1>商品登録</h1>
@stop

@section('content')

<div class="container">
    <div class="mb-4">
        <h2 class="text-center">
            商品の登録が完了しました。
        </h2>
    </div>

    <div class="d-flex align-items-center flex-column mb-5">
        <a class="btn btn-outline-primary w-auto mb-3 " href="{{ route('item.add') }}" role="button">続けて商品登録</a>
        <a class="btn btn-outline-primary w-auto " href="{{ route('item.index') }}" role="button">商品一覧へ戻る</a>
    </div>
</div>
@stop

@section('css')
@stop

@section('js')
@stop