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
use PHPUnit\Framework\TestCase;

class IsolationTest extends TestCase
{
	protected string $dir = __DIR__ . '/files/';

	public function testNoReturn() : void
	{
		self::assertSame(1, Isolation::require($this->dir . 'noreturn.php'));
	}

	public function testReturnVar() : void
	{
		self::assertSame(
			18,
			Isolation::require($this->dir . 'return-var.php', ['var' => 18])
		);
	}

	public function testReturnData() : void
	{
		self::assertSame([], Isolation::require($this->dir . 'return-data.php'));
		self::assertSame(
			['foo', 'bar'],
			Isolation::require($this->dir . 'return-data.php', ['foo', 'bar'])
		);
	}

	public function testReturnDataOverwrite() : void
	{
		$data = ['var' => 'foo', 'data' => 'baz'];
		self::assertEquals(
			'baz',
			Isolation::require($this->dir . 'return-data.php', $data)
		);
		self::assertEquals(
			'foo',
			Isolation::require($this->dir . 'return-var.php', $data)
		);
	}

	public function testRequireIntoClassWithThis() : void
	{
		$class = new TestClass(__DIR__ . '/files/into-class-this.php');
		self::assertSame('test-this', $class->requireNonIsolated());
		$this->expectException(\Error::class);
		$this->expectExceptionMessage('Using $this when not in object context');
		$class->requireIsolated();
	}

	public function testRequireIntoClassWithSelf() : void
	{
		$class = new TestClass(__DIR__ . '/files/into-class-self.php');
		//$this->expectException(\Error::class);
		//$this->expectExceptionMessage('Using $this when not in object context');
		//$class->requireIsolated();
		// TODO: Could not return 1, must thrown an Error
		self::assertSame(1, $class->requireIsolated());
	}
}
