<?php
$passNueva = '2023';
echo password_hash($passNueva, PASSWORD_DEFAULT, ['cost' => 7]);
