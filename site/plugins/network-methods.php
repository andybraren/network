<?php












/* DateData page method extensions
  - Allows sortBy() to work with subfields within DateData
  - Also allows $page->dateCreated() to be echoed
  - Handles old pages that include "created" fields, and new pages with the condensed DateData format
*/
page::$methods['dateCreated'] = function($page) {
  if ($page->content()->created() != '') {
    return $page->content()->created();
  }
  elseif ($page->content()->datedata() != '') {
    if (isset(str::split($page->content()->datedata(),',')[0])) {
      return str::split($page->content()->datedata(),',')[0];
    }
  }
};
page::$methods['dateModified'] = function($page) {
  if ($page->content()->modified() != '') {
    return $page->content()->modified();
  }
  elseif ($page->content()->datedata() != '') {
    if (isset(str::split(str::split($page->content()->datedata(),',')[1],'==')[0])) {
      return str::split(str::split($page->content()->datedata(),',')[1],'==')[0];
    }
  }
};
page::$methods['datePublished'] = function($page) {
  if ($page->content()->datedata() == '') {
    return $page->content()->created();
  }
  elseif ($page->content()->datedata() != '') {
    if (isset(str::split($page->content()->datedata(),',')[2])) {
      return str::split($page->content()->datedata(),',')[2];
    } elseif (isset(str::split($page->content()->datedata(),',')[0])) {
      return str::split($page->content()->datedata(),',')[0];
    }
  }
};
page::$methods['dateStart'] = function($page) {
  if ($page->content()->startdate() != '') {
    return $page->content()->startdate();
  }
  elseif ($page->content()->datedata() != '') {
    if (isset(str::split($page->content()->datedata(),',')[3])) {
      return str::split($page->content()->datedata(),',')[3];
    }
  }
};
page::$methods['dateEnd'] = function($page) {
  if ($page->content()->enddate() != '') {
    return $page->content()->enddate();
  }
  elseif ($page->content()->datedata() != '') {
    if (isset(str::split($page->content()->datedata(),',')[4])) {
      return str::split($page->content()->datedata(),',')[4];
    }
  }
};

/* UserData page method extensions
  - Allows sortBy() to work with subfields within UserData
  - Also allows $page->dateCreated() to be echoed
  - Handles old pages that include "created" fields, and new pages with the condensed DateData format
*/
page::$methods['authors'] = function($page) {
  if ($page->content()->makers() != '') {
    return $page->content()->makers()->split(',');
  }
  elseif ($page->content()->userdata() != '') {
    if (isset(str::split($page->content()->userdata(),'///')[0])) {
      return str::split(str::split($page->content()->userdata(),'///')[0],',');
    }
  }
};

page::$methods['oldauthors'] = function($page) {
  if ($page->content()->userdata() != '') {
    if (isset(str::split($page->content()->userdata(),'///')[1])) {
      return str::split(str::split($page->content()->userdata(),'///')[1],',');
    }
  }
};

page::$methods['groups'] = function($page) {
  
  $grouppages = array();
  
  if ($page->content()->makers() != '') {
    foreach ($page->makers()->split(',') as $item) {
      if ($grouppage = site()->page('groups/' . $item)) {
        //$grouppages[] = $grouppage; // this makes it return a pages collection
        $grouppages[] = $item;        // this makes it return an array of group strings
      }
    }
    return $grouppages;
  }
  
  elseif ($page->content()->reldata() != '') {
    if (isset(str::split($page->content()->reldata(),'///')[0])) {
      $related = str::split(str::split($page->content()->reldata(),'///')[0],',');
      foreach ($related as $item) {
        if ($grouppage = site()->page('groups/' . $item)) {
          //$grouppages[] = $grouppage; // this makes it return a pages collection
          $grouppages[] = $item;        // this makes it return an array of group strings
        }
      }
      return $grouppages; // As page collection
    }
  }

};


