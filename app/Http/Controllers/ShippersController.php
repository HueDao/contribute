<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helper\SessionHelper;
use App\Models\ProductsModel;
use App\Models\CategoryModel;
use App\Models\StatusProductModel;
use App\Models\ProductShippersModel;
use App\Models\OrdersModel;
use App\Models\OrderDetailModel;
use App\Models\OrdersShipperModel;
use Illuminate\Support\Facades\Redirect;


class ShippersController extends Controller
{
    public function index() {
      $orders = OrdersModel::where('type', 1)
                            ->where('order_status', 1)
                            ->join('status_order', 'status_order.id','orders.order_status')
                            ->select('orders.id','total_product','order_status_name','orders.created_at')
                            ->get();
      $data['orders'] =  $orders;
      return view('shippers.index', $data);
    }

    public function orderReceive( SessionHelper $sessionHelper) {
      $shipper_id = $sessionHelper->get()["id"];
      $orders = OrdersModel::where('type', 1)
                            ->join('orders_shipper', 'orders_shipper.order_id', '=', 'orders.id')
                            ->where('orders_shipper.shipper_id', $shipper_id)
                            ->join('status_order', 'status_order.id','orders.order_status')
                            ->select('orders.id','total_product','order_status_name','orders.created_at')
                            ->get();
      $data['orders'] =  $orders;
      return view('shippers.order_receive', $data);
    }

    public function orderDetail($id) {
      $products_id = OrderDetailModel::where('order_id', $id)->select('product_id')->get()->toArray();
      // dd($products_id);die;
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
      return view('shippers.order_detail', $data);
    }

    public function shipReceiveOrder(Request $request, SessionHelper $sessionHelper) {
      try {
        \DB::beginTransaction();
        $shipper_id = $sessionHelper->get()["id"];
        $order_id = $request->get('order_id');
        $loop = $request->get('products_id');
        $order = OrdersModel::where('id', $order_id)->update(['order_status'=>2]);
        $order_shipper = new OrdersShipperModel;
        $order_shipper->order_id = $order_id ;
        $order_shipper->shipper_id = $shipper_id;
        $order_shipper->save();
        foreach ($loop as $value){
          $product = ProductsModel::where('id', $value)->update(['status'=>3]);
        }
        \DB::commit();
       
      } catch (Throwable $e) {
          \DB::rollback();
      }
      return Redirect::back()->with('infor', 'Nhận đơn hàng thành công!');
    }

    public function getListOrderWaitDelivery() {
      $orders = OrdersModel::where('type', 2)
                            ->where('order_status', 1)
                            ->join('status_order', 'status_order.id','orders.order_status')
                            ->select('orders.id','total_product','order_status_name','orders.created_at')
                            ->get();
      $data['orders'] =  $orders;
      return view('shippers.list_order_delivery', $data);
    }

    // public function movingProduct(SessionHelper $sessionHelper){
    //   $shipper_id = $sessionHelper->get()["id"];
    //   $products = \DB::table('products')
    //   ->where('status', 3)->orWhere('status', 4)
    //   ->join('product_shippers', 'product_shippers.product_id', '=', 'products.id')
    //   ->where('product_shippers.shipper_id', $shipper_id)
    //   ->join('product_recipient', 'product_recipient.product_id', '=', 'products.id')
    //   ->join('contributors', 'contributors.id', '=', 'products.user_id')
    //   ->join('contributors AS recipient', 'recipient.id', '=', 'product_recipient.recipient_id')
    //   ->join('status_products', 'status_products.id', '=', 'products.status')
    //   ->select('products.id','products.product_name','products.product_quantity','products.product_desc', 'products.product_enpiry', 'products.date_contribute',
    //             'status_name', 
    //             'contributors.name', 'contributors.number_phone', 'contributors.address',
    //             'recipient.name AS recipient_name', 'recipient.number_phone AS recipient_number_phone', 'recipient.address AS recipient_address')
    //   ->get();
    //   $data['products'] = $products;
    //   $data['stt'] = 0;
    //   return view('shippers.moving', $data);
    // }
}
