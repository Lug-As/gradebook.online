<?php


namespace gradebook;


class ErrorHandler
{
	public function __construct()
	{
		if (DEBUG){
			error_reporting(-1);
		} else {
			error_reporting(0);
		}
		set_exception_handler([$this, "exceptionHandler"]);
	}

	public function exceptionHandler($e)
	{
		$this->logErrors($e->getMessage(), $e->getFile(), $e->getLine());
		$this->displayErrors("Исключение", $e->getMessage(), $e->getFile(), $e->getLine(), $e->getCode());
	}

	protected function logErrors($message = "", $file = "", $line = "")
	{
		$text = "[". date("Y-m-d H:i:s") ."]\n    Текст ошибки: {$message} | Файл: {$file} | Строка: {$line}\n=====================\n";
		error_log($text, 3, ROOT . "/tmp/errors.log");
	}

	protected function displayErrors($errno, $errstr, $errfile, $errline, $response = 404)
	{
		http_response_code($response);
		if (DEBUG) {
			require WWW . "/errors/dev/index.php";
		} else {
			require WWW . "/errors/prod/index.php";
		}
		die;
	}
}