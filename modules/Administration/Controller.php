<?php
class AdministrationController extends Controller{
    function access(){
        global $current_user;
        //Есть ли доступ?
        if(!$current_user->is_admin){
            Application::redirect("Users","login");
        }
    }
    function action_index(){
        $this->access();
    }
    function action_editTask(){
        $this->access();
        $this->view = "edittask";
    }
}