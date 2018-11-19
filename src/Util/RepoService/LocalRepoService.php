<?php

namespace App\Util\RepoService;

use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Finder\Finder;

/**
 * LocalRepoService
 */
class LocalRepoService implements RepoServiceInterface
{
	private $kernel;

	public function __construct(KernelInterface $kernel)
	{
		$this->kernel = $kernel;
	}

	public function search(string $q): array
	{
		$finder = new Finder();
		
		return $this->toJson(
			$finder
				->directories()
				->in($this->kernel->getProjectDir().'/../')
				->ignoreVCS(false)
				->ignoreDotFiles(false)
				->depth('1')
				->filter(function (\SplFileInfo $dir) use ($q) {
					return $this->isValidDirectory($dir, $q);
				})
				->getIterator()
		);
	}

	private function toJson($directories): array
	{
		$repositories = [];
		foreach ($directories as $dir) {
			$repositories[] = [
				'name' => $this->getProjectName($dir)
			];
		}

		return $repositories;
	}

	private function isValidDirectory(\SplFileInfo $directory, string $q): bool
	{
		return $this->containsFolder($directory, $q) && $this->isGit($directory);
	}

	private function containsFolder(\SplFileInfo $directory, string $q): bool
	{
		return strpos(
			strtolower($directory->getRelativePathname()), 
			strtolower($q)
		) !== FALSE;
	}

	private function isGit(\SplFileInfo $directory): bool
	{
		return $this->containsFolder($directory, '.git');
	}

	private function getProjectName(\SplFileInfo $directory): string
	{
		return current(explode('/', $directory->getRelativePathname()));
	}

}