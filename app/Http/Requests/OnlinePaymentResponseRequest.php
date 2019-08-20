<?php

namespace App\Http\Requests;

use App\OnlinePayment;
use App\System;
use Illuminate\Foundation\Http\FormRequest;

class OnlinePaymentResponseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'MID' => 'bail|required|string|max:20',
            'TXNID' => 'bail|required|string|max:64|unique:online_payments,id',
            'ORDERID' => 'bail|required|string|max:50|exists:pending_payments,id',
            'BANKTXNID' => 'bail|string|nullable',
            'TXNAMOUNT' => 'bail|required|string|max:10',
            'CURRENCY' => 'bail|required|string|max:3',
            'STATUS' => 'bail|required|string|max:20',
            'RESPCODE' => 'bail|required|string|max:10',
            'RESPMSG' => 'bail|required|string|max:500',
            'TXNDATE' => 'bail|required',
            'GATEWAYNAME' => 'bail|required|string|max:15',
            'BANKNAME' => 'bail|nullable|string|max:500',
            'PAYMENTMODE' => 'bail|required|string|max:15',
            'CHECKSUMHASH' => 'bail|required|string|max:108',
            'BIN_NUMBER' => 'bail|nullable|string|max:6',
            'CARD_LAST_NUMS' => 'bail|nullable|string|max:4',
        ];
    }
    public function validatedAndSanitized(array $skippedKeys=[])
    {
        return System::sanitize($this->validated(),$skippedKeys);
    }
    public function validateCheckSum()
    {
        $validatedData=$this->validatedAndSanitized();
        $paytmChecksum = "";
        $paytmParams = [];
        foreach($validatedData as $key => $value){
            if($key == "CHECKSUMHASH"){
                $paytmChecksum = $value;
            } else {
                $paytmParams[$key] = $value;
            }
        }
        $op=new OnlinePayment();
        $isValidChecksum = $op->verifychecksum_e($paytmParams, $op->gatewayLockSettings()['key'], $paytmChecksum);
        if($isValidChecksum == "TRUE")return true;
        else return false;
    }

    /**
     * checksum is also checked
     * @return bool
     */
    public function isApproved()
    {
        $validatedData=$this->validatedAndSanitized();
        if($this->validateCheckSum()&&$validatedData['STATUS']=="TXN_SUCCESS"&&$validatedData['RESPCODE']=="01")
            return true;
        else return false;
    }

    public function validateTransaction($pendingPaymentID)
    {
        $validatedData=$this->validatedAndSanitized();
        $op=new OnlinePayment();
        $response=(array)$op->verifyTransaction($pendingPaymentID);
        $matchKeys=array_intersect(array_keys($validatedData),array_keys($response));
        $count=0;
        foreach ($matchKeys as $key) if($response[$key]==$validatedData[$key]) $count++;
        if($count==count($matchKeys)&&$this->isApproved()) return true;
        else return false;
    }
}
