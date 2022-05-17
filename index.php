<?php

require_once 'captcha_class.php';

$flag = false;
if (isset($_POST['send'])) {
    $code = htmlspecialchars($_POST['code'])?? false;
    $reg = '/\w{4}/';
    if (preg_match($reg, $code) && Captcha::check($code)) {
        echo 'Код введён верно!';
        $flag = true;
    }
    else {
        echo 'Код введён неверно! Попробуйте еще раз';
        $flag = false;
    }
}
?>
<?php if ($flag) { ?>
    <p>
        <a href="/">Назад</a>
    </p>
<?php } else { ?>
    <form name="captcha" action="<?=$_SERVER['PHP_SELF']?>" method="POST">
        <img src="captcha.php" alt="Здесь должна быть капча">
        <p>
            Введите проверочный код: <input type="text" name="code" autofocus>
        </p>
        <input type="submit" name="send" value="Отправить">
    </form>
<?php } ?>