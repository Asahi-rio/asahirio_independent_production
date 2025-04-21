<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;
use Illuminate\Support\Facades\Log;

class ItemController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * 商品一覧
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
    
        $types = [
            1 => 'コーヒー豆',
            2 => 'その他材料',
            3 => '雑貨類',
        ];
    
        $origins = [
            1 => 'ブラジル',
            2 => 'コロンビア',
            3 => 'エチオピア',
            4 => 'ジャマイカ',
            5 => 'ハワイ',
            6 => 'グアテマラ',
            7 => 'その他',
        ];

        $query = Item::query();

        if (!empty($search)) {
            // typeとoriginで部分一致するキーを取得
            $matchedTypeIds = array_keys(array_filter($types, fn($type) => str_contains($type, $search)));
            $matchedOriginIds = array_keys(array_filter($origins, fn($origin) => str_contains($origin, $search)));
    
            $query->where(function($q) use ($search, $matchedTypeIds, $matchedOriginIds)
            {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('id', 'like', "%{$search}%")
                  ->orWhereIn('type', $matchedTypeIds)
                  ->orWhereIn('origin', $matchedOriginIds);
            });
        }

        $items = $query->paginate(10);
    
        return view('item.index', compact('items', 'types', 'origins','search'));
    }

    private function getFormData()
    {
        return [
            'types' => [
                1 => 'コーヒー豆',
                2 => 'その他材料',
                3 => '雑貨類',
            ],
            'origins' => [
                1 => 'ブラジル',
                2 => 'コロンビア',
                3 => 'エチオピア',
                4 => 'ジャマイカ',
                5 => 'ハワイ',
                6 => 'グアテマラ',
                7 => 'その他',
            ],
    ];
    }

    //フォームの情報
    public function create()
    {
        return view('item.add', $this->getFormData());
    }

    

    /**
     * 商品登録画面
     */
    public function store(Request $request)
    {
        $data = $this->getFormData();

        $types = [
            1 => 'コーヒー豆',
            2 => 'その他材料',
            3 => '雑貨類',
        ];
    
        $origins = [
            1 => 'ブラジル',
            2 => 'コロンビア',
            3 => 'エチオピア',
            4 => 'ジャマイカ',
            5 => 'ハワイ',
            6 => 'グアテマラ',
            7 => 'その他',
        ];

        // バリデーション
        $validated = $request->validate([
            'name' => 'required|max:100',
            'type' => 'required',
            'detail' => 'required|max:1000',
            'origin' => 'nullable', // origin が null の場合を許容
        ],[
            ///フォームの入力値が最大を超えた場合
            'name.max' => '商品名は100文字以内で入力してください',
            'detail.max' => '商品の詳細は1000字以内で入力してください', 
        ]);

        //商品登録
            Item::create([
            'user_id' => Auth::user()->id,
            'name' => $request->name,
            'type' => $request->type,
            'origin' => $request->origin,
            'detail' => $request->detail,
        ]);


      //登録後に完了画面へ遷移
      return redirect()->route('item.completion');

    }

    /**
     * 商品登録完了画面
     */
    public function completion(){
        return view('item.completion');
    }

    /**
     * 同じ名前でアイテムが登録されようとするとアラートが出る処理
     */
    public function checkName(Request $request){
        $exists = Item::where('name', $request->name)->exists();
        return response()->json(['exists' => $exists]);
    }

    /**
     * 商品説明画面(仮)
     */
    public function description($id)
    {
        $item = Item::findOrFail($id);
        return view('item.description', compact('item'));
    }

    /**
     * 商品編集画面
     */
    public function edit($id)
    {
        $item = Item::findOrFail($id);
        return view('item.edit', compact('item'));
    }


    /**商品編集を行うフォーム */
    public function update(Request $request, $id)
    {
        // アイテムの情報を取得
        $item = Item::findOrFail($id);

        // バリデーション
        $validated = $request->validate([
            'name' => 'required|max:100',
            'type' => 'required',
            'detail' => 'required|max:1000',
            'origin' => 'nullable', // origin が null の場合を許容
        ],[
            'name.max' => '商品名は100文字以内で入力してください',
            'detail.max' => '商品の詳細は1000字以内で入力してください', 
        ]);

        // アイテムの更新
        $item->update([
            'name' => $request->name,
            'type' => $request->type,
            'origin' => $request->origin,
            'detail' => $request->detail,
        ]);

        // 更新後、一覧画面にリダイレクト
        return redirect()->route('item.index')->with('success', '商品情報が更新されました！');
    }

    /**
     * アイテムの削除
     */
    public function destroy($id)
    {
        $item = Item::findOrFail($id);
        $item->delete();

        return redirect()->route('item.index')->with('success', '商品を削除しました');
    }

}
