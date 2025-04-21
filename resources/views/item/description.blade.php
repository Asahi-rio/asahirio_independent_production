@extends('adminlte::page')

@section('title', '商品説明')

@section('content_header')
    <h1>商品詳細</h1>
@stop

@section('content')
<div class="row">
        <div class="text-center mb-3">
            <a href="{{ route('item.index') }}" class="btn btn-primary"  role="button">一覧画面へ戻る</a>
        </div>
        <div class="col-12 mb-3">

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">商品概要</h3>
                </div>
                <div class="card-body table-responsive p-0">
                    <dl class="d-flex justify-content-around mt-1">
                        <dt>ID :</dt>
                        <dd>{{ $item->id }}</dd>
                        <dt>名前 :</dt>
                        <dd>{{ $item->name }}</dd>
                        <dt>商品の種類 :</dt>
                        <dd>{{ $item->type }}</dd>
                        <dt>産地 :</dt>
                        <dd>{{ $item->origin }}</dd>
                    </dl>
                </div>
            </div>
        </div>              

        <div class="col-12 mb-3">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">詳細</h3>
                </div>
                <div class="card-body">
                    <div class="align-items-center">
                        <p>{{ $item->detail }}</p>
                    </div>
                </div>
            </div>
        </div> 
</div>

@stop

@section('css')
@stop

@section('js')
@stop