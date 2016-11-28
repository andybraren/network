<?php
  
// Link Tag
// created by Andy Braren
// A kirbytag that displays nicely-formatted links to internal (and eventually external) pages

/* CHANGELOG
2016-11-15 - Initial creation. Focused on internal links, grabbing hero image, date, author, excerpt, title
*/

// link tag
kirbytext::$tags['link'] = array(
  'attr' => array(
    'title',
    'author',
    'date',
    'excerpt',
  ),
  'html' => function($tag) {
    
    $url       = $tag->attr('link');
    $title     = $tag->attr('title');
    $author    = $tag->attr('author');
    $date      = $tag->attr('date');
    $excerpt   = $tag->attr('excerpt');
    
    $link = url($url);
    
    if(empty($excerpt)) {
      $title = $url;
    } 
    
    if(str::isURL($excerpt)) {
      $excerpt = url::short($excerpt);
    }
    
    $author = '';
    $date = '';
    $excerpt = '';
    $host = '';
    $image = '';
    
    if ($_SERVER['SERVER_NAME'] == parse_url($url, PHP_URL_HOST)) { // if the URL is an internal link
      
      $page = site()->page(trim(parse_url($url, PHP_URL_PATH), '/'));
      
      $title = $page->title();
      $excerpt = preg_replace("!(?=[^\]])\([a-z0-9_-]+:.*?\)!is", "", html::decode(markdown(preg_replace("/(#+)(.*)/", "", $page->text()->short(300)))));
      
      $date = date('M j Y', strtotime($page->datePublished()));
      
      $host = $_SERVER['SERVER_NAME'];
      
      $image = '<div>' . $page->heroImage()->crop(150) . '</div>';
      
      $author = a::first($page->authors()); // Get the first (primary) author of a page
      $author = str::split($author,'~')[0]; // Strip out the author's role (if needed)
      if (site()->user($author)) {
        $author = site()->user($author);
        $author = $author->firstname() . ' ' . $author->lastname();
      }
    } else {
      
      //$title = get_title("http://www.washingtontimes.com/");
      
    }
    
    
    $html = '<div><a class="link" href="' . $url . '"><div><strong>' . $title . '</strong><span>' . $excerpt . '</span><span>' . $author . ' - ' . $host . ' - ' . $date . '</span></div>' . $image . '</a></div>';
    
    
    
    return $html;
    
    /*
    return html::a($link, $excerpt, array(
      'rel'    => $tag->attr('rel'),
      'class'  => $tag->attr('class'),
    ));
    */
    
  }
);

function domain($url) {
  $result = parse_url($url);
  return $result['scheme']."://".$result['host'];
}

function get_title($url){
  $str = file_get_contents($url);
  if(strlen($str)>0){
    $str = trim(preg_replace('/\s+/', ' ', $str)); // supports line breaks inside <title>
    preg_match("/\<title\>(.*)\<\/title\>/i",$str,$title); // ignore case
    return $title[1];
  }
}

?>