<?php

require_once __DIR__ . '/vendor/autoload.php';

use Shiprocket\Client;

class Example
{
	public function logind()
	{
		$client = new Client([
			'email' 		=> 'rajat.hans@kartrocket.com',
			'password' 		=> '1q2w3e4r5t',
			'use_sandbox'	=> 0
		]);

		$client->getConfiguration();
	}
}

$example = new Example();
$example->logind();