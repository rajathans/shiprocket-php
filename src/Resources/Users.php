<?php 

namespace Shiprocket\Resources;

trait Products
{
    public function login()
    {
        return $this->request('post', 'auth/login');
    }
    
    public function getUser($user_id)
    {
        return $this->request('get', 'users/'.$product_id);
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