/* RelData page method extensions
  - related internal pages, external pages, tags, likes, and votes
*/
page::$methods['links'] = function($page) {
  if ($page->content()->links() != null and $page->content()->links() != '') {
    return $page->content()->links()->split(',');
  }
  elseif ($page->content()->reldata() != null and $page->content()->reldata() != '') {
    if (isset(str::split($page->content()->reldata(),'///')[1])) {
      return str::split(str::split($page->content()->reldata(),'///')[1],',');
    }
  }
};

page::$methods['related'] = function($page) {
  if ($page->content()->makers() != '') {
    return $page->content()->makers()->split(',');
  }
  elseif ($page->content()->reldata() != '') {
    if (isset(str::split($page->content()->reldata(),'///')[0])) {
      return str::split(str::split($page->content()->reldata(),'///')[0],',');
    }
  }
};


page::$methods['relatedEquipmssssent'] = function($page) {
  
  $relatedpages = array();
  

  
  if ($page->content()->makers() != '') {
    foreach ($page->makers()->split(',') as $item) {
      if ($relatedpage = site()->page('equipment/' . $item)) {
        $relatedpages[] = $relatedpage; // this makes it return a pages collection
        //$grouppages[] = $item;        // this makes it return an array of group strings
      }
    }
    return $relatedpages;
  }
  
  elseif ($page->content()->reldata() != '') {
    if (isset(str::split($page->content()->reldata(),'///')[0])) {
      $related = str::split(str::split($page->content()->reldata(),'///')[0],',');
      foreach ($related as $item) {
        if ($relatedpage = site()->page('equipment/' . $item)) {
          $relatedpages[] = $relatedpage; // this makes it return a pages collection
          //$grouppages[] = $item;        // this makes it return an array of group strings
        }
      }
      return $relatedpages; // As page collection
    }
  }

};










page::$methods['heroImage'] = function($page) {

  if ($hero = $page->images()->findBy('name', 'hero')) {
    return $hero;
  } elseif ($page->hasImages()) {
    return $page->images()->sortBy('sort', 'asc')->first();
  } else {
    return null;
  }
  
};




































page::$methods['datedatas'] = function($page, $type) {
  
  $type = null;
  
  if ($type == 'modifiedby') {
    return str::split(str::split($page->content()->datedata(),',')[1],'==')[1];
  }
  
};


/* User Avatar image url
  - returns an avatar for the provided username
*/
function userAvatar($username, $size = 256) {
  if ($avatar = site()->user($username)->avatar()) {
    return $avatar->crop($size,$size)->url();
  } else {
    $number = 1;
    if     (strlen(site()->user($username)->firstname()) <= 3) { $number = 1; }
    elseif (strlen(site()->user($username)->firstname()) <= 4) { $number = 2; }
    elseif (strlen(site()->user($username)->firstname()) <= 6) { $number = 3; }
    elseif (strlen(site()->user($username)->firstname()) >= 7) { $number = 4; }
    $defaultavatar = new Asset('/assets/images/avatar-' . $number . '.svg');
    return $defaultavatar->url();
  }
}
function groupLogo($groupname, $size = 256) {
  if ($logo = site()->page('groups/' . $groupname)->images()->findBy('name', 'logo')) {
    return $logo->crop($size,$size)->url();
  } else {
    $number = 1;
    if     (strlen(site()->page('groups/' . $groupname)->title()) <= 3) { $number = 1; }
    elseif (strlen(site()->page('groups/' . $groupname)->title()) <= 4) { $number = 2; }
    elseif (strlen(site()->page('groups/' . $groupname)->title()) <= 6) { $number = 3; }
    elseif (strlen(site()->page('groups/' . $groupname)->title()) >= 7) { $number = 4; }
    $defaultlogo = new Asset('/assets/images/avatar-' . $number . '.svg');
    return $defaultlogo->url();
  }
}

/* User color
  - returns the user's color if set
*/
function userColor($username) {
  if (site()->user($username)->color() != "") {
    return (string)site()->user($username)->color();
  } else {
    return (string)site()->coloroptions()->split(',')[0];
  }
}
function groupColor($groupslug) {
  if (site()->page('groups/' . $groupslug)->color() != "") {
    return (string)site()->page('groups/' . $groupslug)->color();
  } else {
    return (string)site()->coloroptions()->split(',')[0];
  }
}



