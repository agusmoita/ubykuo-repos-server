<?php

namespace App\Util\RepoService;

/**
 * RepoServiceInterface
 */
interface RepoServiceInterface
{
	public function search(string $q): array;
}