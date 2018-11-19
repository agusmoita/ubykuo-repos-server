<?php

namespace App\Util;

/**
 * GraphQLClient
 */
class GraphQLClient
{
	
	private $endpoint;

	public function __construct(string $endpoint)
	{
		$this->endpoint = $endpoint;
	}

	public function query(string $query, array $variables = [], string $token = null, string $method = "POST"): string
	{
		$headers = [
			'Content-Type: application/json', 
			'User-Agent: GraphQLClient'
		];

		if ($token) $headers[] = "Authorization: bearer $token";

	    $response = @file_get_contents($this->endpoint, false, stream_context_create([
			'http' => [
				'method' => $method,
				'header' => $headers,
				'content' => json_encode([
					'query' => $query, 
					'variables' => $variables
				]),
			]
		]));

		return $response;
	}
}