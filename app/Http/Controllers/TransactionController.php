<?php
 
namespace App\Http\Controllers;
 
use App\Transaction;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use App\Http\DataMappers\TransactionMapper;
 
class TransactionController extends Controller{

  private $dataMapper;
  
  public function __construct(TransactionMapper $mapper){
    $this->dataMapper = $mapper;
  }

  /**
   * @param Request $request
   * @return JsonResponse $transaction
  */
  public function createTransaction(Request $request):JsonResponse
  {
    $transactions =[];
    $files=['W','X','Y'];
    foreach($files as $key => $file){
        $path = storage_path() . "/DataProviders/DataProvider${file}.json"; 
        $requestData = json_decode(file_get_contents($path), true); 
        $mappedRequestData = $this->dataMapper->getDataProvider($requestData,$file);
        
        #check if transaction exists or not
        $transaction = Transaction::where('transaction_id',$mappedRequestData['transaction_id'])->get();
        
        if(!empty($transaction) && count($transaction) >0){
          continue;
        }else{
          #create the transaction
          $transactions[] = Transaction::create($mappedRequestData);
        }
    }
    if(empty($transactions)){
      #transactions have been found before
      return response()->json(["status"=>"200"]); 
    }
    return response()->json(["status"=>"201","transactions"=>$transactions]);    
  
  }
 
  public function index(Request $request){
    $provider = $request->query('provider');
    $statusCode = $request->query('statusCode');
    $currency = $request->query('currency');
    $amounteMin = $request->query('amounteMin');
    $amounteMax = $request->query('amounteMax');

    #filter with inputs 
    $QueryBuilder  = Transaction::where('provider','=',$provider);
    if($statusCode) $QueryBuilder->orWhere('status','=',$statusCode);
    if($currency) $QueryBuilder->orWhere('currency','=',$currency);
    if($amounteMin && $amounteMax) $QueryBuilder->orWhereBetween('amount', [$amounteMin, $amounteMax]);
    $transactions = $QueryBuilder->get();

    return response()->json(["status"=>"200","transactions"=>$transactions]);
  }
}
?>