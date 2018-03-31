<?php 

namespace Shiprocket\Resources;

trait Orders
{
    /**
     * Get all orders
     *
     * @return void
     */
    public function getOrders()
    {
        return $this->request('get', 'orders');
    }
    
    /**
     * Get order data
     *
     * @param string $order_id Shiprocket Order ID
     * @return void
     */
    public function getOrder($order_id)
    {
        return $this->request('get', 'orders/'.$order_id);
    }

    /**
     * Create a quick order
     *
     * @param array $attributes Order data
     * @return void
     */
    public function createQuickOrder($attributes = [])
    {
        return $this->request('post', 'orders/create/adhoc', $attributes);
    }

    /**
     * Create a linked order
     *
     * @param array $attributes Order data
     * @return void
     */
    public function createLinkedOrder($attributes = [])
    {
        return $this->request('post', 'orders/create', $attributes);
    }

    /**
     * Makes a request to the Shiprocket API and returns the response.
     *
     * @param    string $verb       The Http verb to use
     * @param    string $path       The path of the APi after the domain
     * @param    array  $parameters Parameters
     *
     * @return   stdClass The JSON response from the request
     * @throws   Exception
     */
    abstract protected function request($verb, $path, $parameters = []);
}
