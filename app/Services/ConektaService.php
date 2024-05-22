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
        // Obtenemos las llaves que se encuentra en .ENV
        Conekta::setApiKey(env('CONEKTA_PRIVATE_KEY'));
        Conekta::setApiVersion(env('CONEKTA_API_VERSION'));
    }

    // Crear un Cliente en conekta esto es importante cuando no es un pago unico
    public function createCustomer($customerData)
    {
        try {
            $customer = Customer::create($customerData);
            return $customer;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    // Crear una orden en CONEKTA
    public function createOrder($orderData)
    {
        try {
            $order = Order::create($orderData);
            return $order;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    // Eliminar cliente en CONEKTA
    public function deleteCustomer($customerId)
    {
        try {
            // Busca el cliente por ID
            $customer = Customer::find($customerId);

            // Elimina el cliente
            $customer->delete();

            return response()->json(['message' => 'Cliente eliminado con éxito.'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

   // Función para obtener la lista de clientes en CONEKTA
    public function getCustomers()
    {
        try {
            // Obtiene la lista de clientes desde Conekta
            $customers = Customer::where([]);

            return response()->json(['customers' => $customers], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
