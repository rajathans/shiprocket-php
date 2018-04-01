<?php

require_once __DIR__ . '/vendor/autoload.php';

use Shiprocket\Client as ShiprocketClient;

class Example
{
	public function login()
	{
		$client = new ShiprocketClient([
			'email' 		=> '',
			'password' 		=> '',
			'use_sandbox'	=> 0
		]);

		$couriers = $client->checkServiceability('110070', '110030');
		var_dump($couriers);

		// $client->getToken();
		// var_dump($client->token);
	}
}

$example = new Example();
$example->login();