<?php namespace Tests\Isolation;

use PHPUnit\Framework\TestCase;

class IsolationTest extends TestCase
{
	protected string $dir = __DIR__ . '/files/';

	public function testNoReturn() : void
	{
		self::assertSame(1, requireIsolated($this->dir . 'noreturn.php'));
	}

	public function testReturnVar() : void
	{
		self::assertSame(
			18,
			requireIsolated($this->dir . 'return-var.php', ['var' => 18])
		);
	}

	public function testReturnData() : void
	{
		self::assertSame([], requireIsolated($this->dir . 'return-data.php'));
		self::assertSame(
			['foo', 'bar'],
			requireIsolated($this->dir . 'return-data.php', ['foo', 'bar'])
		);
	}

	public function testReturnDataOverwrite() : void
	{
		$data = ['var' => 'foo', 'data' => 'baz'];
		self::assertEquals(
			'baz',
			requireIsolated($this->dir . 'return-data.php', $data)
		);
		self::assertEquals(
			'foo',
			requireIsolated($this->dir . 'return-var.php', $data)
		);
	}
}
