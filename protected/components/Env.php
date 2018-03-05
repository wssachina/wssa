<?php

class Env {
	const PREFIX = 'WSSA_';

	private static $envs;

	public static function get($name) {
		$key = self::PREFIX . $name;
		$envs = self::getEnvs();
		return isset($_SERVER[$key]) ? $_SERVER[$key] : (isset($envs[$key]) ? $envs[$key] : '');
	}

	public static function getEnvs() {
		if (self::$envs === null) {
			self::$envs = [];
			$envFile = CONFIG_PATH . '/env.php';
			if (file_exists($envFile)) {
				self::$envs = require $envFile;
			}
		}
		return self::$envs;
	}
}
