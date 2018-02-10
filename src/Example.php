<?php

namespace Shiprocket;

$client = new Client([
	'email' 		=> 'rajat.hans@kartrocket.com',
	'password' 		=> '1q2w3e4r5t',
	'use_sandbox'	=> 0
]);

class Example
{
	public function login()
	{
		$client = new Client([
			'email' 		=> 'rajat.hans@kartrocket.com',
			'password' 		=> '1q2w3e4r5t',
			'use_sandbox'	=> 0
		]);

		$client->getHeaders();
	}
}

$example = new Example();
$example->login();