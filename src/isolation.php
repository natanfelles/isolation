<?php
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
