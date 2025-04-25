@extends('adminlte::page')

@section('title', '商品編集')

@section('content_header')
    <h1>商品情報編集</h1>
@stop

@section('content')
<div class="row">

    <div class="col-md-10">
        <div class="mb-3">
                <a href="{{ route('item.index') }}" class="btn btn-primary"  role="button">一覧画面へ戻る</a>
        </div>

        <!--エラー表示-->
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card card-primary">
            <form id="edit-form" method="POST" action="{{ route('item.update', ['id' => $item->id]) }}">
                @csrf
                @method('PUT')

                <div class="card-body">
                    <div class="form-group mb-5">
                        <label for="name">商品名</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ $item->name }}">
                        <div id="name-help" class="form-text text-muted fs-6">※商品名は100文字以内で入力してください</div>

                        <!--エラーメッセージ-->
                        <div id="name-error" class="form-text text-danger fs-6" style="display: none;"></div>
                    </div>

                    <div class="d-flex mb-3 justify-content-around">
                        <div class="form-group w-50">
                            <label for="type">商品の種類</label>
                            <select name="type" id="type" class="form-control">
                                <option value="1" {{ $item->type == 1 ? 'selected' : '' }}>コーヒー</option>
                                <option value="2" {{ $item->type == 2 ? 'selected' : '' }}>その他材料</option>
                                <option value="3" {{ $item->type == 3 ? 'selected' : '' }}>雑貨類</option>
                            </select>
                        </div>

                        <div class="form-group w-40">
                            <label for="origin">産地</label>
                            <select id="origin" name="origin" class="form-control">
                                <option value="" disabled {{ old('origin') === null ? 'selected' : '' }}>産地を選択してください</option>
                                    @foreach ($origins as $key => $origin)
                                        <option value="{{ $key }}" {{ old('origin', 1) == $key ? 'selected' : '' }}>{{ $origin }}</option>
                                    @endforeach
                            </select>
                            <div id="origin" class="form-text text-muted fs-6">※商品の種類で「コーヒー」を選んだ場合のみ選択してください</div>
                        </div>
                    </div>

                    <div class="form-group mb-4">
                        <label for="detail">詳細</label>
                        <textarea name="detail" id="detail" class="form-control">{{ $item->detail }}</textarea>
                        <div id="detail" class="form-text text-muted fs-6">※1000文字以内で入力してください</div>
                    </div> 
                </div>

                <div class="card-footer text-center">
                    <button type="submit" class="btn btn-primary">編集</button>
                </div>
            </form>

            <div class="row justify-content-center"> 
                <!-- 削除フォーム -->
                <form method="POST" action="{{ route('item.destroy', ['id' => $item->id]) }}"  class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger d-inline" onclick="return confirm('本当に削除しますか？');">削除</button>
                </form>
            </div>
        </div>
    </div>
</div>

@stop

@section('css')
@stop

@section('js')
<!--フォームの選択、タイプでコーヒーを選ぶとoriginが入力できるようになる-->
<!--originのnullable-->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const typeSelect = document.getElementById('type');
        const originInput = document.getElementById('origin');
        let previousOriginValue = originInput.value; // 初期状態を保存

        const toggleOtherField = () => {
            if (typeSelect.value !== '1') {
                //typeが1の時にoriginを無効化
                previousOriginValue = originInput.value;
                originInput.disabled = true; // originを無効化
                originInput.style.backgroundColor = '#eee'; // 背景色をグレーに
                originInput.value = ''; // originの値を消す
            } else {
                //typeが1の時にoriginを有効化
                originInput.disabled = false; // originを有効化
                originInput.style.backgroundColor = ''; // 背景色を元に戻す
                originInput.value = previousOriginValue;
            }
        };

        // 初期チェック（ページロード時の選択状態に応じて処理）
        toggleOtherField();

        // typeが変更されたときにoriginの表示を切り替え
        typeSelect.addEventListener('change', toggleOtherField);

    });   
</script>

<!--同じ名前でアイテム登録しようとすると、アラートが表示される-->
<script>
document.getElementById('edit-form').addEventListener('submit', async function (e) {
    e.preventDefault();

    const name = document.getElementById('name').value;
    const itemId = {{ $item->id }}; // 自分自身のIDを渡す

    const res = await fetch("{{ route('item.checkName') }}", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ name: name, ignore_id: itemId }) // ここでIDも送信
    });

    const data = await res.json();

    if (data.exists) {
        const result = confirm('同じ名前の商品が既に存在します。本当に保存しますか？');
        if (!result) {
            return;
        }
    }

    // 通過OKならフォーム送信
    e.target.submit();
});
</script>

@stop