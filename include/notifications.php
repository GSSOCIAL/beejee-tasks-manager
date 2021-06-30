<?php
class Notifications implements \Iterator{
    protected $notification_types = array(
        "info","warn","success","error","note"
    );
    public $notifications = array();

    public function key(){
        return key($this->notifications);
    }
    public function count(){
        return count($this->notifications);
    }
    public function empty(){
        return empty($this->notifications);
    }
    public function current(){
        return current($this->notifications);
    }
    public function next(){
        return next($this->notifications);
    }
    public function rewind(){
        return reset($this->notifications);
    }
    public function valid(){
        $key = $this->key();
        return $key !== NULL && $key !== false;
    }
    public function first(){
        if(!empty($this->notifications)){
            reset($this->notifications);
            return $this->notifications[key($this->notifications)];
        }
        return null;
    }
    function push($notification){
        $this->notifications[] = $notification;
        return true;
    }
    function add($type="info",$message=""){
        $Notification = new ApplicationNotification();
        $Notification->type=$type;
        $Notification->message=$message;
        $this->push($Notification);
        return true;
    }

    /**
     * выводит уведомления
     */
    function process(){
        $s = new Smarty();
        $s->template_dir = "/";
        $s->compile_dir = "cache/templates";
        $this->s->addPluginsDir("include/smarty/functions");
        if(!is_dir("cache/templates")){
            mkdir("cache/templates");
        }
        $s->assign("notifications",$this->collect());
        $s->display("include/notifications/templates/index.tpl"); 
    }

    /**
     * собирает уведомления из запроса
     */
    function collect(){
        if(is_array($_REQUEST) && array_key_exists("notifications",$_REQUEST)){
            if(is_string($_REQUEST["notifications"])){
                $decoded = json_decode(html_entity_decode(urldecode($_REQUEST["notifications"])),true);
                if($decoded){
                    $list = array();
                    foreach($decoded as $notification){
                        $type = "info";
                        if(is_array($notification) && array_key_exists("type",$notification) && in_array($notification["type"],$this->notification_types)){
                            $type = $notification["type"];
                        }
                        $list[]=array(
                            "type"=>$type,
                            "message"=>is_string($notification)?$notification:(is_array($notification)&&array_key_exists("content",$notification)?$notification["content"]:null)
                        );
                    }
                    return $list;
                }
            }
        }
        return array();
    }
    function get_url(){
        if($this->notifications){
            if(!empty($this->notifications)){
                $out = array();
                foreach($this->notifications as $notification){
                    $out[]=array(
                        "type"=>$notification->type,
                        "content"=>$notification->message
                    );
                }
                if(!empty($out)){
                    return json_encode($out);
                }
            }
        }
        return "";
    }
}

class ApplicationNotification{
    public $type = "info";
    public $message = "";
}