<?php

use Threesquared\LaravelPaymill\Paymill;

class FactoryTest extends PHPUnit_Framework_TestCase {

    public function setUp()
    {
        $this->paymill = new Paymill('priv-key');
    }

    public function testCanCreateRequestHandler()
    {
        $request = $this->paymill->request;
        $this->assertInstanceOf('Paymill\Request', $request);
    }

    public function testCanCreateModel()
    {
        $payment = $this->paymill->payment();
        $this->assertInstanceOf('Paymill\Models\Request\Payment', $payment->model);
    }

    public function testCanSetId()
    {
        $transaction = $this->paymill->transaction(1);
        $this->assertEquals(1, $transaction->model->getId());
    }

    public function testCanExecuteMagicMethods()
    {
        $client = $this->paymill->client(1);
        $this->assertEquals(1, $client->getId());
    }
}
