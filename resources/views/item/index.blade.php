@extends('adminlte::page')

@section('title', '商品一覧')

@section('content_header')
    <h1>商品一覧</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="col-md-4 offset-md-8 text-right mb-3">
                <form method="GET" action="{{ route('item.index') }}">
                    <input type="text" name="search" class="form-control" placeholder="検索" value="{{ request()->query('search') }}">
                        <button type="submit" class="btn btn-primary mt-2">検索</button>
                    </form>
            </div>
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">商品一覧</h3>
                    <div class="card-tools">
                        <div class="input-group input-group-sm">
                            <div class="input-group-append">
                                <a href="{{ route('item.add') }}" class="btn btn-default">商品を登録する</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body table-responsive p-0 mb-3">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>名前</th>
                                <th>商品の種類</th>
                                <th>産地</th>
                                <th>詳細</th>
                                <th>編集</th>
                                <th>削除</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($items as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $types[$item->type] }}</td>
                                    <td>{{ isset($origins[$item->origin]) ? $origins[$item->origin] : '' }}</td>
                                    <td><a class="btn btn-outline-primary btn-sm" href="{{ route('item.description', ['id' => $item->id]) }}">詳細</a></td>
                                    <td><a class="btn btn-outline-primary btn-sm" href="{{ route('item.edit', ['id' => $item->id]) }}">編集</td>
                                    <td>
                                        <!-- 削除フォーム -->
                                        <form method="POST" action="{{ route('item.destroy', ['id' => $item->id]) }}" onsubmit="return confirm('本当に削除しますか？');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm">削除</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- ページネーションを追加 -->
                <div class="d-flex justify-content-center">
                    {{ $items->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
@stop

@section('js')
@stop
