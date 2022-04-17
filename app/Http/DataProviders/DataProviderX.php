<?php
namespace App\Http\DataProviders;

use App\Http\Interfaces\DataProviders;


class DataProviderX implements DataProviders{

    public function getDataProvider($request){
        return [
            'amount'=>$request['transactionAmount'],
            'currency'=>$request['Currency'],
            'phone'=>$request['senderPhone'],
            'transaction_id'=>$request['transactionIdentification'],
            'status'=>getStatus($request['transactionStatus']),
            'provider'=>'DataProviderX',
        ];
    }
}