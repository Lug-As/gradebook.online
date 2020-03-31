<?php


namespace gradebook\base;


use gradebook\App;

class View
{
	protected $route;
	protected $model;
	protected $view;
	protected $controller;
	protected $prefix;
	protected $layout;
	protected $data = [];
	protected $meta = [];
	protected $scripts;

	public function __construct($route, $layout = "", $view = "", $meta = "")
	{
		$this->route = $route;
		$this->model = $route['controller'];
		$this->view = $route['action'];
		$this->controller = $route['controller'];
		$this->prefix = $route['prefix'];
		$this->meta = $meta;
		if ($layout !== false) {
			$this->layout = $layout ?: LAYOUT;
		} else {
			$this->layout = false;
		}
	}

	public function render($data)
	{
		if ( is_array($data) ) {
			extract($data);
		}
		$viewFile = APP . "/views/{$this->prefix}{$this->controller}/{$this->view}.php";
		if ( file_exists($viewFile) ){
			ob_start();
			require $viewFile;
			$content = ob_get_clean();
			$content = $this->cutScripts($content);
		} else {
			throw new \Exception("Не найден вид {$viewFile}", 500);
		}
		if ($this->layout !== false){
			$layoutFile = APP."/views/layouts/{$this->layout}.php";
			if ( file_exists($layoutFile) ){
				$meta = $this->meta;
				$scripts = $this->scripts;
				require $layoutFile;
			} else {
				throw new \Exception("Не найден шаблон {$layoutFile}", 500);
			}
		}
	}

    protected function cutScripts($content)
    {
        $pattern = '@<script.*?>.*?</script>@si';
        preg_match_all($pattern, $content, $this->scripts);
        if ( !empty($this->scripts) ){
            preg_replace($pattern, '', $content);
        }
        $this->scripts = $this->scripts[0];
        return $content;
	}
}