<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CategoryModel;
use App\Models\StatusProductModel;

class AdminController extends Controller
{
  public function index() {
    return view('admin.index');
  }

  public function showProduct(Request $request) {
    $sort = $request->query('product_sort', "");
    $searchKeyword = $request->query('product_name', "");
    $category_id = (int) $request->query('category_id', 0);
    $status_id = (int) $request->query('product_status', 0);
    $queryORM = \DB::table('products')->where('product_name', "LIKE", "%".$searchKeyword."%")
            ->leftjoin('product_recipient', 'product_recipient.product_id', '=', 'products.id')
            ->leftjoin('product_shippers', 'product_shippers.product_id', '=', 'products.id')
            ->join('contributors', 'contributors.id', '=', 'products.user_id')
            ->leftjoin('contributors AS recipient', 'recipient.id', '=', 'product_recipient.recipient_id')
            ->leftjoin('contributors AS shipper', 'shipper.id', '=', 'product_shippers.shipper_id')
            ->join('status_products', 'status_products.id', '=', 'products.status')
            ->select('products.id','products.product_name','products.product_quantity','products.product_desc', 'products.product_enpiry', 'products.date_contribute',
                      'status_name', 
                      'contributors.name', 'contributors.number_phone', 'contributors.address',
                      'recipient.name AS recipient_name', 'recipient.number_phone AS recipient_number_phone', 'recipient.address AS recipient_address',
                      'shipper.name AS shipper_name', 'shipper.number_phone AS shipper_number_phone');
    if($category_id != 0) {
      $queryORM = $queryORM->where('category_id', $category_id);
    }
    if($status_id != 0) {
      $queryORM = $queryORM->where('status_products.id',  $status_id);
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
    $status = StatusProductModel::all();
    $data["status"] = $status;
    $data['stt'] = 0;
    return view('admin.product', $data);
  }

 

}
