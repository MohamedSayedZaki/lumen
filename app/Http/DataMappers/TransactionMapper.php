<?php
namespace App\Http\DataMappers;

use App\Http\DataProviders\DataProviderW;
use App\Http\DataProviders\DataProviderX;
use App\Http\DataProviders\DataProviderY;

class TransactionMapper{

    public function getDataProvider($request,$type){
        $data =[];
        switch ($type) {
            case 'W':
                $data=(new DataProviderW())->getDataProvider($request);
                break;
            case 'X':
                $data=(new DataProviderX())->getDataProvider($request);
                break;                
            case 'Y':
                $data=(new DataProviderY())->getDataProvider($request);
                break; 
        }
        return $data;
    }
}