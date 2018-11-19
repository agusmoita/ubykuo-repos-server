<?php

namespace App\Util\RepoService;

use App\Util\GraphQLClient;

/**
 * GitHubService
 */
class GitHubService implements RepoServiceInterface
{
	const ENDPOINT = 'https://api.github.com/graphql';
	const TOKEN = '11eb8db6bf7f7784fc4e0f53c5bc5f7e6342ead5';

	public function search(string $q): array
	{
		$query = '
			query SearchRepositories($q: String!) { 
				search(query: $q, type: REPOSITORY, first: 20 ) {
					edges {
						node {
							... on Repository {
								id,
								name,
								nameWithOwner,
								description,
								url
							}
						}
					}
				}
			} 
		';

		$variables = ['q' => $q];

		$graphql = new GraphQLClient(self::ENDPOINT);

		$response = $graphql->query($query, $variables, self::TOKEN);

	    return $this->toJson($response);
	}

	private function toJson($response): array
	{
		return array_map(function ($edge) {
			$repo = $edge->node;
			return [
				'id' => $repo->id,
				'name' => $repo->name,
				'full_name' => $repo->nameWithOwner,
				'description' => $repo->description,
				'url' => $repo->url
			];
		}, json_decode($response)->data->search->edges);
	}
}