<pre>
    <?php
        require_once('config/connection.php')
    ?>
</pre>
<!DOCTYPE html>
<html>
    <head>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    </head>
    <body>
        <div class="container text-center" id="insert">
            <div class="row bg-secondary text-light">
                <div class="col" style="font-size: 30px">Chats</div>
            </div>
            <div class="row" style="margin-top: 15px">
                <div class="col-6">
                    <input class="form-control" type="text" placeholder="chat name" id="name_of_new_chat">
                </div>
                <div class="col-3"></div>
                <button class="btn btn-success col-3" id="create_new_chat">
                    create
                </button>
                <script>
                    document.getElementById('create_new_chat').addEventListener('click', () => {
                        let chat_name = document.getElementById('name_of_new_chat').value;
                        let create_chat = new FormData();
                        create_chat.append('chat_name', chat_name);
                        fetch('http://lab3.ru/create_chat.php', {method: 'POST', body: create_chat})
                        .then(resp => resp.text())
                        .then(new_id => {
                            document.getElementById('name_of_new_chat').value='';
                            let insert=document.getElementById('insert');

                            let row = document.createElement('div');
                            row.className = "row";
                            row.style.marginTop="15px";
                            insert.appendChild(row);

                            let col1=document.createElement('div');
                            col1.className="col-6";
                            col1.innerHTML=chat_name;
                            row.appendChild(col1);

                            let col2=document.createElement('div');
                            col2.className="col-4";
                            row.appendChild(col2);

                            let btn=document.createElement('button');
                            btn.className="btn col-2 btn-primary";
                            btn.id=`enter_in_chat${new_id}`;
                            btn.innerHTML="enter in chat";
                            row.appendChild(btn);

                            btn.addEventListener('click', () => {
                                window.location.href=`chat.php?id=${new_id}`;
                            })
                        })
                    })
                </script>
            </div>

            <?php
            $sql = "SELECT *  FROM `chats`;";
            $result=mysqli_query($connection, $sql);
            if ($result==false){
                mysqli_error($connection);
            }
            $row=mysqli_fetch_assoc($result);
            while ($row){
            ?>

            <div class="row" style="margin-top: 15px">
                <div class="col-6">
                    <?= $row['name'] ?>
                </div>
                <div class="col-4"></div>
                <button class="btn col-2 btn-primary" id="enter_in_chat<?= $row['id'] ?>">
                    enter in chat
                </button>
                <script>
                    document.getElementById('enter_in_chat<?= $row['id'] ?>').addEventListener('click', () => {
                        window.location.href = 'chat.php?id=<?= $row['id'] ?>';
                    })
                </script>
            </div>

            <?php
            $row=mysqli_fetch_assoc($result);
            }
            ?>

        </div>
    </body>
</html>