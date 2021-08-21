<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helper\SessionHelper;
use App\Models\ProductsModel;
use App\Models\CategoryModel;
use App\Models\StatusProductModel;
use App\Models\OrdersModel;
use App\Models\OrderDetailModel;
use App\Models\StatusOrderModel;
use App\Models\OrderStoreModel;
use Illuminate\Support\Facades\Redirect;

class StoreController extends Controller
{
    public function index(Request $request) {
        $sort = $request->query('product_sort', "");
        $searchKeyword = $request->query('product_name', "");
        $category_id = (int) $request->query('category_id', 0);
        $queryORM = \DB::table('products')->where('product_name', "LIKE", "%".$searchKeyword."%")
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
        return view('store.index', $data);
    }

    public function orderCreate(Request $request, $type) {
      try {
        \DB::beginTransaction();
        $loop = $request->get('product_id');
        if(is_null($loop)) {
            return Redirect::back()->with('note', 'Chưa chọn sản phẩm để tạo đơn!');
        }
        $total_product = count($loop);
        
        $order = new OrdersModel();
        $order->total_product = $total_product;
        $order->is_deleted = 1;
        $order->type = $type;
        
        $order->save();
        $order_id = $order->id;
        if($type == 2) {
          $product_status = 8;
        } else {
          $product_status = 7;
        }
        foreach ($loop as $value){
          $product = ProductsModel::where('id', $value)->update(['status'=>$product_status]);
          $order_detail = new OrderDetailModel;
          $order_detail->product_id = $value;
          $order_detail->order_id = $order_id;
          $order_detail->save();
        }
        \DB::commit();
      } catch (Throwable $e) {
          \DB::rollback();
      }
      return Redirect::back()->with('infor', 'Tạo đơn lấy hàng công!');
    }

    public function indexDelivery(Request $request) {
      $sort = $request->query('product_sort', "");
      $searchKeyword = $request->query('product_name', "");
      $category_id = (int) $request->query('category_id', 0);
      $queryORM = \DB::table('products')->where('product_name', "LIKE", "%".$searchKeyword."%")
              ->where('status', 6)
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
      return view('store.create_delivery', $data);
  }

  public function orderCreateDelivery(Request $request, $type) {
    try {
      \DB::beginTransaction();
      $loop = $request->get('product_id');
      if(is_null($loop)) {
          return Redirect::back()->with('note', 'Chưa chọn sản phẩm để tạo đơn!');
      }
      $total_product = count($loop);
      $order = new OrdersModel;
      $order->total_product = $total_product;
      $order->is_deleted = 1;
      $order->type = $type;
      $order->order_status = 2;
      $order->save();
      $order_id = $order->id;
      foreach ($loop as $value){
        $product = ProductsModel::where('id', $value)->update(['status'=>8]);
        $order_detail = new OrderDetailModel;
        $order_detail->product_id = $value;
        $order_detail->order_id = $order_id;
        $order_detail->save();
      }
      \DB::commit();
    } catch (Throwable $e) {
        \DB::rollback();
    }
    return Redirect::back()->with('infor', 'Tạo đơn giao hàng công!');
  }

  public function listOrderContribute(){
    $orders = OrdersModel::where('type', 1)
                            ->join('status_order', 'status_order.id','orders.order_status')
                            ->select('orders.id','total_product','order_status_name','orders.created_at')
                            ->get();
    $data['orders'] =  $orders;
    return view('store.list_order_contribute', $data);
  }

  public function orderDetailContributor($id){
    $products_id = OrderDetailModel::where('order_id', $id)->select('product_id')->get()->toArray();
    $order = OrdersModel::where('id', $id)->get();
      $products = ProductsModel::whereIn('products.id', $products_id)
              ->join('contributors', 'contributors.id', '=', 'products.user_id')
              ->join('status_products', 'status_products.id', '=', 'products.status')
              ->select('products.id','products.product_name','products.product_quantity','products.product_desc', 'products.product_enpiry', 'products.date_contribute',
                        'status_name',
                        'contributors.name', 'contributors.number_phone', 'contributors.address')
              ->get();
      $data['products'] = $products;
      $data['stt'] = 0;
      $data['order_id'] = $id;
      $data['order_status'] = $order[0]['order_status'];
      return view('store.order_detail_contributor', $data);
  }

  public function importStore(Request $request, SessionHelper $sessionHelper) {
    try {
      \DB::beginTransaction();
        $store_id = $sessionHelper->get()["id"];
        $order_id = $request->get('order_id');
        $loop = $request->get('products_id');
        $order = OrdersModel::where('id', $order_id)->update(['order_status'=>4]);
        $order_store = new OrderStoreModel;
        $order_store->order_id = $order_id ;
        $order_store->store_id = $store_id;
        $order_store->save();
        foreach ($loop as $value){
          $product = ProductsModel::where('id', $value)->update(['status'=>6]);
        }
      \DB::commit();
     
    } catch (Throwable $e) {
        \DB::rollback();
    }
    return redirect('/list_order_contributor')->with('infor', 'Nhập kho thành công!');
  }

  public function listOrderDelivery() {
    $orders = OrdersModel::where('type', 2)
                        ->join('status_order', 'status_order.id','orders.order_status')
                        ->select('orders.id','total_product','order_status_name','orders.created_at')
                        ->get();
    $data['orders'] =  $orders;
    return view('store.list_order_delivery', $data);
  }

  public function orderDetailDelivery($id) {
    $products_id = OrderDetailModel::where('order_id', $id)->select('product_id')->get()->toArray();
    $order = OrdersModel::where('id', $id)->get();
    $products = ProductsModel::whereIn('products.id', $products_id)
            ->join('contributors', 'contributors.id', '=', 'products.user_id')
            ->join('status_products', 'status_products.id', '=', 'products.status')
            ->select('products.id','products.product_name','products.product_quantity','products.product_desc', 'products.product_enpiry', 'products.date_contribute',
                      'status_name',
                      'contributors.name', 'contributors.number_phone', 'contributors.address')
            ->get();
    $data['products'] = $products;
    $data['stt'] = 0;
    $data['order_id'] = $id;
    $data['order_status'] = $order[0]['order_status'];
    return view('store.order_detail_delivery', $data);
  }


}
