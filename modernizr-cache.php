<?php
    static $modernizr_js = './Modernizr/modernizr.js';
    static $features_dir = './Modernizr/feature-detects';
    static $key = 'Modernizr';
    
    header('Content-type: text/javascript');

    readfile($modernizr_js);
?>
(function(){
<?php
    if (isset($_COOKIE) && isset($_COOKIE[$key])) {
      $cookie = $_COOKIE[$key];
      $modernizr = (get_magic_quotes_gpc() ? stripslashes($cookie) : $cookie);
?>
    var cachedModernizr = <?php print $modernizr;?>;
    for (var f in cachedModernizr) {
        if(f[0]=='_'){
            continue;
        }
        var t=typeof cachedModernizr[f];
        if(t=='function'){
            continue;
        }
        if(t=='object'){
          for(var s in cachedModernizr[f]){
            //"c+='/'+s+':'+(m[f][s]?'1':'0');".
          }
        }else{
          window.Modernizr[f] = cachedModernizr[f];
        }
    }
<?php
    } else {
      $features_path = dirname(__FILE__). '/' . $features_dir;
      $files = scandir($features_path);
?>
    document.addEventListener('DOMContentLoaded',function(evt) {
<?php
      foreach($files as $file){
          readfile($features_path . '/' . $file);
      }
?>
        var c='<?php print $key;?>=';
        if(navigator.appName == 'Opera') {
            c += escape(JSON.stringify(Modernizr));
        } else {
            c += JSON.stringify(Modernizr);
        }
        try{
            document.cookie=c;
        }catch(e){}
    },
    false);

<?php
    }
?>

})();
