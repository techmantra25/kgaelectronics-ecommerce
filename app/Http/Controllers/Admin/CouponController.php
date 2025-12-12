<?php

namespace App\Http\Controllers\Admin;

use App\Interfaces\CouponInterface;
use App\Models\Coupon;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CouponController extends Controller
{
    // private CouponInterface $couponRepository;

    public function __construct(CouponInterface $couponRepository)
    {
        $this->couponRepository = $couponRepository;
    }

    public function index(Request $request)
    {
        if (!empty($request->term)) {
            $data = $this->couponRepository->getSearchCoupons($request->term);
        } else {
            $data = $this->couponRepository->listAllCoupons();
        }
        return view('admin.coupon.index', compact('data'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            "is_coupon" => "required|integer",
            "name" => "required|string|max:255",
            "coupon_code" => "required|string|max:255",
            "type" => "required|integer",
            "amount" => "required",
            "max_time_of_use" => "required|integer",
            "max_time_one_can_use" => "required|integer",
            "start_date" => "required",
            "end_date" => "required",
        ]);
		if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }else{
        $params = $request->except('_token');
        $storeData = $this->couponRepository->create($params);

        if ($storeData) {
            return redirect()->route('admin.coupon.index')->with('success', 'New coupon created');
        } else {
            return redirect()->route('admin.coupon.create')->withInput($request->all())->with('success', 'Something happened');
        }
		}
    }

    public function show(Request $request, $id)
    {
        $data = $this->couponRepository->listById($id);
        $usage = $this->couponRepository->usageById($id);
        return view('admin.coupon.detail', compact('data', 'usage'));
    }

    public function update(Request $request, $id)
    {
        // dd($request->all());

        $validator = Validator::make($request->all(),[
            "name" => "required|string|max:255",
            "coupon_code" => "required|string|max:255",
            "type" => "required|integer",
            "amount" => "required",
            "max_time_of_use" => "required|integer",
            "max_time_one_can_use" => "required|integer",
            "start_date" => "required",
            "end_date" => "required",
        ]);
		if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }else{
        $params = $request->except('_token');
        $storeData = $this->couponRepository->update($id, $params);

        if ($storeData) {
            return redirect()->route('admin.coupon.index')->with('success', 'Coupon updated');
        } else {
            return redirect()->route('admin.coupon.create')->withInput($request->all())->with('success', 'Something happened');
        }
		}
    }

    public function status(Request $request, $id)
    {
        $storeData = $this->couponRepository->toggle($id);

        if ($storeData) {
            return redirect()->route('admin.coupon.index');
        } else {
            return redirect()->route('admin.coupon.create')->withInput($request->all());
        }
    }

    public function destroy(Request $request, $id)
    {
        $this->couponRepository->delete($id);

        return redirect()->route('admin.coupon.index');
    }

    public function bulkDestroy(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'bulk_action' => 'required',
            'delete_check' => 'required|array',
        ], [
            'delete_check.*' => 'Please select at least one item'
        ]);

        if (!$validator->fails()) {
            if ($request['bulk_action'] == 'delete') {
                foreach ($request->delete_check as $index => $delete_id) {
                    Coupon::where('id', $delete_id)->delete();
                }

                return redirect()->route('admin.coupon.index')->with('success', 'Selected items deleted');
            } else {
                return redirect()->route('admin.coupon.index')->with('failure', 'Please select an action')->withInput($request->all());
            }
        } else {
            return redirect()->route('admin.coupon.index')->with('failure', $validator->errors()->first())->withInput($request->all());
        }
    }
}