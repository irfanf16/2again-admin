<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Shop;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function shopView(){
        $shopModal = Shop::all();

        $shop['boost'] =    $shopModal->where('type', 'Boost')->all();
        $shop['gold'] =     $shopModal->where('type', 'Gold')->all();
        $shop['bs'] =       $shopModal->where('type', 'BS')->all();
        $shop['vip'] =      $shopModal->where('type', 'VIP')->all();
        $shop['call'] =     $shopModal->where('type', 'Call')->all();
        $shop['like']   =   $shopModal->where('type', 'Like')->all();
        $shop['video']   =   $shopModal->where('type', 'Video')->all();
        $shop['photo']   =   $shopModal->where('type', 'Photo')->all();
        $shop['favorite']   =   $shopModal->where('type', 'Favorite')->all();
        $shop['superlike']   =   $shopModal->where('type', 'SuperLike')->all();

        return view('admin.pages.shop')->with(compact('shop'))->with(compact('shop'));
    }

    public function update(Request $request){

        foreach($request['items'] as $item){
            $shop = Shop::find($item['id']);
            $shop->update([
                'quantity' => $item['quantity'],
                'price'     =>  $item['price']
            ]);
        }

        return 1;
    }
    public function add(Request $request){
        Shop::create($request->all());
        return back()->with('success','Added successfully');

    }
    public function remove($id){
        Shop::find($id)->delete();
        return 1;
    }
}
