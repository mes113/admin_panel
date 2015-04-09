<?php

	/*
	Класс-маршрутизатор для определения запрашиваемой страницы.
	> цепляет классы контроллеров;
	> создает экземпляры контролеров страниц и вызывает действия этих контроллеров.
	*/
	class Route {
		static function start() {
			// контроллер и действие по умолчанию
			$controller_name = 'Index';
			$action_name = 'index';

			$routes = explode('/', $_SERVER['REQUEST_URI']);

			// получаем имя контроллера
			if ( isset($routes[1]) && !empty($routes[1])) {
				$controller_name = $routes[1];
			}

			// получаем имя экшена
			if ( isset($routes[2]) ) {
				$action_name = $routes[2];
			}

			// добавляем префиксы
			$controller_name = 'Controller_'.$controller_name;
			$action_name = 'action_'.$action_name;

			// подцепляем файл с классом контроллера
			$controller_file = strtolower($controller_name).'.php';
			$controller_path = "application/controllers/".$controller_file;
			if(file_exists($controller_path)) {
				include "application/controllers/".$controller_file;
			} else {
				//redirect to 404 page
				Route::ErrorPage404();
			}

			// создаем контроллер
			$controller = new $controller_name;
			$action = $action_name;

			if(method_exists($controller, $action)) {
				// вызываем действие контроллера
				$controller->$action();
			} else {
				//redirect to 404 page
				Route::ErrorPage404();
			}
		}

		function ErrorPage404() {
			$host = 'http://'.$_SERVER['HTTP_HOST'].'/';
			header('HTTP/1.1 404 Not Found');
			header("Status: 404 Not Found");
			header('Location:'.$host.'404');
		}

	}
