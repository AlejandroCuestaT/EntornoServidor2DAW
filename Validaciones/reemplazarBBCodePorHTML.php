<?php
function convertirBBcode($string){
  $string = strip_tags($string);
  $patterns = array(
    "bold" => "#\[b\](.*?)\[/b\]#is",
    "italics" => "#\[i\](.*?)\[/i\]#is",
    "underline" => "#\[u\](.*?)\[/u\]#is",
    "link_title" => "#\[url=(.*?)](.*?)\[/url\]#i",
    "link_basic" => "#\[url](.*?)\[/url\]#i",
    "color" => "#\[color=(red|green|blue|yellow)\](.*?)\[/color\]#is"
);
$replacements = array(
  "bold" => "<b>$1</b>",
  "italics" => "<i>$1</i>",
  "underline" => "<u>$1</u>",
  "link_title" => "<a href=\"$1\">$2</a>",
  "link_basic" => "<a href=\"$1\">$1</a>",
  "color" => "<span style='color:$1;'>$2</span>"
);
return preg_replace($patterns, $replacements, $string);
}
//ejemplo:
echo convertirBBcode("[b]letra negrita[/b]");
echo '<br>';
echo convertirBBcode("[u]letra subrayada[/u]");
?>