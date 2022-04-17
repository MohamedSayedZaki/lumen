<?php

use Laravel\Lumen\Testing\DatabaseMigrations;

class TransactionTest extends TestCase
{
    /**
     * @return void
     */
    public function test_Check_If_Transactions_Not_Exist_Then_Create_Them()
    {
        $results = $this->json('POST', '/api/v1/transactions');
        if(json_decode($results->response->getContent())->status =='200')
            $this->assertNotEquals('201',json_decode($results->response->getContent())->status);
        if(json_decode($results->response->getContent())->status =='201')
            $this->assertEquals('201',json_decode($results->response->getContent())->status);            
    }

    /**
     * @return void
     */
    public function test_Check_Transactions_If_Exist()
    {
        $results = $this->json('POST', '/api/v1/transactions');
        $this->assertEquals('200',json_decode($results->response->getContent())->status);
    }
    
    /**
     * @return void
     */
    public function test_get_all_transactions()
    {
        $results = $this->json('GET', '/api/v1/transactions');
        $this->assertEquals('200',json_decode($results->response->getContent())->status);
    }
    
    /**
     * @return void
     */
    public function test_get_all_transactions_by_provider()
    {
        $results = $this->json('GET', '/api/v1/transactions?provider=DataProviderX');
        $this->assertEquals('DataProviderX',json_decode($results->response->getContent())->transactions[0]->provider);
    }
    
    /**
     * @return void
     */
    public function test_get_all_transactions_by_status_code()
    {
        $results = $this->json('GET', '/api/v1/transactions?statusCode=paid');
        $this->assertEquals('paid',json_decode($results->response->getContent())->transactions[0]->status);
    }  
    
    /**
     * @return void
     */
    public function test_get_all_transactions_by_currency()
    {
        $results = $this->json('GET', '/api/v1/transactions?currency=EGP');
        $this->assertEquals('EGP',json_decode($results->response->getContent())->transactions[0]->currency);
    }      

    /**
     * @return void
     */
    public function test_get_all_transactions_by_amount()
    {
        $results = $this->json('GET', '/api/v1/transactions?amounteMin=10&amounteMax=300');
        $this->assertEquals('200',json_decode($results->response->getContent())->transactions[0]->amount);
    }          

    /**
     * @return void
     */
    public function test_get_all_transactions_by_provider_and_status_code_and_currency_and_amount()
    {
        $results = $this->json('GET', '/api/v1/transactions?provider=DataProviderX&statusCode=paid&currency=USD&amounteMin=10&amounteMax=300');
        $this->assertEquals('1',json_decode($results->response->getContent())->transactions[0]->id);
    }              
}
