<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Models\ProductColorSize;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;

class UnicommerceController extends Controller
{
    // sync all product inside a product
    public function sync(Request $request, $id)
    {
        $productId = $id;
        $productvariation = ProductColorSize::where('product_id', $id)->get();
        foreach ($productvariation as $key => $value) {
            if (empty($value->code)) {
                return redirect()->back()->with('failure', 'SKU code missing for '.$value->sizeDetails->name);
            }

            $data = [];

            $data = [
                'id' => $value->id,
                'code' => $value->code,
            ];

            return $this->feedUnicommerce($data, $productId);
        }
    }

    public function syncSingle(Request $request, $id)
    {
        $productvariation = ProductColorSize::findOrFail($id);
        $productId = $productvariation->product_id;
        // foreach ($productvariation as $key => $value) {
            if (empty($productvariation->code)) {
                return redirect()->back()->with('failure', 'SKU code missing for '.$productvariation->colorDetails->name.' - '.$productvariation->sizeDetails->name);
            }

            $data = [];
            $data = [
                'id' => $productvariation->id,
                'code' => $productvariation->code,
            ];

            return $this->feedUnicommerce($data, $productId);
        // }
    }

    // unicommerce
    public function feedUnicommerce($data, $productId)
    {
        $loginCred = unicommerceLogin();
        $loginResp = json_decode($loginCred);

        // if (!isset($loginResp->successful)) {
        if (!isset($loginResp->successful) || $loginResp->successful == "true") {
            $url = 'https://cozyworld.unicommerce.com/services/rest/v1/channel/createChannelItemType';
            $headers = array(
                'Authorization: Bearer '.$loginResp->access_token,
                'Content-Type: application/json'
            );

            $channelProductId = mt_rand();

            $body2['channelItemType'] = [];
            $body2['channelItemType']['channelCode'] = "ONNINTERNATIONAL";
            // $body2['channelItemType']['channelProductId'] = "$channelProductId";
            $body2['channelItemType']['channelProductId'] = $data['code'];
            $body2['channelItemType']['sellerSkuCode'] = $data['code'];
            $body2['channelItemType']['skuCode'] = $data['code'];
            $body2['channelItemType']['blockedInventory'] = 0;
            $body2['channelItemType']['live'] = "true";
            $body2['channelItemType']['disabled'] = "false";

            // dd(json_encode($body2));

            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => json_encode($body2),
                CURLOPT_HTTPHEADER => $headers,
            ));

            $response = curl_exec($curl);

            curl_close($curl);
            $decoded_response = json_decode($response);

            // inventory map
            $inventoryUpdate = unicommerceInventory($data['code'], $loginResp->access_token);

            // dd($inventoryUpdate);

            // dd($decoded_response);

            if ($inventoryUpdate) {
                if ($decoded_response->successful == true) {
                    $payload = DB::table('third_party_payloads')->insert([
                        "type" => "unicommerce",
                        "status" => "success",
                        "order_id" => "",
                        "request_body" => json_encode($body2),
                        "payload" => $response
                    ]);
                    return redirect()->route('admin.product.edit', $productId)->with('success', 'Invertory synced');
                } else {
                    $payload = DB::table('third_party_payloads')->insert([
                        "type" => "unicommerce",
                        "status" => "failure",
                        "order_id" => "",
                        "request_body" => json_encode($body2),
                        "payload" => $response
                    ]);
                    return redirect()->route('admin.product.edit', $productId)->with('failure', 'Something happened');
                }
            }
        } else {
            $payload = DB::table('third_party_payloads')->insert([
                "type" => "unicommerce",
                "status" => "failure",
                "order_id" => "",
                "request_body" => json_encode($body2),
                "payload" => json_encode($loginResp)
            ]);
            return redirect()->back()->with('failure', 'Invalid login credentials');
        }
    }

    // unicommerce login
    /* public function unicommerceLogin()
    {
        $username = 'rohit@onenesstechs.in';
        $password = 'q%23393KHVqRBPDTE';

        $url = 'https://cozyworld.unicommerce.com/oauth/token?grant_type=password&client_id=my-trusted-client&username='.$username.'&password='.$password;

        $headers = array(
            'Content-Type: application/json'
        );

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => $headers,
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return $response;
    } */
}
