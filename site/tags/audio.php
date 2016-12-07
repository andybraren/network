<?php

// Audio Tag
// by Andy Braren
// Embeds an HTML5 audio element with controls

/* CHANGELOG
2016-12-06 - Initial creation
*/

kirbytext::$tags['audio'] = array(
  'attr' => array(
  ),
  'html' => function($tag) {
    
    if ($tag->page()->file($tag->attr('audio')) != null) {
      $url = $tag->page()->file($tag->attr('audio'))->url();
      return '<audio controls src="' . $url . '"></audio>';
    }
    
  }
);

?>