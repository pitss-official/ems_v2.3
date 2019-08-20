<?php

namespace App;

use Illuminate\Database\Eloquent\Model;



class OnlinePayment extends Model
{
    protected $fillable=array('MID',
'TXNID',
'ORDERID',
'BANKTXNID',
'TXNAMOUNT',
'CURRENCY',
'STATUS',
'RESPCODE',
'RESPMSG',
'TXNDATE',
'GATEWAYNAME',
'BANKNAME',
'PAYMENTMODE',
'CHECKSUMHASH',
'BIN_NUMBER',
'CARD_LAST_NUMS',
'verified',
'request');
    public function encrypt_e($input, $ky) {
        $key   = html_entity_decode($ky);
        $iv = "@@@@&&&&####$$$$";
        $data = openssl_encrypt( $input , "AES-128-CBC" , $key, 0, $iv );
        return $data;
    }

    public function decrypt_e($crypt, $ky) {
        $key   = html_entity_decode($ky);
        $iv = "@@@@&&&&####$$$$";
        $data = openssl_decrypt ( $crypt , "AES-128-CBC" , $key, 0, $iv );
        return $data;
    }

    public function generateSalt_e($length) {
        $random = "";
        srand((double) microtime() * 1000000);
        $data = "AbcDE123IJKLMN67QRSTUVWXYZ";
        $data .= "aBCdefghijklmn123opq45rs67tuv89wxyz";
        $data .= "0FGH45OP89";
        for ($i = 0; $i < $length; $i++) {
            $random .= substr($data, (rand() % (strlen($data))), 1);
        }
        return $random;
    }

    public function checkString_e($value) {
        if ($value == 'null')
            $value = '';
        return $value;
    }

    public function getChecksumFromArray($arrayList, $key, $sort=1) {
        if ($sort != 0) {
            ksort($arrayList);
        }
        $str = $this->getArray2Str($arrayList);
        $salt = $this->generateSalt_e(4);
        $finalString = $str . "|" . $salt;
        $hash = hash("sha256", $finalString);
        $hashString = $hash . $salt;
        $checksum = $this->encrypt_e($hashString, $key);
        return $checksum;
    }

//    public function getChecksumFromString($str, $key) {
//
//        $salt = $this->generateSalt_e(4);
//        $finalString = $str . "|" . $salt;
//        $hash = hash("sha256", $finalString);
//        $hashString = $hash . $salt;
//        $checksum = $this->encrypt_e($hashString, $key);
//        return $checksum;
//    }

    public function verifychecksum_e($arrayList, $key, $checksumvalue) {
        $arrayList = $this->removeCheckSumParam($arrayList);
        ksort($arrayList);
        $str = $this->getArray2StrForVerify($arrayList);
        $paytm_hash = $this->decrypt_e($checksumvalue, $key);
        $salt = substr($paytm_hash, -4);
        $finalString = $str . "|" . $salt;
        $website_hash = hash("sha256", $finalString);
        $website_hash .= $salt;
        $validFlag = "FALSE";
        if ($website_hash == $paytm_hash) {
            $validFlag = "TRUE";
        } else {
            $validFlag = "FALSE";
        }
        return $validFlag;
    }
    public function verifychecksum_eFromStr($str, $key, $checksumvalue) {
        $paytm_hash = $this->decrypt_e($checksumvalue, $key);
        $salt = substr($paytm_hash, -4);
        $finalString = $str . "|" . $salt;
        $website_hash = hash("sha256", $finalString);
        $website_hash .= $salt;
        $validFlag = "FALSE";
        if ($website_hash == $paytm_hash) {
            $validFlag = "TRUE";
        } else {
            $validFlag = "FALSE";
        }
        return $validFlag;
    }

    public function getArray2Str($arrayList) {
        $findme   = 'REFUND';
        $findmepipe = '|';
        $paramStr = "";
        $flag = 1;
        foreach ($arrayList as $key => $value) {
            $pos = strpos($value, $findme);
            $pospipe = strpos($value, $findmepipe);
            if ($pos !== false || $pospipe !== false)
            {
                continue;
            }

            if ($flag) {
                $paramStr .= $this->checkString_e($value);
                $flag = 0;
            } else {
                $paramStr .= "|" . $this->checkString_e($value);
            }
        }
        return $paramStr;
    }

    public function getArray2StrForVerify($arrayList) {
        $paramStr = "";
        $flag = 1;
        foreach ($arrayList as $key => $value) {
            if ($flag) {
                $paramStr .= $this->checkString_e($value);
                $flag = 0;
            } else {
                $paramStr .= "|" . $this->checkString_e($value);
            }
        }
        return $paramStr;
    }


    public function redirect2PG($paramList, $key) {
        $hashString = $this->getchecksumFromArray($paramList);
        $checksum = $this->encrypt_e($hashString, $key);
    }

