<?php
function limpiarTags($source, $tags = null){
  function clean($matched){
    $attribs =
    "javascript:|onclick|ondblclick|onmousedown|onmouseup|onmouseover|".
    "onmousemove|onmouseout|onkeypress|onkeydown|onkeyup|".
    "onload|class|id|src|style";
    $quot = "\"|\'|\`";
    $stripAttrib = "' ($attribs)\s*=\s*($quot)(.*?)(\\2)'i";
    $clean = stripslashes($matched[0]);
    $clean = preg_replace($stripAttrib, '', $clean);
    return $clean;
  }
  $allowedTags='<a><br><b><i><br><li><ol><p><strong><u><ul>';
  $clean = strip_tags($source, $allowedTags);
  $clean = preg_replace_callback('#<(.*?)>#', "clean", $source);
  return $source;
}
//ejemplo:
echo limpiarTags("este código es malicioso <script>alert('hola!')</script>");
?>