<?php
  require_once './send_push.php';

  if(isset($_POST['submit']) && isset($_POST['title']) && isset($_POST['message']) && $_POST['title']!=""){
    $pushy = new Push($_POST['title'],$_POST['message'],"","",type::NTF);
    $pushy->sendToTopic('global');
  }
 ?>

 <!DOCTYPE html>
 <html lang="en" dir="ltr">
   <head>
     <meta charset="utf-8">
     <title>send PUSHYs</title>
   </head>
   <body>
     <h1>Send PUSHYs here</h1>

     <form action="index.php" method="post">
       <input type="text" name="title" placeholder="title here">
       <input type="text" name="message" placeholder="message body here">
       <input type="submit" name="submit" value="submit">
     </form>
   </body>
 </html>
