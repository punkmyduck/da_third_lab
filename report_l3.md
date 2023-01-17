# Отчет о лабораторной работе №3
### По курсу: Основы Программирования
### Работу выполнил: студент группы №3131 Глуаков М.А.
## Цель работы:
Разработать и реализовать анонимный чат с возможностью создания каналов. В интерфейсе отображается список каналов, пользователь может либо подключиться к существующему каналу, либо создать новый. Сообщения доставляются пользователю без обновления страницы.
## Ход работы:
### Пользовательский интерфейс:
Пример меню создания:

![main](https://user-images.githubusercontent.com/122292517/212831929-cd5d886a-a0a1-413f-abfe-141bad88fdc1.jpg)

Пример чата:

![main](https://user-images.githubusercontent.com/122292517/212832291-972723db-11ca-4c9c-b3a3-40d38673861f.jpg)


### Пользовательский сценарий:

Пользователь создает канал и переходит в него или просто переходит в произвольный канал, созданный другим пользователем. В канале пользователь видит предыдущие сообщения и может отправить собственное.

### API сервера:
Сервер использует метод POST для реализации механизма CRUD. Используя метод POST удается размещать в базе данных заметки и комментарии под ними. Так как платформа абсолютно анонимная, то она не подразумевает удаление заметок и комментариев пользователями (только администрирование). 

### Хореография:
Пользователь заходит на сайт и видит возможность добавить новую заметку - поля для ввода **"title_of_note"** и **"text_of_note"**, после заполнения которых, он может нажать кнопку **"отправить"**, после чего пользователь будет перенаправлен на страницу **"donote.php"**, на которой в базу данных занесется информация с полей, введенных пользователем, а сам пользователь вернется обратно на **"home.php"**, где отобразятся новые заметки. Такой же механизм работает для комментариев под заметками на странице **"commentaries.php"**, для лайков на **"dolikes.php"** и дизлайков на **"dodislikes.php"**.

### Структура базы данных:
База данных состоит из двух таблиц:
- **"lab2"** со столбцами *"id"* (ключевой, автоинкремент), *"note_title"* (для хранения названия заметки), *"note_text"* (для хранения текста заметки), *"date"* (для хранения даты публикации), *"likes"* (для хранения поставленных на заметку лайков), *"dislikes"* (для хранения поставленных на заметку дизлакойв).
- **"commentaries"** со столбцами *"id"* (ключевой, автоинкремент), *"id_of_note"* (хранит айди заметки, под которой оставлен комментарий), *"comment"* (хранит текст комментария), *"date"* (хранит дату публикации комментария)

### Алгоритмы
Переход в чат:

![enter_in_chat](https://user-images.githubusercontent.com/122292517/212835425-7d33ae90-6163-48fb-9d73-f27ccd2261f0.png)

Отправление сообщения в чат:

![send_msg](https://user-images.githubusercontent.com/122292517/212843636-fe7d988c-b9c7-4a58-bffd-99dc383506cd.png)

### Значимые фрагменты кода:
Создание чата по нажатию кнопки:

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
                
Содержание create_chat.php:

    <?php
      require_once('config/connection.php');
      $chat_name=$_POST['chat_name'];
      $sql = "INSERT INTO `chats` (`id`, `name`) VALUES (NULL, '$chat_name');";
      $result=mysqli_query($connection, $sql);
      if ($result==false){
          mysqli_error($connection);
      }

      $sql = "SELECT *  FROM `chats` WHERE `name` LIKE '$chat_name';";
      $result=mysqli_query($connection, $sql);
      if ($result==false){
          mysqli_error($connection);
      }
      $row=mysqli_fetch_assoc($result);
      echo $row['id'];
    ?>
