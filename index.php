<?php
//require ("./lib/Debug.php");
//Debug::enable(Debug::DETECT, './logs/php_error.log');
//////// error_reporting(E_ALL);
//error_reporting(E_ALL ^ ~E_STRICT);
//////// ^ E_NOTICE ^ E_WARNING
//require ("./lib/dibi/dibi.php");
//session_start();
//session_name("jmeno");
//session_name("heslo");
//require ("./lib/db.php");
//require ("./lib/funkce.php");
//require ("./lib/prihlaseni_plugin.php");
//require ("./lib/PHPMailer-master/PHPMailerAutoload.php");
?>
<!DOCTYPE html>
<html lang="cs">    
    <head>        
        <?php
        // jazyk
        if ($_GET[lang] == null) {
            $_GET[lang] = "cs";
        }
        // titulek
        if ($_GET[id] == "" || $_GET[id] == "uvod") {
            $title = "ÚVOD | GenusProjekt";
            $linksactive[uvod] = " class=\"active\"";
            if ($_GET[lang] == null) {
                $_GET[lang] = "cs";
            }
        } elseif ($_GET[id] == "stavebni_cinnost") {
            $linksactive[stavebni_cinnost] = " class=\"active\"";
            if ($_GET[lang] == "cs") {
                $title = "STAVEBNÍ ČINNOST | GenusProjekt";
            }
        } elseif ($_GET[id] == "reference") {
            $title = "REFERENCE | GenusProjekt";
            $linksactive[reference] = " class=\"active\"";
            if ($_GET[lang] == null) {
                $_GET[lang] = "cs";
            }
        } elseif ($_GET[id] == "poptavka") {
            $linksactive[poptavka] = " class=\"active\"";
            if ($_GET[lang] == "cs") {
                $title = "POPTÁVKA | GenusProjekt";
            }
        } elseif ($_GET[id] == "kontakt") {
            $linksactive[kontakt] = " class=\"active\"";
            if ($_GET[lang] == "cs") {
                $title = "KONTAKT | GenusProjekt";
            }
        }
        ?>        
        <title>
            <?php echo $title; ?>
        </title>        
        <!-- základ -->        
        <meta http-equiv="content-type" content="text/html; charset=utf-8">        
        <meta name="author" content="LDEkonom.cz" />        
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">        
        <meta name="keywords" content="">        
        <meta name="description" content="">        
        <link href="./img/favicon.png" rel="icon" type="image/gif" />        
        <meta property="og:image" content="" />        
        <meta property="og:url" content="http://www.genusprojekt.cz/" />        
        <meta property="og:title" content="" />        
        <meta property="og:description" content="" />        
        <meta name="robots" content="index,follow,archive" />        
        <meta name="googlebot" content="snippet,archive" />        
        <script type="text/javascript" src="./lib/script.js"></script>        
        <!-- pisma -->        
        <link href='http://fonts.googleapis.com/css?family=Roboto+Slab&subset=latin,latin-ext' rel='stylesheet' type='text/css'>        
        <link href='http://fonts.googleapis.com/css?family=Rajdhani:400,500,600&subset=latin,latin-ext' rel='stylesheet' type='text/css'>        
        <!-- styl -->        
        <?php
        require ("./lib/check_mobile.php");
        if (check_mobile()) {
            echo "<link href=\"./lib/style_mobile.css\" rel=\"stylesheet\" type=\"text/css\" media=\"screen\" />";
        } else {
            echo "<link href=\"./lib/style.css\" rel=\"stylesheet\" type=\"text/css\" media=\"screen\" />";
        }
        ?>           

        <!-- posuv -->
        <link rel="stylesheet" type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/themes/base/jquery-ui.css" />

        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>


        <script type="text/javascript">
            var _posun = {
                _levy: function (obj) {
                    jQuery(obj).stop().animate({
                        scrollLeft: jQuery(obj).scrollLeft() - 400
                    }, 1000, "easeOutQuad");
                },
                _pravy: function (obj) {
                    jQuery(obj).stop().animate({
                        scrollLeft: jQuery(obj).scrollLeft() + 400
                    }, 1000, "easeOutQuad");
                }
            };
        </script>   
        <!-- imagebox -->
        <script type="text/javascript" src="./lib/PKWin_ImageBox/PKWin_ImageBox.js"></script>        
        <link rel="stylesheet" type="text/css" href="./lib/PKWin_ImageBox/PKWin_ImageBox.css" media="screen" />

        <?php
        if ($_GET[id] == "poptavka") {
            ?>
            <!-- validate -->
            <script type="text/javascript" src="./lib/fancybox/lib/jquery-1.10.1.min.js"></script>
            <script src="./lib/validate/PJH/jquery.validate.js"></script>
            <script type="text/javascript" src="./lib/validate/PJH/messages_cs.js"></script>

            <!-- inicializace validace -->
            <script type="text/javascript">
                $(document).ready(function () {
                    $("#load").hide();
                    $("#formul").validate();
                });
                $(document).ready(function () {
                    $("#formul").submit(function ()
                    {
                        if ($("#formul").valid()) {
                            $('#submit1').toggle();
                            $("#load").show();
                        }
                    });
                });
            </script>
            <?php
        }
        ?>

        <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&amp;signed_in=true"></script>
        <script>
            function initialize() {
                var myLatlng = new google.maps.LatLng(50.0787619, 14.4605224);
                var mapOptions = {
                    zoom: 15,
                    center: myLatlng,
                    disableDefaultUI: true
                }
                var map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);

                var marker = new google.maps.Marker({
                    position: myLatlng,
                    map: map,
                    title: 'Genus Projekt, s.r.o. - Jíčínská 227/16'
                });

            }
            google.maps.event.addDomListener(window, 'load', initialize);
        </script>        

    </head>    
    <body>    
        <link rel="prefetch" property="" href="./img/zare.png" />
        <link rel="prefetch" property="" href="./img/button2-hover.png" />
        <link rel="prefetch" property="" href="./img/button1-hover.png" />
        
        
        
        <?php include_once("./lib/analyticstracking.php"); ?>   
        <div id="header">                
            <a href="./index.php"><img src="./img/logo.png" id="logo" alt="GenusProjekt"/></a>                
            <a href="./index.php"><div id="zare" class="zare_vyp"></div></a>                       
            <img src="./img/line-menu.png" id="line_menu" alt="GenusProjekt"/>                
            <div id="main-menu" onmouseover="zare_zapni()" onmouseout="zare_vypni()">                    
                <ul>                        
                    <li <?php echo $linksactive[uvod]; ?>>
                        <a href="./index.php?id=uvod" title="úvod">úvod</a>
                    </li>                        
                    <li <?php echo $linksactive[stavebni_cinnost]; ?>>
                        <a href="./index.php?id=stavebni_cinnost" title="stavební činnost">stavební činnost</a>
                    </li>                        
                    <li <?php echo $linksactive[reference]; ?>>
                        <a href="./index.php?id=reference" title="reference">reference</a>
                    </li>                        
                    <li <?php echo $linksactive[poptavka]; ?>>
                        <a href="./index.php?id=poptavka" title="poptávka">poptávka</a>
                    </li>                        
                    <li <?php echo $linksactive[kontakt]; ?>>
                        <a href="./index.php?id=kontakt" title="Kontakt">Kontakt</a>
                    </li>                    
                </ul>                
            </div>            
        </div>
        <div id="content">     
            <?php
            if ($_GET[id] == null || $_GET[id] == "uvod") {
                ?>                          
                <div id="panel">                    
                    <div id="obsah_panelu">                        
                        <h1>O společnosti</h1>                        
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla semper molestie augue. Maecenas ultricies augue felis, pharetra sagittis eros vestibulum ut.</p>                        
                        <div>                            
                            <div class="grid_6">                                
                                <ul class="ul">                                    
                                    <li>Položka 1
                                    </li>                                    
                                    <li>Položka 2
                                    </li>                                    
                                    <li>Položka 2
                                    </li>                                    
                                    <li>Položka 2
                                    </li>                                    
                                    <li>Položka 2
                                    </li>                                
                                </ul>                            
                            </div>                            
                            <div class="grid_6">                                
                                <ul class="ul">                                    
                                    <li>Položka 1
                                    </li>                                    
                                    <li>Položka 2
                                    </li>                                
                                </ul>                            
                            </div>                            
                            <div class="clear">
                            </div>                        
                        </div>                        <br />                        
                        <a href="#" class="button">Zaslat poptávku</a>                    
                    </div>                
                </div>                
                <div class="margin_top">                    
                    <div class="grid_6 vertical_cara padding_gridu">
                        <h2>Článek</h2>                        
                        <p class="grid">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla semper molestie augue. Maecenas ultricies augue felis, pharetra sagittis eros vestibulum ut. Sed iaculis posuere dolor, elementum dignissim turpis mattis non. Ut ac tortor vitae libero tempor mattis. Vivamus bibendum lectus suscipit, efficitur urna at, faucibus risus. Duis neque ex, pellentesque vel risus vitae, vulputate tincidunt nunc. Duis at nisi nec mauris pretium tincidunt vel non mi. 
                        </p>                    
                    </div>                    
                    <div class="grid_6 padding_gridu">
                        <h2>Článek</h2>                        
                        <p class="grid">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla semper molestie augue. Maecenas ultricies augue felis, pharetra sagittis eros vestibulum ut. Sed iaculis posuere dolor, elementum dignissim turpis mattis non. Ut ac tortor vitae libero tempor mattis. Vivamus bibendum lectus suscipit, efficitur urna at, faucibus risus. Duis neque ex, pellentesque vel risus vitae, vulputate tincidunt nunc. Duis at nisi nec mauris pretium tincidunt vel non mi. 
                        </p>                       
                    </div>                    
                    <div class="clear">
                    </div>                
                </div>  

                <div class="HPreference">
                    <a class="bt_ref_leva" href="javascript:_posun._levy(jQuery('#pn_reference'));"></a>
                    <div id="pn_reference" class="stred">
                        <div class="obsah">
                            <div class="reference">
                                <div class="logo">
                                    <a href="./img/panel1.png" class="bt_detail PKWin_ImageBox"><img src="./img/img-homepage.jpg" alt=""  width="170px" /></a>
                                </div>
                            </div>
                            <div class="reference">
                                <div class="logo">
                                    <a href="./img/panel1.png" class="bt_detail PKWin_ImageBox"><img src="./img/img-homepage.jpg" alt=""  width="170px" /></a>
                                </div>
                            </div>
                            <div class="reference">
                                <div class="logo">
                                    <a href="./img/panel1.png" class="bt_detail PKWin_ImageBox"><img src="./img/img-homepage.jpg" alt=""  width="170px" /></a>
                                </div>
                            </div>
                            <div class="reference">
                                <div class="logo">
                                    <a href="./img/panel1.png" class="bt_detail PKWin_ImageBox"><img src="./img/img-homepage.jpg" alt=""  width="170px" /></a>
                                </div>
                            </div>
                            <div class="reference">
                                <div class="logo">
                                    <a href="./img/panel1.png" class="bt_detail PKWin_ImageBox"><img src="./img/img-homepage.jpg" alt=""  width="170px" /></a>
                                </div>
                            </div>
                            <div class="reference">
                                <div class="logo">
                                    <a href="./img/panel1.png" class="bt_detail PKWin_ImageBox"><img src="./img/img-homepage.jpg" alt=""  width="170px" /></a>
                                </div>
                            </div>
                            <div class="reference">
                                <div class="logo">
                                    <a href="./img/panel1.png" class="bt_detail PKWin_ImageBox"><img src="./img/img-homepage.jpg" alt=""  width="170px" /></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <a class="bt_ref_prava" href="javascript:_posun._pravy(jQuery('#pn_reference'));"></a>
                </div> 
                <?php
            } elseif ($_GET[id] == "stavebni_cinnost") {
                ?>     
                <div id="panel_reference">                    
                    <div id="obsah_panelu_poptavka">                        
                        <h1>Stavební činnost</h1>                        
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla semper molestie augue. Maecenas ultricies augue felis, pharetra sagittis eros vestibulum ut.</p> 
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla semper molestie augue. Maecenas ultricies augue felis, pharetra sagittis eros vestibulum ut.</p> 

                        <ul class="ul2">                                    
                            <li>Položka 1</li>                                    
                            <li>Položka 2</li>                                    
                            <li>Položka 2</li>                                    
                            <li>Položka 2</li>                                    
                            <li>Položka 2</li>                                
                        </ul>
                    </div>     
                </div>  
                <?php
            } elseif ($_GET[id] == "reference") {
                ?>   
                <div id="panel_reference">                    
                    <div id="obsah_panelu_poptavka">
                        <h1>Reference</h1>
                        <p>Zde uvádíme některé z projektů, na kterých jsme v minulosti pracovali.</p>
                        <div class="margin_top">                    
                            <div class="grid_6"  onmouseover="document.img1.src = './img/img.jpg';
                                    uka('span1');" onmouseout="document.img1.src = './img/img2.jpg';
                                            schov('span1');">
                                <a href="./img/panelA.png" data-group= "r1" class="PKWin_ImageBox">
                                    <img src="./img/panelA.png" alt="Dlouhý text popisku 1" title="reference1 - úvoní" class="noshow"/>
                                    <div class="karta">
                                        <div>                    
                                            <div class="grid_4">
                                                <img src="./img/img2.jpg" alt="sample" title="reference1 - úvoní" class="img_karta" name="img1"/>
                                                <div class="span_img" id="span1">3 obrázky</div>   
                                            </div>                    
                                            <div class="grid_8">
                                                <h4>Jméno klienta</h4>
                                                <span class="title">Druh provedené práce</span>
                                                <div class="horizontal_cara2">&nbsp;</div>
                                                Zde uvádíme některé z projektů, na kterých jsme v minulosti pracovali.
                                            </div>                    
                                            <div class="clear"></div>                
                                        </div>  
                                    </div>
                                </a>

                                <a href="./img/panelB.png" data-group= "r1" class="PKWin_ImageBox noshow"><img src="./img/panelB.png" alt="Dlouhý text popisku 2" title="reference1 - obrazek2" class="noshow"/></a>
                                <a href="./img/panelC.png" data-group= "r1" class="PKWin_ImageBox noshow"><img src="./img/panelC.png" alt="Dlouhý text popisku 3" title="reference1 - obrazek3" class="noshow"/></a>
                            </div>                   
                            <div class="grid_6"  onmouseover="document.img2.src = './img/img.jpg';
                                    uka('span2');" onmouseout="document.img2.src = './img/img2.jpg';
                                            schov('span2');">
                                <a href="./img/panelA.png" data-group= "r2" class="PKWin_ImageBox">
                                    <img src="./img/panelA.png" alt="Dlouhý text popisku 1" title="reference2 - úvoní" class="noshow"/>
                                    <div class="karta">
                                        <div>                    
                                            <div class="grid_4">
                                                <img src="./img/img2.jpg" alt="sample" class="img_karta" name="img2"/>
                                                <div class="span_img" id="span2">1 obrázek</div>   
                                            </div>                    
                                            <div class="grid_8">
                                                <h4>Jméno klienta</h4>
                                                <span class="title">Druh provedené práce</span>
                                                <div class="horizontal_cara2">&nbsp;</div>
                                                Zde uvádíme některé z projektů, na kterých jsme v minulosti pracovali.
                                            </div>                    
                                            <div class="clear"></div>                
                                        </div>  
                                    </div>
                                </a>
                            </div>                   
                            <div class="clear"></div>                
                        </div> 
                        <div class="margin_top">                    
                            <div class="grid_6"  onmouseover="document.img3.src = './img/img.jpg';
                                    uka('span3');" onmouseout="document.img3.src = './img/img2.jpg';
                                            schov('span3');">
                                <a href="./img/panelA.png" data-group= "r3" class="PKWin_ImageBox">
                                    <img src="./img/panelA.png" alt="Dlouhý text popisku 1" title="reference3 - obrazek1" class="noshow"/>
                                    <div class="karta">
                                        <div>                    
                                            <div class="grid_4">
                                                <img src="./img/img2.jpg" alt="sample" class="img_karta" name="img3"/>
                                                <div class="span_img" id="span3">2 obrázky</div>   
                                            </div>                    
                                            <div class="grid_8">
                                                <h4>Jméno klienta</h4>
                                                <span class="title">Druh provedené práce</span>
                                                <div class="horizontal_cara2">&nbsp;</div>
                                                Zde uvádíme některé z projektů, na kterých jsme v minulosti pracovali.
                                            </div>                    
                                            <div class="clear"></div>                
                                        </div>  
                                    </div>
                                </a>
                                <a href="./img/panelC.png" data-group= "r3" class="PKWin_ImageBox noshow"><img src="./img/panelB.png" alt="Dlouhý text popisku 2" title="reference3 - obrazek2" class="noshow"/></a>
                            </div>                    
                            <div class="grid_6">

                            </div>                  
                            <div class="clear"></div>                
                        </div> 
                    </div>            
                </div>  
                        <?php
                    } elseif ($_GET[id] == "poptavka") {
                        ?>     
                <div id="panel_poptavka">                    
                    <div id="obsah_panelu_poptavka">                        
                        <h1>Poptávka</h1>                        
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla semper molestie augue. Maecenas ultricies augue felis, pharetra sagittis eros vestibulum ut.</p>                        
    <?php
    if ($_POST[submit1]) {
        echo "<div class=\"msg information\"><h2>Vaše zpráva byla odeslána, budeme Vás brzy kontaktovat.</h2></div>";
        // send_mail_kovar($_POST['jmeno'], $_POST['email'], $_POST['cislo'], $_POST['textarea1']);
    }
    ?>
                        <form id="formul" name="formul" method="post" action="./index.php?id=poptavka" enctype="multipart/form-data">
                            <div class="formular">
                                <input type="text" class="big" id="jmeno" name="jmeno" placeholder="Jméno a Příjmení" value="" required>
                                <input type="text" class="big" id="cislo" name="cislo" placeholder="Telefonní číslo" value="" required>
                                <input type="text" class="big" id="email" name="email" placeholder="E-mail" value="" required email="true">
                                <textarea id="textarea1" name="textarea1" required placeholder="Váš dotaz"></textarea>
                            </div>
                            <input type="submit" class="" id="submit1" name="submit1" value="Odeslat poptávku">  
                        </form>  

                        <div class="clear"></div>
                    </div>                
                </div>  
    <?php
} elseif ($_GET[id] == "kontakt") {
    ?> 
                <div id="panel_poptavka">                    
                    <div id="obsah_panelu_poptavka">                        
                        <h1>Kontakt</h1>                        
                        <div class="margin_top10">                            
                            <div class="grid_4">                                
                                <h3>Jednatel</h3>
                                <p class="patka">Daniela Lískovcová</p>                            
                                <p class="patka">Tel.:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;+420 775 315 065</p>  
                                <p class="patka">E-mail.:&nbsp;&nbsp;&nbsp;<a href="mailto:info@genus-projekt.cz">info@genus-projekt.cz</a></p> 
                            </div>                            
                            <div class="grid_4">                                
                                <h3>Ředitel divize stavby</h3>
                                <p class="patka">Jiří Lískovec</p>                            
                                <p class="patka">Tel.:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;+420 723 617 255</p>  
                                <p class="patka">E-mail.:&nbsp;&nbsp;&nbsp;<a href="mailto:info@genus-projekt.cz">info@genus-projekt.cz</a></p> 
                            </div>                            
                            <div class="clear"></div>                        
                        </div>
                        <div class="horizontal_cara">&nbsp;</div>
                        <div>                            
                            <div class="grid_4">                                
                                <h3>Sídlo</h3>                                                        
                                <p class="patka">Genus Projekt, s.r.o.</p>                            
                                <p class="patka">Jíčínská 227/16</p>                                                        
                                <p class="patka">130 00 Praha 3 - Žižkov</p>   
                            </div>                            
                            <div class="grid_4">                                
                                <h3>Provozovna</h3>                                                        
                                <p class="patka">Drahotěšice 17</p>                            
                                <p class="patka">373 41 Hluboká nad Vltavou</p>   
                            </div>                            
                            <div class="clear"></div>                        
                        </div> 
                        <div class="horizontal_cara">&nbsp;</div>
                        <h3>Fakturační údaje</h3>  
                        <div>                            
                            <div class="grid_4">                                                                    
                                <p class="patka">Genus Projekt, s.r.o.</p>                            
                                <p class="patka">Jíčínská 227/16</p>                                                        
                                <p class="patka">130 00 Praha 3 - Žižkov</p>   
                            </div>                            
                            <div class="grid_4">                                
                                <p class="patka">IČ:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;03345823</p>                            
                                <p class="patka">DIČ:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;CZ03345823</p>   
                                <p class="patka">DPH:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Jsme plátci DPH</p>   
                            </div>
                            <div class="grid_4">                                
                                <p class="patka">Účet: 123456789/0000 (banka)</p>                            
                                <p class="patka">&nbsp;</p>   
                                <p class="patka">Datová schránka: xxxxxx</p>   
                            </div>   
                            <div class="clear"></div>                        
                        </div>  
                    </div>                
                </div> 

                <div id="mapa">
                    <div id="map-canvas"></div>

                </div>


    <?php
}
?>  
            <div id="footer">                    
                <div>                        
                    <div class="grid_4">
                        <h3>Kontakt</h3>                            
                        <p class="patka">Daniela Lískovcová</p>                            
                        <p class="patka">Tel.:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;+420 775 315 065</p>  
                        <p class="patka">E-mail.:&nbsp;&nbsp;&nbsp;<a href="mailto:info@genus-projekt.cz">info@genus-projekt.cz</a></p> 
                    </div>                        
                    <div class="grid_3">
                        <h3>Sídlo</h3>                                                        
                        <p class="patka">Genus Projekt, s.r.o.</p>                            
                        <p class="patka">Jíčínská 227/16</p>                                                        
                        <p class="patka">130 00 Praha 3 - Žižkov</p>                                          
                    </div>                        
                    <div class="grid_3">
                        <h3>Provozovna</h3>                                                        
                        <p class="patka">Drahotěšice 17</p>                            
                        <p class="patka">373 41 Hluboká nad Vltavou</p>                        
                    </div>                        
                    <div class="grid_2 copygrid">                            
                        <h3 class="copyright">Copyright &copy; 2015<br /> 
                            <a href="http://www.ldekonom.cz">LD Ekonom</a></h3>                        
                    </div>                        
                    <div class="clear">
                    </div>                    
                </div>                
            </div>               
        </div>                                            
    </body>
</html>
