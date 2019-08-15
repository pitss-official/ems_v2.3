<?php

namespace App\Http\Controllers;

use App\OnlinePayment;
use Illuminate\Http\Request;
use App\System;

class OnlinePaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
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
        <?php
/**
* import checksum generation utility
* You can get this utility from https://developer.paytm.com/docs/checksum/
*/
require_once("encdec_paytm.php");
/* initialize an array with request parameters */
$paytmParams = array(

	/* Find your MID in your Paytm Dashboard at https://dashboard.paytm.com/next/apikeys */
	"MID" => System::getPropertyValueByName('config_paytm_mid'),

	/* Find your WEBSITE in your Paytm Dashboard at https://dashboard.paytm.com/next/apikeys */
	"WEBSITE" => "YOUR_WEBSITE_HERE",

	/* Find your INDUSTRY_TYPE_ID in your Paytm Dashboard at https://dashboard.paytm.com/next/apikeys */
	"INDUSTRY_TYPE_ID" => "YOUR_INDUSTRY_TYPE_ID_HERE",

	/* WEB for website and WAP for Mobile-websites or App */
	"CHANNEL_ID" => "YOUR_CHANNEL_ID",

	/* Enter your unique order id */
	"ORDER_ID" => "YOUR_ORDER_ID",

	/* unique id that belongs to your customer */
	"CUST_ID" => "CUSTOMER_ID",

	/* customer's mobile number */
	"MOBILE_NO" => "CUSTOMER_MOBILE_NUMBER",

	/* customer's email */
	"EMAIL" => "CUSTOMER_EMAIL",

	/**
	* Amount in INR that is payble by customer
	* this should be numeric with optionally having two decimal points
	*/
	"TXN_AMOUNT" => "ORDER_TRANSACTION_AMOUNT",

	/* on completion of transaction, we will send you the response on this URL */
	"CALLBACK_URL" => "YOUR_CALLBACK_URL",
);

/**
* Generate checksum for parameters we have
* Find your Merchant Key in your Paytm Dashboard at https://dashboard.paytm.com/next/apikeys
*/
$checksum = getChecksumFromArray($paytmParams, "YOUR_KEY_HERE");

/* for Staging */
$url = "https://securegw-stage.paytm.in/order/process";

/* for Production */
// $url = "https://securegw.paytm.in/order/process";


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
     * @param  \App\OnlinePayment  $onlinePayment
     * @return \Illuminate\Http\Response
     */
    public function show(OnlinePayment $onlinePayment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\OnlinePayment  $onlinePayment
     * @return \Illuminate\Http\Response
     */
    public function edit(OnlinePayment $onlinePayment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\OnlinePayment  $onlinePayment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, OnlinePayment $onlinePayment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\OnlinePayment  $onlinePayment
     * @return \Illuminate\Http\Response
     */
    public function destroy(OnlinePayment $onlinePayment)
    {
        //
    }
}