/* Remote Image Downloader
  - stores a remote image locally and returns the image's URL
  - cannot return the image object because an error occurs, the image is not readable yet
*/
function downloadedImageURL($filename, $remoteURL) {
  $imagepath = kirby()->roots()->content() . '/' . page()->diruri() . '/' . $filename . '.jpg';
  if (!page()->image($filename . '.jpg')) {
    if ($remoteURL == 'youtube') {
      $youtubeid = substr(strstr($filename, '-'), 1);
      $remoteURL = youtube_image($youtubeid);
    }
    copy($remoteURL, $imagepath);
  }
  // $image = page()->image($filename . '.jpg');
  $imageURL = page()->contentURL() . '/' . $filename . '.jpg';
  return $imageURL;
};

function youtube_image($id) {
  $resolution = array (
    'maxresdefault',
    'mqdefault',
    'sddefault',
    'hqdefault',
    'default'
  );
  for ($x = 0; $x < sizeof($resolution); $x++) {
    $url = 'https://img.youtube.com/vi/' . $id . '/' . $resolution[$x] . '.jpg';
    if (get_headers($url)[0] == 'HTTP/1.0 200 OK') {
      break;
    }
  }
  return $url;
}

page::$methods['isVisibleToUser'] = function($page) {
  if (array_intersect(array('unlisted'),$page->visibility()->split(','))) {
    return true;
  } else {
    return isVisibleToUser($page);
  }
};

page::$methods['isEditableByUser'] = function($page) {
  if (!site()->user()) {
    return false;
  } else {
    return isEditableByUser($page);
  }
};

pages::$methods['visibleToUser'] = function($pages) {  
  $collection = new Pages();
  foreach($pages as $page) {
    if (isVisibleToUser($page)) {
      $collection->add($page);
    }
  }
  return $collection;
};



function isVisibleToUser($page) {
  $isvisible = true;
  if (!site()->user() and $page->content()->visibility()->isNotEmpty()) { // if not logged in and has visibility setting
    if (!array_intersect(array('public'),$page->visibility()->split(','))) {
      $isvisible = false;
    }
  }
  if (site()->user() and $page->content()->visibility()->isNotEmpty()) { // if logged in and has visibility setting
    if (array_intersect(array('public'),$page->visibility()->split(','))) {
      $isvisible = true;
    }
    elseif (in_array(site()->user(), str::split($page->makers() . ',' . $page->visibility(),','))) {
      $isvisible = true;
    }
    elseif (array_intersect(str::split(site()->user()->groups(),','), str::split($page->makers() . ',' . $page->visibility(),','))) {
      $isvisible = true;
    } else {
      $isvisible = false;
    }
  }
  if (site()->user() and site()->user()->usertype() and site()->user()->usertype() == 'admin') { // if user is an admin
    $isvisible = true;
  }
  return $isvisible;
}

function isEditableByUser($page) {
  $isEditable = true;
  if (!site()->user()) { // if not logged in
    $isEditable = false;
  }
  if (site()->user()) { // if logged in
    if (in_array(site()->user(), str::split($page->makers(),','))) {
      $isEditable = true;
    } else {
      $isEditable = false;
    }
  }
  if (site()->user() and $page->slug() == 'projects') {
    $isEditable = true;
  }
  if (site()->user() and site()->user()->usertype() and site()->user()->usertype() == 'admin') { // if user is an admin
    $isEditable = true;
  }
  return $isEditable;
}

















/* New filterBy operator that's not case-sensitive
  - https://forum.getkirby.com/t/filterby-case-sensitive/3226/8
*/
collection::$filters['c*='] = function($collection, $field, $value, $split = false) {
  foreach($collection->data as $key => $item) {
    if($split) {
      $values = str::split((string)collection::extractValue($item, $field), $split);
      foreach($values as $val) {
        if(stripos($val, $value) === false) {
          unset($collection->$key);
          break;
        }
      }
    } else if(stripos(collection::extractValue($item, $field), $value) === false) {
      unset($collection->$key);
    }
  }
  return $collection;
};









?>