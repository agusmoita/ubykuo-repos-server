<?php

namespace App\Util;

use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * ApiResponse
 */
class ApiResponse extends JsonResponse
{
	public function __construct($data)
    {
        parent::__construct(
        	$data, 
        	200, 
        	['Access-Control-Allow-Origin' => '*']
        );
    }
}