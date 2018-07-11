<?php


  abstract class type{
    const HDT = 0;//hidden data message
    const NDT = 1;//data message with notification
    const NTF = 2;//Firebase handled notification
  }

  class Push{
    private $title; //push title
    private $message; //push body text
    private $image; //push image URL. the image that is shown in your pushy. ;)
    private $data;  //data payload. actually an array.
    private $type;  //type of message: notification, data msg with notification or hidden data msg. NTF, NDT, HDT. it's HDT by default.


    function __construct($title,$message,$image,$data,$type = type::HDT) {
         $this->title = $title;
         $this->message = $message;
         $this->image = $image;
         $this->data = $data;
         $this->type = $type;
    }

    public function sendToTopic($topic){
        $this->sendTo('/topics/' . $topic);
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
      //creating different data lists for json file
      $data = array('to' => $userid, 'message_type' => 'receipt' );
      if($this->type == type::HDT){
        $data['data']=$this->data;
      }else if($this->type == type::NDT){
        $data['notification']=array();
        $data['notification']['title'] = $this->title;
        $data['notification']['body'] = $this->message;
        $data['data']=$this->data;
      }else{
        $data['notification']=array();
        $data['notification']['title'] = $this->title;
        $data['notification']['body'] = $this->message;
      }
      $this->send($data);
    }

    //sending request to Firebase server
    public function send($data){
        require_once __DIR__.'/config.php';
        // Set POST variables
       $url = 'https://fcm.googleapis.com/fcm/send';

       $headers = array(
           'Authorization: key=' . FIREBASE_API_KEY,
           'Content-Type: application/json'
       );

       // Opening connection
        $ch = curl_init();

        // Set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Disabling SSL Certificate support temporarly
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        //converting $data to json and sending to FCM server.
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

        echo json_encode($data);

        // Executing post request
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }
        echo $result;

        // Close connection
        curl_close($ch);

        return $result;
    }

  }
 ?>
