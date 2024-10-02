<?php
// session_start();
// $_SESSION['message'] = 'Пользователь дурак';


print_r($_SESSION['user_name']);
print_r($_SESSION['user_lastname']);
print_r($_SESSION['id_user']);

// $_SESSION['user_name'] = $result[0]['user_name'];
// $_SESSION['user_lastname'] = $result[0]['user_lastname'];
// $_SESSION['id_user'] = $result[0]['id_user'];

// unset($_SESSION['messsage']); // не разрушит связь браузера с файлом сессии, остальные данные останутся
// session_destroy(); // удаляет идентификатор/куку но файл на сервере сохраняется
// лучше использовать и то и другое