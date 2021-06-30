<?php
class UsersController extends Controller{
    function action_login(){
        $this->view = "Login";
    }
    function action_auth(){
        global $notifications,$db;
        $login = null;
        $password = null;
        
        if(is_array($_POST) && array_key_exists("login",$_POST)){
            $login = trim(strip_tags($_POST["login"]));
        }
        if(is_array($_POST) && array_key_exists("password",$_POST)){
            $password = (trim(strip_tags($_POST["password"])));
        }
        if(empty($login) || empty($password)){
            $notifications->add("warn","Укажите логин и пароль");
            Application::redirect("Users","login");
        }

        $password = md5($password);

        //Пробуем авторизироваться
        $id = $db->query("SELECT t.id FROM users t WHERE t.login='{$login}' AND t.password='{$password}' LIMIT 1");
        if($id && $id->num_rows > 0){
            $id = intval(array_shift($id->fetch_array()));

            $current_user = new User();
            $current_user->retrieve($id);
            
            if(!session_id()){
                session_start();
            }
            $_SESSION["user"] = $id;

            if($current_user->is_admin == '1'){
                Application::redirect("Administration","index");
            }else{
                $notifications->add("success","{$current_user->name}, вы успешно вошли в систему!");
                Application::redirect("Tasks","index");
            }
        }
        
        $notifications->add("warn","Укажите правильный логин или пароль");
        Application::redirect("Users","login");
    }
}