<?php

namespace App\Util\RepoService;

/**
 * SearchRepoService
 */
class SearchRepoService implements RepoServiceInterface
{
	function __construct(GitHubService $github, LocalRepoService $local)
	{
		$this->github = $github;
		$this->local = $local;
	}

	public function search(string $q): array
	{
		return [
			'local' => $this->local->search($q),
			'github' => $this->github->search($q)
		];
	}
}