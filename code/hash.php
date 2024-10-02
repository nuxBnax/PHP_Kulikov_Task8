<?php

$hash = password_hash('123', PASSWORD_DEFAULT);

if (password_verify('123', '$2y$10$CKuKkSxmpb1ra1U7kfJZ1.EyjEp./8XfoQmhQklDNQYnkL.rWc0im')) {
    echo 'Пароль верен';
    echo $hash;
} else {
echo 'пароль не верен';
}