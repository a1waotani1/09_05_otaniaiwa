<?php
session_start();
session_destroy();
// ログインページへ移動する
header('Location: index.html');
