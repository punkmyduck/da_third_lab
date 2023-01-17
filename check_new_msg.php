<?php
require_once('config/connection.php');
$msg_id = $_POST['msg_id'];
$chat_id = $_POST['chat_id'];
$sql = "SELECT *  FROM `messages` WHERE `chat_id` = $chat_id ORDER BY `id` DESC;";
$result = mysqli_query($connection, $sql);
$last_row = mysqli_fetch_assoc($result);
if ($msg_id!=$last_row['id']){
    echo '1';
}
else echo '0';
?>