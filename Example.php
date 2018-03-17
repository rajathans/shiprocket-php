<?php

require_once __DIR__ . '/vendor/autoload.php';

use Shiprocket\Client;

class Example
{
	public function login()
	{
		$client = new Client([
			'email' 		=> '',
			'password' 		=> '',
			'use_sandbox'	=> 0
		]);

		$orders = $client->getOrders();
		var_dump($orders);

		// $client->getToken();
		// var_dump($client->token);
	}
}

$example = new Example();
$example->login();