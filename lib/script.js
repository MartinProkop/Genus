//prepinam obrazek

function ran()
{
    var randomnumber = Math.floor(Math.random() * 2);
    randomnumber = (randomnumber * 1000) + 1000;
    return randomnumber;
}

function close_fancybox(t) {
    setTimeout("parent.$.fancybox.close()", t);
}

function hide(id, id2) {
    var element = document.getElementById(id);
    element.className += " hidden";

    var element2 = document.getElementById(id2);
    element2.className = element2.className.replace("hidden", "");
    
    setTimeout("hide(id2, id)", 3000);
}

function hide(id, id2) {
    var element = document.getElementById(id);
    element.className += " hidden";

    var element2 = document.getElementById(id2);
    element2.className = element2.className.replace("hidden", "");
    
    setTimeout("hide(id2, id)", 3000);
}

function zare_zapni(){
        var element = document.getElementById('zare');
    element.className = "zare_zap";
}

function zare_vypni(){
        var element = document.getElementById('zare');
    element.className = "zare_vyp";
}


function close_fancybox_redirect_parent(link, t)
{
    setTimeout(redirect_parent(link), t);

}

function redirect_parent(link) {
    window.parent.location.href = link;
}

function  add_more_foto() {
  var txt = "<br /><input type=\"file\" class=\"big\" name=\"fileToUpload[]\">";
  document.getElementById("addfoto").innerHTML += txt;
}

function  add_more_foto2() {
  var txt = "<br /><input type=\"file\" class=\"big\" name=\"fileToUpload[]\">";
  document.getElementById("addfoto2").innerHTML += txt;
}

function rolovat_recenzi_down_gurmani(id, id2, id3) {
    var element = document.getElementById(id);
    element.className = element.className.replace("card_prehledy70", "card_prehledy70_bezvysky");

    var element2 = document.getElementById(id2);
    element2.className += " hidden";

    var element3 = document.getElementById(id3);
    element3.className = element3.className.replace("hidden", "");
}

function rolovat_recenzi_up_gurmani(id, id2, id3) {
    var element = document.getElementById(id);
    element.className = element.className.replace("card_prehledy70_bezvysky", "card_prehledy70");

    var element2 = document.getElementById(id2);
    element2.className = element2.className.replace("hidden", "");

    var element3 = document.getElementById(id3);
    element3.className += " hidden";
}

function rolovat_recenzi_down_aktuality(id, id2, id3) {
    var element = document.getElementById(id);
    element.className = element.className.replace("card_prehledy70", "card_prehledy70_bezvysky");

    var element2 = document.getElementById(id2);
    element2.className += " hidden";

    var element3 = document.getElementById(id3);
    element3.className = element3.className.replace("hidden", "");
}

function rolovat_recenzi_up_aktuality(id, id2, id3) {
    var element = document.getElementById(id);
    element.className = element.className.replace("card_prehledy70_bezvysky", "card_prehledy70");

    var element2 = document.getElementById(id2);
    element2.className = element2.className.replace("hidden", "");

    var element3 = document.getElementById(id3);
    element3.className += " hidden";
}

function uka(id1) {
    var element = document.getElementById(id1);
    element.className = element.className.replace("span_img", "span_img_2");  
}

function schov(id1) {
    var element = document.getElementById(id1);
    element.className = element.className.replace("span_img_2", "span_img");  
}