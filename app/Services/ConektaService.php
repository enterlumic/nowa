<?php

namespace App\Services;

use Conekta\Conekta;
use Conekta\Order;
use Conekta\Customer;
use Conekta\Handler;
use Exception;

class ConektaService
{
    public function __construct()
    {
        Conekta::setApiKey(env('CONEKTA_PRIVATE_KEY'));
        Conekta::setApiVersion(env('CONEKTA_API_VERSION'));
    }

    public function createCustomer($customerData)
    {
        try {
            $customer = Customer::create($customerData);
            return $customer;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function createOrder($orderData)
    {
        try {
            $order = Order::create($orderData);
            return $order;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}
