<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductRecipientModel;

class ProductRecipientController extends Controller
{
    public function store(Request $request) {
      $recipient_id = $request->get('recipient_id');
      $loop = $request->get('product_id');
      foreach ($loop as $value){
          $product_recipient = new ProductRecipientModel;
          $product_recipient->product_id = $recipient_id;
          $product_recipient->recipient_id = $value;
          $product_recipient->save();
      }
      return redirect('/product/index');
    }
}
