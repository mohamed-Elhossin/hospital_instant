<?php

/**
 * Get list of languages
 */

if (!function_exists('getFullName')) {
	function getFullName($user)
	{
		if ($user == null) return '';
		return $user->first_name . ' ' . $user->last_name;
	}
}

/**
 * Upload
 */
if (!function_exists('upload')) {
	function upload($file, $path)
	{
		$baseDir = 'uploads/' . $path;

		$name = sha1(time() . $file->getClientOriginalName());
		$extension = $file->getClientOriginalExtension();
		$fileName = "{$name}.{$extension}";

		$file->move(public_path() . '/' . $baseDir, $fileName);

		return "{$baseDir}/{$fileName}";
	}
}
