<?php
/*
        https://www.shopid.ir
        https://github.com/shopid-dev
        alaeebehnam@gmail.com
        https://t.me/theycallmebehnam

*/
namespace shopid;



class zarinPal
{
    private  $callBackUrl;
    private  $merchantId;
    function __construct($param)
    {

        $this->callBackUrl = $param['callBackUrl'];
        $this->merchantId = $param['merchantId'];
    }

    public function apiRequest($param)
    {

        $data = array(
            "merchant_id" => $this->merchantId,
            "amount" => $param['amount'],
            "callback_url" => $this->callBackUrl,
            "description" => $param['description'],
            "metadata" => ["email" => $param['email'], "mobile" => $param['mobile']],
        );

        $jsonData = json_encode($data);
        $ch = curl_init('https://api.zarinpal.com/pg/v4/payment/request.json');
        curl_setopt($ch, CURLOPT_USERAGENT, 'ZarinPal Rest Api v1');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($jsonData)
        ));

        $result = curl_exec($ch);
        $err = curl_error($ch);
        $result = json_decode($result, true, JSON_PRETTY_PRINT);


        curl_close($ch);

        if ($err) {
            
            throw new \Exception(json_encode(["error" => ["code"=>9999,"message"=>$err]] ));
            
        } else {
            if (empty($result['errors'])) {
                if ($result['data']['code'] == 100) {
                    return json_encode(["url" => 'https://www.zarinpal.com/pg/StartPay/' . $result['data']["authority"], "authority" => $result['data']["authority"]]);
                }
            } else {

                throw new \Exception(json_encode(["error" => $result['errors']]));
            }
        }
    }


    public function verify($param)
    {

        $data = array("merchant_id" => $this->merchantId, "authority" => $param['authority'], "amount" => $param['amount']);
        $jsonData = json_encode($data);
        $ch = curl_init('https://api.zarinpal.com/pg/v4/payment/verify.json');
        curl_setopt($ch, CURLOPT_USERAGENT, 'ZarinPal Rest Api v4');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($jsonData)
        ));

        $result = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);
        $result = json_decode($result, true);

        if ($err) {
            
            throw new \Exception(json_encode(["error" => ["code"=>9999,"message"=>$err]] ));
            
        } else {
            if (isset($result['errors']) && count($result['errors']) > 0) {
                throw new \Exception(json_encode(["error" => $result['errors']]));
            } else {

                return json_encode($result['data']);
            }
        }
    }
}




