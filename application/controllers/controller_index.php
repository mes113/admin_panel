<?php
	session_cheker();
	class Controller_Index extends Controller{
		function action_index() {
			$this->view->load('common/header_view');
			$this->view->load('common/menu_view');
			$this->view->load('index_view');
			$this->view->load('common/footer_view');
		}
	}