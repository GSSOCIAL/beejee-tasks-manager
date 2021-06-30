<?php
class AdministrationIndexView extends View{
    public $template = "modules/Administration/views/templates/indexview.tpl";
    
    public function pre_display(){
        global $db,$app_strings;

        $focus = new Task();

        $list = array();
        $query = $db->query("SELECT t.id,t.name,t.description,t.status FROM tasks t WHERE 1");
        if($query){
            while($row=$query->fetch_assoc()){
                $row["description"] = mb_substr($row["description"],0,100);
                $row["status"] = $app_strings["tasks_status"][$row["status"]];
                $list[]=$row;
            }
        }

        $this->s->assign("list",$list);
        return $this;
    }
}