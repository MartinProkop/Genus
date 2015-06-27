<?php

function loguj($jmenolog, $heslolog, $zustatprihlasen) {
    if ($jmenolog == "")
        return 2;
    $hash_heslo = $heslolog;

    $query = dibi::query('SELECT * FROM [zayml_uzivatele] WHERE [jmeno] = %s', $jmenolog);
    while ($row = $query->fetch()) {
        $jmenotrue = $jmenolog;
        $heslotrue1 = $row[heslo];
    }

    if ($hash_heslo == $heslotrue1) {
        $_SESSION['jmeno'] = $jmenotrue;
        $_SESSION['heslo'] = $hash_heslo;

        //cookie
        if ($zustatprihlasen == "ano") {
            $token = md5(uniqid(time(), true));
            setcookie("zayml_trvale_prihlaseni", "$_SESSION[jmeno]:$token", strtotime("+1 month"));

            $arr_uzivatel = array('token' => $token);
            dibi::query('UPDATE [zayml_uzivatele] SET ', $arr_uzivatel, 'WHERE [jmeno] = %s', $_SESSION['jmeno']);
        }
        return 1;
    } else {
        $_SESSION['jmeno'] = "";
        $_SESSION['heslo'] = "";
        return 2;
    }
}

function login_check() {
    list($id_uzivatel, $token) = explode(":", $_COOKIE["zayml_trvale_prihlaseni"], 2);

    $query = dibi::query('SELECT * FROM [zayml_uzivatele] WHERE [jmeno] = %s', $id_uzivatel);
    while ($row = $query->fetch()) {
        $token_db = $row[token];
        $jmeno = $row[jmeno];
        $hash_heslo = $row[heslo];
    }

    if ($token_db == $token && $token_db != "") {
        $_SESSION['jmeno'] = $jmeno;
        $_SESSION['heslo'] = $hash_heslo;
        return TRUE;
    }

    if ($_SESSION['jmeno'] == "")
        return FALSE;

    $query = dibi::query('SELECT * FROM [zayml_uzivatele] WHERE [jmeno] = %s', $_SESSION['jmeno']);
    while ($row = $query->fetch()) {
        $heslotrue = $row[heslo];
    }

    if ($_SESSION['heslo'] == $heslotrue) {
        return TRUE;
    } else {
        return FALSE;
    }
}

function admin_check() {
    $query = dibi::query('SELECT * FROM [zayml_uzivatele] WHERE [jmeno] = %s', $_SESSION[jmeno]);
    $row = $query->fetch();
    if ($row[admin] == "ano")
        return true;
    else
        return false;
}

function logout($jmeno) {
    //cookie
    $arr_uzivatel = array('token' => "");
    dibi::query('UPDATE [zayml_uzivatele] SET ', $arr_uzivatel, 'WHERE [jmeno] = %s', $_SESSION['jmeno']);
    if (isset($_COOKIE["zayml_trvale_prihlaseni"])) {
        unset($_COOKIE["zayml_trvale_prihlaseni"]);
        setcookie('zayml_trvale_prihlaseni', '', time() - 3600); // empty value and old timestamp
    }

    $_SESSION['jmeno'] = "";
    $_SESSION['heslo'] = "";
}

if ($_POST['pokusolog'] == 1) {
    $_SESSION['jmeno'] = $_POST['jmeno'];
    $_SESSION['heslo'] = $_POST['heslo'];
}

//OSETRENI LOGINU
if ($_GET['action'] == "logout")
    logout($_SESSION['jmeno']);
//OSETRENI LOGINU
?>
