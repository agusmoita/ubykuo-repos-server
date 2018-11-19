<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use App\Util\RepoService\SearchRepoService;
use App\Util\ApiResponse;

class ApiController
{
    public function search(Request $request, SearchRepoService $srs)
    {
    	$q = $request->query->get('q');
    	
        return new ApiResponse($srs->search($q));
    }
}