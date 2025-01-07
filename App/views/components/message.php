<?php
    if (isset($_SESSION['success_message'])) {
?>  
    <div class="message bg-green-100 font-bold p-3 my-3"> <?= $_SESSION['success_message']; ?> </div>
<?php
    }
    unset($_SESSION['success_message']);
?>
<?php
    if (isset($_SESSION['error_message'])) {
?>  
    <div class="message bg-red-100 font-bold p-3 my-3"> <?= $_SESSION['error_message']; ?> </div>
<?php
    }
    unset($_SESSION['error_message']);
?>

<?php
    if (isset($_SESSION['success_update_message'])) {
?>  
    <div class="message bg-green-100 font-bold p-3 my-3"> <?= $_SESSION['success_update_message']; ?> </div>
<?php
    }
    unset($_SESSION['success_update_message']);
?>