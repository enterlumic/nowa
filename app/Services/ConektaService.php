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
    public function fnCreateCustomer($customerData)
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
            return ["b_status"=> true, "vc_message" => $order ];
        } catch (Exception $e) {
            return ["b_status"=> false, "vc_message" => $e->getMessage() ];
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

            return $customers;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    // Agregar una fuente de pago a un cliente en Conekta
    public function AddPaymentSource($customerId, $paymentSourceData)
    {
        try {
            // Busca el cliente por ID
            $customer = Customer::find($customerId);

            // Agrega la fuente de pago
            $paymentSource = $customer->createPaymentSource($paymentSourceData);

            return ["b_status" => true, "vc_message" => $paymentSource];
        } catch (Exception $e) {
            return ["b_status" => false, "vc_message" => $e->getMessage()];
        }
    }

    // Obtener las fuentes de pago de un cliente por su ID
    public function getCustomerPaymentSources($customerId)
    {
        try {
            // Busca el cliente por ID
            $customer = Customer::find($customerId);

            // Obtiene las fuentes de pago del cliente
            $paymentSources = $customer->payment_sources;

            return ["b_status" => true, "vc_message" => $paymentSources];
        } catch (Exception $e) {
            return ["b_status" => false, "vc_message" => $e->getMessage()];
        }
    }

}
