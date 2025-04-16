@extends('adminlte::page')

@section('title', '商品登録')

@section('content_header')
    <h1 class="">商品登録</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-10">
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
                <form method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="form-group mb-5">
                            <label for="name">商品名</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="名前">
                        </div>

                        <div class="d-flex mb-3 justify-content-around">
                            <div class="form-group w-50">
                                <label for="type">商品の種類</label>
                                <select id="type" name="type" class="form-control" placeholder="商品の種類">
                                    <option value="1">コーヒー豆</option>
                                    <option value="2">その他材料</option>
                                    <option value="3">雑貨類</option>
                                </select>
                            </div>

                            <div class="form-group w-40">
                                <label for="origin">産地</label>
                                <select id="origin" name="origin" class="form-control" placeholder="産地">
                                    <option value="1">ブラジル</option>
                                    <option value="2">エチオピア</option>
                                    <option value="3">コロンビア</option>
                                    <option value="4">ジャマイカ</option>
                                    <option value="5">ハワイ</option>
                                    <option value="6">グアテマラ</option>
                                    <option value="7">その他</option>
                                </select>
                                <div id="origin" class="form-text text-muted fs-6">※商品の種類で「コーヒー豆」を選んだ場合のみ選択してください</div>
                            </div>
                        </div>

                        <div class="form-group mb-4">
                            <label for="detail">詳細</label>
                            <input type="text" class="form-control" id="detail" name="detail" placeholder="詳細説明">
                            <div id="detail" class="form-text text-muted fs-6">※1000文字以内で入力してください</div>
                        </div> 

                        <div class="form-group">
                            <label for="image">商品の写真を選択してください</label><br>
                            <input type="file" id="image" name="image" onchange="preview(this)"; accept=".jpg, .jpeg, .png"/>
                            <div id="image" class="form-text text-muted fs-6">※.jpg、.jpeg、.pngのみ対応</div>
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
@stop
