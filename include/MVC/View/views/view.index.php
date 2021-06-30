<?php
class IndexView extends View{
    public $template = "include/MVC/View/templates/listview.tpl";
    
    public function pre_display(){
        global $db;
        parent::pre_display();
        $columns = array();

        $limit = 3;
        $order_by = "id";
        $page = 1;

        $total_items_query = $db->query("SELECT COUNT(t.id) AS `n` FROM {$this->focus->table} t WHERE 1");
        $total = intval(array_shift($total_items_query->fetch_array()));

        $pages = ceil($total / $limit);

        if(array_key_exists("page",$_REQUEST) && intval($_REQUEST["page"]) <= $pages){
            $page = intval($_REQUEST["page"]);
        }

        if(is_array($this->metadata) && array_key_exists("columns",$this->metadata)){
            foreach($this->metadata["columns"] as $col_name){
                $columns[]=$col_name;
                if(array_key_exists("order_by",$_REQUEST) && $_REQUEST["order_by"]==$col_name){
                    $order_by = $_REQUEST["order_by"];
                }
            }
        }
        if(!in_array("id",$columns)){
            $columns[] = "id";
        }
        $columns_str = implode(",",array_map(function($item){
            return "t.{$item}";
        },$columns));

        $skip = ($page - 1) * 3;
        $query = $db->query("SELECT {$columns_str} FROM {$this->focus->table} t WHERE 1 ORDER BY t.{$order_by} DESC LIMIT {$skip},{$limit}");
        
        if($query){
            $data = array();
            while($row = $query->fetch_assoc()){
                $data[]=$row;
            }
            $this->s->assign("list",$data);
        }

        $focus = $this->focus;
        $this->s->assign("columns",array_map(function($item) use ($focus){
            if(array_key_exists($item,$focus->defs)){
                return $focus->defs[$item]["label"];
            }
        },$columns));

        $this->s->assign("total",$total);
        $this->s->assign("limit",$limit);
        $this->s->assign("page",$page);
        $this->s->assign("pages",$pages);
        $this->s->assign("order_by",$order_by);
        $this->s->assign("module",$this->module);
    }
}