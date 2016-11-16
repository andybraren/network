<?php

// Callout Tag
// by Andy Braren
// Creates a highlighted note for highlights, notes, warnings, notices, etc.

/* CHANGELOG
2015-12-08 - Initial creation

*/

/*
(callout: warning text: **Important note:** Be careful when you disassemble the computer.)
*/

/* ISSUES
  - Markdown parsing doesn't really work well in a single line. May have to move to this: https://forum.getkirby.com/t/no-markdown-parsing-with-kirbytags/2070/2
*/

kirbytext::$tags['callout'] = array(
  'attr' => array(
    'text',
  ),
  'html' => function($tag) {
    $type = $tag->attr('callout');
  	$text = $tag->attr('text');
  	return '<div class="callout ' . $type . '">' . kirbytext($text) . '</div>';
  }
);

?>