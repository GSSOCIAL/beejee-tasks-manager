<?php
class DetailView extends View{
    public $template = "include/MVC/View/templates/detailview.tpl";
    
    public function pre_display(){
        parent::pre_display();
        $panels = array();
        if(array_key_exists("panels",$this->metadata)){
            foreach($this->metadata as $rows){
                $row = array();
                foreach($rows as $cells){
                    foreach($cells as $cell){
                        if(is_string($cell)){
                            if(array_key_exists($cell,$this->focus->defs)){
                                $defs = $this->focus->defs[$cell];
                                if(array_key_exists("type",$defs)){
                                    $defs["value"] = $this->focus->{$cell};
                                    $field = Field::getField($defs["type"],$defs);
                                    if($field instanceof Field){
                                        //Настраиваем отображение поля
                                        $row[]=array(
                                            "name"=>$cell,
                                            "type"=>$field->type,
                                            "label"=>$field->label,
                                            "defs"=>$defs,
                                        );
                                    }
                                }
                            }
                        }
                    }
                }
                $panels[] = $row;
            }
        }
        $this->s->assign("panels",$panels);

        $actions = array();
        if(empty($actions)){
            $actions[] = "SAVE";
        }
        $this->s->assign("actions",$actions);
        $this->s->assign("title","Просмотр задачи");
        $this->s->assign("module",$this->module);
        $this->s->assign("focus",$this->focus);
        return $this;
    }
}