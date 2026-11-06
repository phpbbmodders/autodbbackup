<?php
/**
 *
 * Auto Database Backup
 *
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace pico\autodbbackup;

class backup_directory
{
	/**
	 * Check that the configured destination is a canonical private directory.
	 */
	public static function is_valid(string $path, string $board_root, string $document_root): bool
	{
		if ($path === '' || $path[0] !== '/' || preg_match('/[\x00-\x1f\x7f]/', $path)
			|| realpath($path) !== $path || !is_dir($path) || !is_readable($path) || !is_writable($path))
		{
			return false;
		}

		$permissions = @fileperms($path);
		if ($permissions === false || ($permissions & 0007) !== 0)
		{
			return false;
		}

		foreach ([$board_root, $document_root] as $root)
		{
			$root = $root === '' ? false : realpath($root);
			if ($root !== false && str_starts_with($path . '/', rtrim($root, '/') . '/'))
			{
				return false;
			}
		}

		return $path !== '/';
	}

	/**
	 * Copy a finished archive and publish it only after the complete copy.
	 */
	public static function publish(string $source, string $directory, string $filename): bool
	{
		$temporary = @tempnam($directory, '.autodbbackup-');
		if ($temporary === false)
		{
			return false;
		}

		try
		{
			if (dirname($temporary) !== $directory)
			{
				return false;
			}

			$input = @fopen($source, 'rb');
			if ($input === false)
			{
				return false;
			}

			try
			{
				$output = @fopen($temporary, 'wb');
				if ($output === false)
				{
					return false;
				}

				$size = fstat($input);
				$bytes = @stream_copy_to_stream($input, $output);
				$closed = @fclose($output);
				if (!$closed || $size === false || $bytes !== $size['size'] || $bytes === 0)
				{
					return false;
				}
			}
			finally
			{
				fclose($input);
			}

			$destination = $directory . '/' . $filename;
			return !file_exists($destination) && !is_link($destination) && @rename($temporary, $destination);
		}
		finally
		{
			if (is_file($temporary))
			{
				@unlink($temporary);
			}
		}
	}
}
