@extends('adminlte::page')

@section('title', '商品登録')

@section('content_header')
    <h1 class="">商品登録</h1>
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
                <form method="POST" action="{{ route('item.store') }}">
                    @csrf
                    <div class="card-body">
                        <div class="form-group mb-5">
                            <label for="name">商品名</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="名前">
                            <div id="name-help" class="form-text text-muted fs-6">※商品名は100文字以内で入力してください</div>
                            <!--エラーメッセージ-->
                            <div id="name-error" class="form-text text-danger fs-6" style="display: none;"></div>
                        </div>

                        <div class="d-flex mb-3 justify-content-around">
                            <div class="form-group w-50">
                                <label for="type">商品の種類</label>
                                <select id="type" name="type" class="form-control" placeholder="商品の種類">
                                    @foreach ($types as $key => $type)
                                        <option value="{{ $key }}">{{ $type }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group w-40">
                                <label for="origin">産地</label>
                                <select id="origin" name="origin" class="form-control" placeholder="産地">
                                    <option value="" disabled selected>選択してください</option><!--初期値の空のオプション--> 
                                    @foreach ($origins as $key => $origin)
                                        <option value="{{ $key }}" {{ old('origin', null) == $key ? 'selected' : '' }}>{{ $origin }}</option>
                                    @endforeach
                                </select>
                                <div id="origin" class="form-text text-muted fs-6">※商品の種類で「コーヒー豆」を選んだ場合のみ選択してください</div>
                            </div>
                        </div>

                        <div class="form-group mb-4">
                            <label for="detail">詳細</label>
                            <textarea name="detail" id="detail" class="form-control"></textarea>
                            <div id="detail" class="form-text text-muted fs-6">※1000文字以内で入力してください</div>
                        </div> 
                    </div>
 
                    <div class="card-footer text-center">
                        <button type="submit" class="btn btn-primary">登録</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop

@section('css')
@stop

@section('js')

<!--originのnullable-->
<!--フォームの選択、タイプでコーヒーを選ぶとoriginが入力できるようになる-->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const typeSelect = document.getElementById('type');
        const originInput = document.getElementById('origin');

        const toggleOtherField = () => {
            if (typeSelect.value !== '1') {
                //typeが1の時にoriginを無効化
                originInput.disabled = true; // originを無効化
                originInput.style.backgroundColor = '#eee'; // 背景色をグレーに
                originInput.value = ''; // originの値を消す
            } else {
                //typeが1の時にoriginを有効化
                originInput.disabled = false; // originを有効化
                originInput.style.backgroundColor = ''; // 背景色を元に戻す
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
document.querySelector('form').addEventListener('submit', async function (e) {
    e.preventDefault();

    const name = document.getElementById('name').value;

    const res = await fetch("{{ route('item.checkName') }}", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ name: name })
    });

    const data = await res.json();

    if (data.exists) {
        alert('同じ名前の商品が既に登録されています');
        return; // 重複していたら登録しない
    }

    // 重複していないのでフォームを送信
    e.target.submit();
});
</script>
@stop
