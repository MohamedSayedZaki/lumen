<?php
namespace App\Http\DataProviders;

use App\Http\Interfaces\DataProviders;


class DataProviderY implements DataProviders{

    public function getDataProvider($request){
        return [
            'amount'=>$request['amount'],
            'currency'=>$request['currency'],
            'phone'=>$request['phone'],
            'transaction_id'=>$request['id'],
            'status'=>getStatus($request['status']),
            'provider'=>'DataProviderY',
        ];
    }
}