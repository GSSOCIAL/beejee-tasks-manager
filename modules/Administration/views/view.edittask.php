<?php
class AdministrationEdittaskView extends View{
    public $template = "modules/Administration/views/templates/edittaskview.tpl";
    
    public function pre_display(){
        $focus = new Task();
        if(array_key_exists("id",$_REQUEST)){
            $focus->retrieve($_REQUEST["id"]);
        }else{
            Application::redirect("Administration","index");
        }
        $this->s->assign("focus",$focus);
        return $this;
    }
}