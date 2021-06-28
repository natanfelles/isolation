<?php
/*
 * This file is part of The Framework Isolation Library.
 *
 * (c) Natan Felles <natanfelles@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Tests\Isolation;

use Framework\Isolation\Isolation;

class TestClass
{
	protected string $filename;

	public function __construct(string $filename)
	{
		$this->filename = $filename;
	}

	public function test() : string
	{
		return 'test';
	}

	public function requireNonIsolated() : mixed
	{
		return require $this->filename;
	}

	public function requireIsolated() : mixed
	{
		return Isolation::require($this->filename);
	}
}
