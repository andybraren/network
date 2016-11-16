<?php

// Heading Anchor Plugin
// created by fitzage
// https://forum.getkirby.com/t/plugin-to-make-header-tags-linkable/3469
// modified Andy Braren
// Auto-generates anchors for every heading 

// CHANGELOG
// 2015-12-08 - 




kirbytext::$post[] = function($kirbytext, $value) {
  return preg_replace_callback('!\(toc\)!', function($match) use($value) {
    preg_match_all('!<h2>(.*)</h2>!', $value, $matches);
    $ul = brick('ul');
    $ul->addClass('toc');
    foreach($matches[1] as $match) {
      $li = brick('li', '<a href="#' . str::slug($match) . '">' . $match . '</a>');
      $ul->append($li);
    }
    return $ul;
  }, $value);
};

// These filters run after all markdown and kirbytext is processed.
kirbytext::$post[] = function($kirbytext, $value) {
    $value = preg_replace_callback("#<(h[1-3]).*>(.*?)</\\1>#", "retitle", $value);
    return $value;
};




// Add ID attributes to all headers that are in fields processed by kirbytext.
function retitle($match) {
    // Characters in the $delete array will be removed
    // Characters in the $hyphenate array will be changed to hyphens
    $delete = c::get('headid-delete', array(':','(',')','?','.','!','$',',','%','^','&',"'",';','"','[',']','{','}','|','`','#'));
    $hyphenate = c::get('headid-hyphenate', array('~','@','*','+','=',' - ',' / ','/','>','<',' '));
    list($_unused, $h2, $title) = $match;
    preg_match('/id=\"(.*)\"/',$_unused,$idmatches);
    preg_match('/name=\"(.*)\"/',$_unused,$namematches);
    if (empty($idmatches) && empty($namematches)) {
        $id = strip_tags($title);
        $id = strtolower(str_replace($delete,'',str_replace($hyphenate,'-',$id)));
        $id = preg_replace('/<\/?a[^>]*>/','',$id);
        //return "<$h2 id='$id'><a href='#$id'>$title</a></$h2>";
        return "<$h2 id='$id'>$title</$h2>";
    } elseif (!empty($idmatches) && empty($namematches)) {
        //return "<$h2 $idmatches[0]><a href='#$idmatches[1]'>$title</a></$h2>";
        return "<$h2 $idmatches[0]>$title</$h2>";
    } elseif (empty($idmatches) && !empty($namematches)) {
        //return "<$h2 id='$namematches[1]'><a href='#$namematches[1]'>$title</a></$h2>";
        return "<$h2 id='$namematches[1]'>$title</$h2>";
    }
}









// Or, replace brackets in kirbytags with parenthesis
// https://forum.getkirby.com/t/way-to-use-parenthesis-inside-kirbytag/861/4
/*
kirbytext::$post[] = function($kirbytext, $value) {
  $snippets = array(
    '[' => '(',
    ']' => ')',
  );
  $keys     = array_keys($snippets);
  $values   = array_values($snippets);
  return str_replace($keys, $values, $value);
};
*/