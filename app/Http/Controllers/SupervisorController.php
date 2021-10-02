<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SupervisorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function home(Request $request)
    {
        $orders_identefier = "";
        if ($request->query("order_requests") && $request->query("order_requests") === "canceled") {
            $orders_identefier = "canceled";
            $orders = Order::where("supervisor_id", auth()->user()->id)->select("id")->get();
            $orders = $orders->map(function ($items) {
                return $items->id;
            });

            $orders = DB::table('canceled_orders')->whereIn("order_id", $orders->toArray())
            ->join("orders", "canceled_orders.order_id", "=", "orders.id")
            ->select("orders.*");
        } elseif ($request->query("order_requests") && $request->query("order_requests") === "rejected") {
            $orders_identefier = "rejected";
            $orders = Order::where("supervisor_id", auth()->user()->id)->select("id")->get();
            $orders = $orders->map(function ($items) {
                return $items->id;
            });

            $orders = DB::table('returned_orders')->whereIn("order_id", $orders->toArray())
            ->join("orders", "returned_orders.order_id", "=", "orders.id")
            ->select("orders.*");
        } else {
            $orders_identefier = "all";
            $orders = Order::where("supervisor_id", auth()->user()->id);
        }
        
        if ($request->query()) {

            if ($request->query("search_by")) {
                if ($request->query("search_by") === "order_id") {
                    $orders = $orders->where("orders.id", $request->query("search_value"));
                } else if ($request->query("search_by") === "order_total") {
                    $orders = $orders->where("total", $request->query("search_value"));
                }
            }

            if ($request->query("status")){
                $imploded = implode("', '", $request->query("status"));
                $imploded = "'" . $imploded . "'";
                $orders->whereRaw("status in (" . $imploded . ")");
            }
            
            if ($request->query("sort_by") === "newOrder") {
                $orders->orderBy("created_at", "desc");
            } elseif ($request->query("sort_by") === "oldOrder") {
                $orders->orderBy("created_at", "asc");
            } elseif ($request->query("sort_by") === "highTotal") {
                $orders->orderBy("total", "desc");
            } elseif ($request->query("sort_by") === "lowTotal") {
                $orders->orderBy("total", "asc");
            }
        
        }

        if ($orders_identefier !== "all") {
            $orders = $orders->get();
            $orders = $orders->groupBy("id");
            $orders_array = [];
            foreach ($orders as $value) {$orders_array[] = $value[0]; }
            $orders = $orders_array;
        } elseif ($request->query("search_by")) {
            $orders = $orders->get();
        } else {
            $orders = $orders->paginate(20);
        }

        return view("supervisor.home", [
            "orders" => $orders,
            "orders_identefier" => $orders_identefier,
        ]);
    }
    
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
