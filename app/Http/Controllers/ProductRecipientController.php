<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductRecipientModel;
use App\Models\ProductsModel;

class ProductRecipientController extends Controller
{
    public function store(Request $request) {
      
      try {
        
        \DB::beginTransaction();
        
        $recipient_id = $request->get('recipient_id');
        $loop = $request->get('product_id');
        foreach ($loop as $value){
          $product = ProductsModel::where('id', $value)->update(['status'=>2]);
          $product_recipient = new ProductRecipientModel;
          $product_recipient->product_id = $value;
          $product_recipient->recipient_id = $recipient_id;
          $product_recipient->save();
        }
        \DB::commit();
        } catch (Throwable $e) {
            \DB::rollback();
        }
      return redirect('/product/index');
    }
}
