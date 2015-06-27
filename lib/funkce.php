<?php

function format_size($cesta, $round = 3) {
    //Size must be bytes!
    $size = filesize($cesta);
    $sizes = array('B', 'kB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
    for ($i = 0; $size > 1024 && $i < count($sizes) - 1; $i++)
        $size /= 1024;
    return round($size, $round) . " " . $sizes[$i];
}

function echo_date($timestamp) {
    
    
    $den = Date("w", $timestamp);
    
    if ($den == 1) $jmeno = "Pondělí";
    elseif ($den == 2) $jmeno = "Uterý";
    elseif ($den == 3) $jmeno = "Středa";
    elseif ($den == 4) $jmeno = "Ctvrtek";
    elseif ($den == 5) $jmeno = "Pátek";
    elseif ($den == 6) $jmeno = "Sobota";
    elseif ($den == 7) $jmeno = "Neděle";
    
    echo $jmeno . "" .Date(" d. m. Y", $timestamp);
}

function echo_date_picker($timestamp) {

    echo Date("m", $timestamp)."/".Date("d", $timestamp)."/".Date("m", $timestamp);
}

function generateRandomString($length = 6) {
    $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randomString;
}

function send_mail_kovar($jmeno, $maill, $cislo, $body) {
    
    $body = "Z webu AZB-ZAYML.CZ Vám přišel email.\n\n\n\n Od koho: ".$jmeno."\nMail: ".$maill."\nTelefon: ".$cislo."\nText: ".$body."\n\n";
   
    $to = "zayml8@seznam.cz";
    $subject = "Z webu AZB-ZAYML.CZ (info@azb-zayml.cz)";
    
    $mail = new PHPMailer;
    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = 'mail.ldekonom.cz';  // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = 'info@azb-zayml.cz';                 // SMTP username
    $mail->Password = 'jKEHijH2ZbdzBJHzdfiTnGB2';                           // SMTP password
    $mail->SMTPSecure = '';                            // Enable encryption, 'ssl' also accepted

    $mail->From = "info@azb-zayml.cz";
    $mail->FromName = "Z webu AZB-ZAYML.CZ (info@azb-zayml.cz)";

    $mail->addAddress($to);    

    $mail->WordWrap = 80;                                 // Set word wrap to 50 characters
    $mail->isHTML(true);
    $mail->CharSet = "utf-8"; // Set email format to HTML

    $mail->Subject = $subject;
    $mail->Body = $body;
    $mail->AltBody = $body;

    if (!$mail->send()) {
        echo 'Mailer Error: ' . $mail->ErrorInfo;
    } else {
        
    }
}

function nahoru_aktuality() {
    $result = dibi::query('SELECT * FROM [zayml_nabidky] WHERE [id] = %i', $_GET['nahoru']);
    $row = $result->fetch();
    $poradi_new = $row['poradi'] - 1;
    $result2 = dibi::query('SELECT * FROM [zayml_nabidky] WHERE [poradi] = %i', $poradi_new);
    $row2 = $result2->fetch();
    $dolu = $row2['id'];

    $arr = array('poradi' => $poradi_new);
    dibi::query('UPDATE [zayml_nabidky] SET', $arr, 'WHERE [id] = %i', $_GET['nahoru']);
    $arr = array('poradi' => ($poradi_new + 1));
    dibi::query('UPDATE [zayml_nabidky] SET', $arr, 'WHERE [id] = %i', $dolu);
}

function dolu_aktuality() {
    $result = dibi::query('SELECT * FROM [zayml_nabidky] WHERE [id] = %i', $_GET['dolu']);
    $row = $result->fetch();
    $poradi_new = $row['poradi'] + 1;
    $result2 = dibi::query('SELECT * FROM [zayml_nabidky] WHERE [poradi] = %i', $poradi_new);
    $row2 = $result2->fetch();
    $nahoru = $row2['id'];

    $arr = array('poradi' => $poradi_new);
    dibi::query('UPDATE [zayml_nabidky] SET', $arr, 'WHERE [id] = %i', $_GET['dolu']);
    $arr = array('poradi' => ($poradi_new - 1));
    dibi::query('UPDATE [zayml_nabidky] SET', $arr, 'WHERE [id] = %i', $nahoru);
}

function nahoru_fotky_kat() {
    $result = dibi::query('SELECT * FROM [zayml_fotky] WHERE [id] = %i', $_GET['nahoru']);
    $row = $result->fetch();
    $poradi_new = $row['poradi'] - 1;
    $result2 = dibi::query('SELECT * FROM [zayml_fotky] WHERE [poradi] = %i', $poradi_new, "AND [kategorie] = %s", $_GET['ad']);
    $row2 = $result2->fetch();
    $dolu = $row2['id'];

    $arr = array('poradi' => $poradi_new);
    dibi::query('UPDATE [zayml_fotky] SET', $arr, 'WHERE [id] = %i', $_GET['nahoru']);
    $arr = array('poradi' => ($poradi_new + 1));
    dibi::query('UPDATE [zayml_fotky] SET', $arr, 'WHERE [id] = %i', $dolu);
}

function dolu_fotky_kat() {
    $result = dibi::query('SELECT * FROM [zayml_fotky] WHERE [id] = %i', $_GET['dolu']);
    $row = $result->fetch();
    $poradi_new = $row['poradi'] + 1;
    $result2 = dibi::query('SELECT * FROM [zayml_fotky] WHERE [poradi] = %i', $poradi_new, "AND [kategorie] = %s", $_GET['ad']);
    $row2 = $result2->fetch();
    $nahoru = $row2['id'];

    $arr = array('poradi' => $poradi_new);
    dibi::query('UPDATE [zayml_fotky] SET', $arr, 'WHERE [id] = %i', $_GET['dolu']);
    $arr = array('poradi' => ($poradi_new - 1));
    dibi::query('UPDATE [zayml_fotky] SET', $arr, 'WHERE [id] = %i', $nahoru);
}



function nahoru_galerie() {
    $result = dibi::query('SELECT * FROM [hubert_fotogalerie] WHERE [id] = %i', $_GET['nahoru']);
    $row = $result->fetch();
    $poradi_new = $row['poradi'] - 1;
    $result2 = dibi::query('SELECT * FROM [hubert_fotogalerie] WHERE [poradi] = %i', $poradi_new);
    $row2 = $result2->fetch();
    $dolu = $row2['id'];

    $arr = array('poradi' => $poradi_new);
    dibi::query('UPDATE [hubert_fotogalerie] SET', $arr, 'WHERE [id] = %i', $_GET['nahoru']);
    $arr = array('poradi' => ($poradi_new + 1));
    dibi::query('UPDATE [hubert_fotogalerie] SET', $arr, 'WHERE [id] = %i', $dolu);
}

function dolu_galerie() {
    $result = dibi::query('SELECT * FROM [hubert_fotogalerie] WHERE [id] = %i', $_GET['dolu']);
    $row = $result->fetch();
    $poradi_new = $row['poradi'] + 1;
    $result2 = dibi::query('SELECT * FROM [hubert_fotogalerie] WHERE [poradi] = %i', $poradi_new);
    $row2 = $result2->fetch();
    $nahoru = $row2['id'];

    $arr = array('poradi' => $poradi_new);
    dibi::query('UPDATE [hubert_fotogalerie] SET', $arr, 'WHERE [id] = %i', $_GET['dolu']);
    $arr = array('poradi' => ($poradi_new - 1));
    dibi::query('UPDATE [hubert_fotogalerie] SET', $arr, 'WHERE [id] = %i', $nahoru);
}

function nahoru_fotky() {
    $result = dibi::query('SELECT * FROM [hubert_fotky] WHERE [id] = %i', $_GET['nahoru']);
    $row = $result->fetch();
    $poradi_new = $row['poradi'] - 1;
    echo $poradi_new;
    $result2 = dibi::query('SELECT * FROM [hubert_fotky] WHERE [poradi] = %i', $poradi_new, "AND [id_cil] = %i", $_GET['bd'], "AND [typ] = %s", "akce");
    $row2 = $result2->fetch();
    $dolu = $row2['id'];
    
    echo $dolu;

    $arr = array('poradi' => $poradi_new);
    dibi::query('UPDATE [hubert_fotky] SET', $arr, 'WHERE [id] = %i', $_GET['nahoru']);
    $arr = array('poradi' => ($poradi_new + 1));
    dibi::query('UPDATE [hubert_fotky] SET', $arr, 'WHERE [id] = %i', $dolu);
}

function dolu_fotky() {
    $result = dibi::query('SELECT * FROM [hubert_fotky] WHERE [id] = %i', $_GET['dolu']);
    $row = $result->fetch();
    $poradi_new = $row['poradi'] + 1;
    $result2 = dibi::query('SELECT * FROM [hubert_fotky] WHERE [poradi] = %i', $poradi_new, "AND [id_cil] = %i", $_GET['bd'], "AND [typ] = %s", "akce");
    $row2 = $result2->fetch();
    $nahoru = $row2['id'];

    $arr = array('poradi' => $poradi_new);
    dibi::query('UPDATE [hubert_fotky] SET', $arr, 'WHERE [id] = %i', $_GET['dolu']);
    $arr = array('poradi' => ($poradi_new - 1));
    dibi::query('UPDATE [hubert_fotky] SET', $arr, 'WHERE [id] = %i', $nahoru);
}


