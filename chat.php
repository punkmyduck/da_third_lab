<pre>
<?php
    require_once('config/connection.php');
    $id = $_GET['id'] ?? null;
    if ($id) {
        $sql = "SELECT *  FROM `chats` WHERE `id` = $id;";
        $result=mysqli_query($connection, $sql);
        if ($result==false){
            mysqli_error($connection);
        }
        $row=mysqli_fetch_assoc($result);
    }
    
?>
</pre>

<!DOCTYPE html>
<html>
    <head>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    </head>
    <body>
        <div class="container text-center" id="my_chat">
            <div class="row">
                <div class="col-4"></div>
                <div class="col-4 bg-primary text-light" style="font-size: 30px">
                Chat <br><?= $row['name'] ?>
                </div>
                <div class="col-4"></div>
            </div>
            <?php
            $sql = "SELECT *  FROM `messages` WHERE `chat_id` = $id;";
            $result_chat=mysqli_query($connection, $sql);
            if ($result_chat==false){
                mysqli_error($connection);
            }
            $messages=mysqli_fetch_assoc($result_chat);
            while ($messages){
            ?>
            <div class="row">
                <div class="col-4" style="margin-top: 10px" align="right">msg:</div>
                <div class="col-md-auto bg-secondary text-light" style="margin-top: 10px"><?= $messages['message'] ?></div>
                <div class="col-4"></div>
            </div>
            <?php
            $lastmsg=$messages['id'];
            $messages=mysqli_fetch_assoc($result_chat);
            }
            ?>
        </div>
        <div class="container text-center">
            <div class="row" style="margin-top: 10px">
                <div class="col-4"></div>
                <div class="col-4">
                    <input class="from-control" id="new_message" placeholder="message">
                </div>
                <div class="col-4"></div>
            </div>
            <div class="row" style="margin-top: 10px">
                <div class="col-4"></div>
                <button class="col" id="send_new_message">
                    send
                </button>
                <div class="col-4"></div>
            </div>
        </div>
        <script>
            document.getElementById("send_new_message").addEventListener('click', () => {
                let message = document.getElementById('new_message').value;
                let chat_id = <?= $id ?>; 
                let send_message = new FormData();
                send_message.append('message', message);
                send_message.append('chat_id', chat_id)
                fetch('http://lab3.ru/send_message.php', {method: 'POST', body: send_message})
                .then( () => {
                    document.getElementById("new_message").value='';
                    let my_chat=document.getElementById('my_chat');

                    let row = document.createElement('div');
                    row.className="row";
                    my_chat.appendChild(row);

                    let col1 = document.createElement('div');
                    col1.className="col-4";
                    col1.innerHTML="msg:";
                    col1.style.marginTop="10px";
                    col1.align="right";
                    row.appendChild(col1);

                    let col2 = document.createElement('div');
                    col2.className="col-md-auto bg-secondary text-light";
                    col2.style.marginTop="10px";
                    col2.innerHTML=message;
                    row.appendChild(col2);
                    
                    let col3 = document.createElement('div');
                    col3.className="col-4";
                    col3.style.marginTop="10px";
                    row.appendChild(col3);
                })
            })
        </script>
    </body>
</html>