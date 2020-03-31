<?php


namespace gradebook\base;


abstract class Controller
{
	protected $route;
	protected $model;
	protected $view;
	protected $controller;
	protected $prefix;
	protected $layout;
	protected $data = [];
	protected $meta = ['title' => '', 'desc' => '', 'keywords' => ''];

	public function __construct($route)
	{
		$this->route = $route;
		$this->model = $route['controller'];
		$this->view = $route['action'];
		$this->controller = $route['controller'];
		$this->prefix = $route['prefix'];
	}

	public function getView()
	{
		$viewObject = new View($this->route, $this->layout, $this->view, $this->meta);
		$viewObject->render($this->data);
	}

	public function setData($data)
	{
		$this->data = $data;
	}

	public function setMeta($title = "", $desc = "", $keywords = "")
	{
		$this->meta['title'] = $title;
		$this->meta['description'] = $desc;
		$this->meta['keywords'] = $keywords;
	}
}