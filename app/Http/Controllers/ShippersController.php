<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helper\SessionHelper;
use App\Models\ProductsModel;
use App\Models\CategoryModel;
use App\Models\StatusProductModel;
use App\Models\ProductShippersModel;

class ShippersController extends Controller
{
    public function index(Request $request) {
        $sort = $request->query('product_sort', "");
        $searchKeyword = $request->query('product_name', "");
        $category_id = (int) $request->query('category_id', 0);
        $queryORM = \DB::table('products')
                ->where('status', 2)
                ->join('product_recipient', 'product_recipient.product_id', '=', 'products.id')
                ->join('contributors', 'contributors.id', '=', 'products.user_id')
                ->join('contributors AS recipient', 'recipient.id', '=', 'product_recipient.recipient_id')
                ->join('status_products', 'status_products.id', '=', 'products.status')
                ->select('products.id','products.product_name','products.product_quantity','products.product_desc', 'products.product_enpiry', 'products.date_contribute',
                          'status_name', 
                          'contributors.name', 'contributors.number_phone', 'contributors.address',
                          'recipient.name AS recipient_name', 'recipient.number_phone AS recipient_number_phone', 'recipient.address AS recipient_address');
        if($category_id != 0) {
          $queryORM = $queryORM->where('category_id', $category_id);
        }
        if ($sort == "name_asc") {
          $queryORM->orderBy('product_name', 'asc');
        }
        if ($sort == "name_desc") {
          $queryORM->orderBy('product_name', 'desc');
        }
        if ($sort == "date_contribute_asc") {
          $queryORM->orderBy('date_contribute', 'asc');
        }
        if ($sort == "date_contribute_des") {
          $queryORM->orderBy('date_contribute', 'desc');
        }
        $products = $queryORM->get();       
        $data = [];
        $data['products'] = $products;
        $data["searchKeyword"] = $searchKeyword;
        $data["sort"] = $sort;
        $categories = CategoryModel::all();
        $data["categories"] = $categories;
        $data['stt'] = 0;
        return view('shippers.index', $data);
    }

    public function moving(Request $request, SessionHelper $sessionHelper) {
      
      try {
        \DB::beginTransaction();
        $shipper_id = $sessionHelper->get()["id"];
        $loop = $request->get('product_id');
        foreach ($loop as $value){
          $product = ProductsModel::where('id', $value)->update(['status'=>3]);
          $product_shipper = new ProductShippersModel;
          $product_shipper->product_id = $value;
          $product_shipper->shipper_id = $shipper_id;
          $product_shipper->save();
        }
        \DB::commit();
       
      } catch (Throwable $e) {
          \DB::rollback();
      }
      return redirect('/moving_product');
    }

    public function movingProduct(SessionHelper $sessionHelper){
      $shipper_id = $sessionHelper->get()["id"];
      $products = \DB::table('products')
      ->where('status', 3)->orWhere('status', 4)
      ->join('product_shippers', 'product_shippers.product_id', '=', 'products.id')
      ->where('product_shippers.shipper_id', $shipper_id)
      ->join('product_recipient', 'product_recipient.product_id', '=', 'products.id')
      ->join('contributors', 'contributors.id', '=', 'products.user_id')
      ->join('contributors AS recipient', 'recipient.id', '=', 'product_recipient.recipient_id')
      ->join('status_products', 'status_products.id', '=', 'products.status')
      ->select('products.id','products.product_name','products.product_quantity','products.product_desc', 'products.product_enpiry', 'products.date_contribute',
                'status_name', 
                'contributors.name', 'contributors.number_phone', 'contributors.address',
                'recipient.name AS recipient_name', 'recipient.number_phone AS recipient_number_phone', 'recipient.address AS recipient_address')
      ->get();
      $data['products'] = $products;
      $data['stt'] = 0;
      return view('shippers.moving', $data);
    }
}
