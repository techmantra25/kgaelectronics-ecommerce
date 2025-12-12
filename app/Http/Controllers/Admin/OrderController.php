<?php

namespace App\Http\Controllers\Admin;

use App\Interfaces\OrderInterface;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    // private OrderInterface $orderRepository;

    public function __construct(OrderInterface $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    public function index(Request $request)
    {
        if (!empty($request->status)) {
            if (!empty($request->term)) {
                $data = $this->orderRepository->listByStatus($request->status);
                $data = $this->orderRepository->searchOrder($request->term);
            } else {
                $data = $this->orderRepository->listByStatus($request->status);
            }
        } else {
            $data = $this->orderRepository->listAll();
        }

        return view('admin.order.index', compact('data'));
    }

    public function indexStatus(Request $request, $status)
    {
        $data = $this->orderRepository->listByStatus($status);
        return view('admin.order.index', compact('data'));
    }

    public function store(Request $request)
    {
        $request->validate([
            "name" => "required|string|max:255",
            "type" => "required|integer",
            "amount" => "required",
            "max_time_of_use" => "required|integer",
            "max_time_one_can_use" => "required|integer",
            "start_date" => "required",
            "end_date" => "required",
        ]);

        $params = $request->except('_token');
        $storeData = $this->orderRepository->create($params);

        if ($storeData) {
            return redirect()->route('admin.order.index');
        } else {
            return redirect()->route('admin.order.create')->withInput($request->all());
        }
    }

    public function show(Request $request, $id)
    {
        $data = $this->orderRepository->listById($id);
        return view('admin.order.detail', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            "name" => "required|string|max:255",
            "type" => "required|integer",
            "amount" => "required",
            "max_time_of_use" => "required|integer",
            "max_time_one_can_use" => "required|integer",
            "start_date" => "required",
            "end_date" => "required",
        ]);

        $params = $request->except('_token');
        $storeData = $this->orderRepository->update($id, $params);

        if ($storeData) {
            return redirect()->route('admin.order.index');
        } else {
            return redirect()->route('admin.order.create')->withInput($request->all());
        }
    }

    public function status(Request $request, $id, $status)
    {
        $storeData = $this->orderRepository->toggle($id, $status);

        if ($storeData) {
            return redirect()->back();
        } else {
            return redirect()->route('admin.order.index');
        }
    }

public function statusPost(Request $request)
{
    // Order update
    $updatedEntry = Order::findOrFail($request->id);
    $updatedEntry->status = $request->status;
    
    if ($updatedEntry->save()) {
        // Fetching ordered products
        $orderedProducts = OrderProduct::where('order_id', $updatedEntry->id)->get()->toArray();

        // Determine status titles and descriptions
        $statusDetails = [
            1 => ['title' => 'New', 'desc' => 'We are currently processing your order'],
            2 => ['title' => 'Confirmed', 'desc' => 'Your order is confirmed'],
            3 => ['title' => 'Shipped', 'desc' => 'Your order is Shipped. It will reach you soon'],
            4 => ['title' => 'Delivered', 'desc' => 'Your order is delivered'],
            5 => ['title' => 'Cancelled', 'desc' => 'Your order is cancelled'],
        ];

        // Default to 'New' status if not matched
        $statusTitle = $statusDetails[$updatedEntry->status]['title'] ?? 'New';
        $statusDesc = $statusDetails[$updatedEntry->status]['desc'] ?? 'We are currently processing your order';

        // Email data
        $email_data = [
            'name' => $updatedEntry->fname . ' ' . $updatedEntry->lname,
            'subject' => 'KGA Electronics - Order update for #' . $updatedEntry->order_no,
            'email' => $updatedEntry->email, // Replace with actual recipient email
            'orderId' => $updatedEntry->id,
            'orderNo' => $updatedEntry->order_no,
            'orderAmount' => $updatedEntry->final_amount,
            'status' => $updatedEntry->status,
            'statusTitle' => $statusTitle,
            'statusDesc' => $statusDesc,
            'orderProducts' => $orderedProducts, // Uncomment if needed in the Blade view
            'blade_file' => 'front/mail/order-update',
        ];

        // Send email
        try {
            Mail::send($email_data['blade_file'], $email_data, function ($message) use ($email_data) {
                $message->to($email_data['email'])
                        ->subject($email_data['subject'])
                        ->from('info@kgaelectronics.com');
            });
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'message' => 'Failed to send email: ' . $e->getMessage()]);
        }

        return response()->json(['error' => false, 'message' => 'Order status updated and email sent successfully']);
    } else {
        return response()->json(['error' => true, 'message' => 'Failed to update order status']);
    }
}


    
    public function invoice(Request $request, $id)
    {
        $data = $this->orderRepository->listById($id);
		//dd($data);
        return view('admin.order.invoice', compact('data'));
    }

    // public function destroy(Request $request, $id)
    // {
    //     $this->orderRepository->delete($id);

    //     return redirect()->route('admin.order.index');
    // }
}