    public function removeCheckSumParam($arrayList) {
        if (isset($arrayList["CHECKSUMHASH"])) {
            unset($arrayList["CHECKSUMHASH"]);
        }
        return $arrayList;
    }
//
//    public function getTxnStatus($requestParamList) {
//        return $this->callAPI(PAYTM_STATUS_QUERY_URL, $requestParamList);
//    }
//
//    public function getTxnStatusNew($requestParamList) {
//        return $this->callNewAPI(PAYTM_STATUS_QUERY_NEW_URL, $requestParamList);
//    }
//    public function callAPI($apiURL, $requestParamList) {
//        $jsonResponse = "";
//        $responseParamList = array();
//        $JsonData =json_encode($requestParamList);
//        $postData = 'JsonData='.urlencode($JsonData);
//        $ch = curl_init($apiURL);
//        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
//        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
//        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//        curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);
//        curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0);
//        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
//                'Content-Type: application/json',
//                'Content-Length: ' . strlen($postData))
//        );
//        $jsonResponse = curl_exec($ch);
//        $responseParamList = json_decode($jsonResponse,true);
//        return $responseParamList;
//    }
//
//    public function callNewAPI($apiURL, $requestParamList) {
//        $jsonResponse = "";
//        $responseParamList = array();
//        $JsonData =json_encode($requestParamList);
//        $postData = 'JsonData='.urlencode($JsonData);
//        $ch = curl_init($apiURL);
//        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
//        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
//        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//        curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);
//        curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0);
//        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
//                'Content-Type: application/json',
//                'Content-Length: ' . strlen($postData))
//        );
//        $jsonResponse = curl_exec($ch);
//        $responseParamList = json_decode($jsonResponse,true);
//        return $responseParamList;
//    }
    public static function gatewayLockSettings()
    {
        if(System::getPropertyValueByName('config_paytm_dev_mode')==1){
            $mid=System::getPropertyValueByName('config_paytm_test_mid');
            $key=System::getPropertyValueByName('config_paytm_test_key');
            $url="https://securegw-stage.paytm.in/theia/processTransaction";
            $verify_url="https://securegw-stage.paytm.in/order/status";
        }
        else{
            $mid=System::getPropertyValueByName('config_paytm_prod_mid');
            $key=System::getPropertyValueByName('config_paytm_prod_key');
            $url="https://securegw.paytm.in/order/process";
            $verify_url="https://securegw.paytm.in/order/status";
        }
        return array('mid'=>$mid,'key'=>$key,'url'=>$url,'verify_url'=>$verify_url);
    }
    public function initiateRequest($pendingPaymentsTXID, $user, $amount,array $additionalParams=[]){
        $keys=self::gatewayLockSettings();
        $url=$keys['url'];
        $key=$keys['key'];
        $mid=$keys['mid'];
        $paytmParams = array(
            "MID" => $mid,
            "WEBSITE" => System::getPropertyValueByName('config_paytm_site_address'),
            "INDUSTRY_TYPE_ID" => "Retail",
            "CHANNEL_ID" => "WEB",
            "ORDER_ID" => $pendingPaymentsTXID,
            "CUST_ID" => $user->collegeUID,
            "MOBILE_NO" => $user->mobile,
            "EMAIL" => $user->email,
            "TXN_AMOUNT" => $amount,
//            "CALLBACK_URL" => "https://oms.megaminds.club/payment/status",
//            "CALLBACK_URL" => "https://webhook.site/6b2dde5f-2625-4308-a345-3a54c7c073d7",
            "CALLBACK_URL" => "https://oms.megaminds.club/payment/status",
        )+$additionalParams;
        $checksum = $this->getChecksumFromArray($paytmParams, $key);
        return view('layouts.payments.online',['url'=>$url,'params'=>$paytmParams,'checksum'=>$checksum]);
    }
    public function addMoneyRequest($pendingPaymentsTXID, User $user, $amount)
    {
        $additionalParam=array();
        if(System::getPropertyValueByName('defaults_add-money_specific_only')==1){
            $additionalParam=array(
                'PAYMENT_MODE_ONLY'=>'YES',
                'AUTH_MODE'=>System::getPropertyValueByName('defaults_add-money_only_type_AUTH'),
                'PAYMENT_TYPE_ID'=>System::getPropertyValueByName('defaults_add-money_only_type')
            );
        }
        return $this->initiateRequest($pendingPaymentsTXID,$user,$amount,$additionalParam);
    }
    public function verifyTransaction($pendingPaymentID)
    {
        $glob=self::gatewayLockSettings();
        $paytmParams=array();
        $paytmParams["MID"] = $glob['mid'];
        $paytmParams["ORDERID"] = $pendingPaymentID;
        $checksum=$this->getChecksumFromArray($paytmParams,$glob['key']);
        $paytmParams["CHECKSUMHASH"] = $checksum;
        $post_data = json_encode($paytmParams, JSON_UNESCAPED_SLASHES);
        $ch = curl_init($glob['verify_url']);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        return json_decode($response = curl_exec($ch));
    }
}
