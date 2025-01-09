<?php
    use FrameWork\Session;
    $success_message = Session::getFlash("success_message");
    $error_message = Session::getFlash("error_message");
    $error_message_update = Session::getFlash("error_message_update");
    if ($success_message) {
?>  
    <div class="message bg-green-100 font-bold p-3 my-3"> <?= $success_message; ?> </div>
<?php
    }
?>
<?php
    if ($error_message) {  
?>  
    <div class="message bg-red-100 font-bold p-3 my-3"> <?= $error_message; ?> </div>
<?php
    }
?>

<?php
    if ($error_message_update) {
?>  
    <div class="message bg-green-100 font-bold p-3 my-3"> <?= $error_message_update; ?> </div>
<?php
    }
?>