<?php
    session_start();
    if ( $_SESSION['login'] != "true" ) {
        session_destroy();
        redirect('login');
    }
    class Controller_Workers extends Controller {

        function action_index() {
            $this->view->load('common/header_view');
            $this->view->load('common/menu_view');
            $this->view->load('workers_view');
            $this->view->load('common/footer_view');
        }

        function action_create() {
            $this->view->load('common/header_view');
            $this->view->load('common/menu_view');
            $this->view->load('create_worker_view');
            $this->view->load('common/footer_view');
        }

        function action_new_user() {
            if(isset($_POST)) {
                User::create_user(  
                    $_POST['first_name'], 
                    $_POST['last_name'], 
                    $_POST['birthday'], 
                    $_POST['phone'], 
                    $_POST['email'], 
                    $_POST['password']
                ); 
                redirect('workers');
            }
        }
        
    }
