<?php
  class Push{
    private $title; //push title
    private $message; //push body text
    private $image; //push image URL. the image that is shown in your pushy. ;)
    private $data;  //data payload. actually an array.
    private $type;  //type of message: notification, data msg with notification or hidden data msg. NTF, NDT, HDT. it's HDT by default.

    abstract class type{
      const HDT = 0;//hidden data message
      const NDT = 1;//data message with notification
      const NTF = 2;//Firebase handled notification
    }

    function __construct($title,$message,$image,$data,$type = type::HDT) {
         $this->title = $title;
         $this->message = $message;
         $this->image = $image;
         $this->data = $data;
         $this->type = $type;
    }

    function __construct($title,$message,$data,$type = type::HDT) {
         $this->title = $title;
         $this->message = $message;
         $this->image = null;
         $this->data = $data;
         $this->type = $type;
    }

    public function sendToTopic($topic){
        sendTo('/topics/' . $topic);
    }

    // the json file structure is:
    //  {
    //    to : "user id or topic" ,
    //
    //    notification : {
    //      title : "title" ,
    //      body : "msg text content" ,
    //      icon : "icon"
    //    }
    //
    //    data : {
    //      x = 0 ,
    //      y = "sometext" , ...
    //    }
    //  }

    public function sendTo($userid){
      require_once __DIR__.'/config.php';
      //creating different data lists for json file
      $data = array('to' => $userid , data => array());
      if($this->type == type::HDT){

      }else if($this->type == type::NDT){

      }else{

      }
      send($data);
    }

    //sending request to Firebase server
    public function send($data){

    }

  }
 ?>
