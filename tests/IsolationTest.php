<?php namespace Tests\Isolation;

use PHPUnit\Framework\TestCase;

class IsolationTest extends TestCase
{
	protected string $dir = __DIR__ . '/files/';

	public function testNoReturn() : void
	{
		self::assertSame(1, require_isolated($this->dir . 'noreturn.php'));
	}

	public function testReturnVar() : void
	{
		self::assertSame(
			18,
			require_isolated($this->dir . 'return-var.php', ['var' => 18])
		);
	}

	public function testReturnData() : void
	{
		self::assertSame([], require_isolated($this->dir . 'return-data.php'));
		self::assertSame(
			['foo', 'bar'],
			require_isolated($this->dir . 'return-data.php', ['foo', 'bar'])
		);
	}

	public function testReturnDataOverwrite() : void
	{
		$data = ['var' => 'foo', 'data' => 'baz'];
		self::assertEquals(
			'baz',
			require_isolated($this->dir . 'return-data.php', $data)
		);
		self::assertEquals(
			'foo',
			require_isolated($this->dir . 'return-var.php', $data)
		);
	}

	public function testIsolationIntoClass() : void
	{
		$class = new class() {
			protected string $filename = __DIR__ . '/files/into-class.php';

			public function test() : string
			{
				return 'test';
			}

			public function nonIsolated() : mixed
			{
				return require $this->filename;
			}

			public function isolated() : mixed
			{
				return require_isolated($this->filename);
			}
		};
		self::assertSame('test', $class->nonIsolated());
		$this->expectException(\Error::class);
		$this->expectExceptionMessage('Using $this when not in object context');
		$class->isolated();
	}
}
