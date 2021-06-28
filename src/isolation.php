<?php
/*
 * This file is part of The Framework Isolation Library.
 *
 * (c) Natan Felles <natanfelles@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
/**
 * Requires a file in a isolated scope.
 *
 * Prevents access to $this/self from required files.
 *
 * @param string $filename The file to be required
 * @param array<int|string,mixed> $data [optional] Data to be extracted as variables
 * present for the required file
 *
 * @return mixed The return of the require
 */
function require_isolated(string $filename, array $data = []) : mixed
{
	if ($data) {
		extract($data, \EXTR_OVERWRITE);
	}
	return require $filename;
}
