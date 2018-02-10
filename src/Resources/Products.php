<?php 

namespace Shiprocket\Resources;

trait Products
{
    /**
     * @return   stdClass               The JSON response from the request
     */
    public function getProducts()
    {
        return $this->request('get', 'products');
    }
    
    public function getProduct($product_id)
    {
        return $this->request('get', 'product/'.$product_id);
    }

    public function createProduct($attributes = [])
    {
        return $this->request('post', 'products', $attributes);
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
