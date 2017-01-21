<?php

//==================================================
// PAGE DATA METHODS
// https://makernetwork.org/docs#page-data
//==================================================

//--------------------------------------------------
// DateData Methods
//--------------------------------------------------

// Date Created
// returns the date a page was first created
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

// Date Modified
// returns the most recent date the page was modified
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

// Modified By
// returns the username who last modified the page
page::$methods['modifiedBy'] = function($page) {
  if ($page->content()->datedata() != '') {
    if (isset(str::split(str::split($page->content()->datedata(),',')[1],'==')[1])) {
      return str::split(str::split($page->content()->datedata(),',')[1],'==')[1];
    }
  }
};

// Date Published
// returns the date the page was first made non-private
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

// Start Date
// returns the start day and time of an event
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

// End Date
// returns the end day and time of an event
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

//--------------------------------------------------
// UserData Methods
//--------------------------------------------------

// Authors
// returns an array of active author usernames (with roles separated by ~)
page::$methods['authors'] = function($page) {
  if ($page->content()->makers() != '') {
    return $page->content()->makers()->split(',');
  }
  elseif ($page->content()->userdata() != '') {
    if (isset(explode('///',$page->content()->userdata())[0])) {
      return str::split(explode('///',$page->content()->userdata())[0],',');
    }
  }
  else {
    return array();
  }
};

// Old Authors
// returns an array of old/retired author usernames (with roles separated by ~)
page::$methods['oldauthors'] = function($page) {
  if ($page->content()->userdata() != '') {
    if (isset(explode('///',$page->content()->userdata())[1])) {
      return str::split(explode('///',$page->content()->userdata())[1],',');
    }
  }
};

// Subscribers
// returns an array of subscribed usernames
page::$methods['subscribers'] = function($page) {
  if ($page->content()->userdata() != '') {
    if (isset(explode('///',$page->content()->userdata())[2])) {
      return str::split(explode('///',$page->content()->userdata())[2],',');
    }
  }
};

// Subscriber Emails
// returns an array of subscribed (non-user) email addresses
page::$methods['subscriberEmails'] = function($page) {
  if ($page->content()->userdata() != '') {
    if (isset(explode('///',$page->content()->userdata())[3])) {
      return str::split(explode('///',$page->content()->userdata())[3],',');
    }
  }
};

// Event Registrants
// returns an array of event registrants
page::$methods['registrants'] = function($page) {
  if ($page->content()->userdata() != '') {
    if (isset(explode('///',$page->content()->userdata())[4])) {
      return str::split(explode('///',$page->content()->userdata())[4],',');
    }
  }
};

// Event Attendees
// returns an array of event attendees
page::$methods['attendees'] = function($page) {
  if ($page->content()->userdata() != '') {
    if (isset(explode('///',$page->content()->userdata())[5])) {
      return str::split(explode('///',$page->content()->userdata())[5],',');
    }
  }
};

// Membership Requests
// returns an array of usernames who've asked to join an event/group
page::$methods['requests'] = function($page) {
  if ($page->content()->userdata() != '') {
    if (isset(explode('///',$page->content()->userdata())[6])) {
      return str::split(explode('///',$page->content()->userdata())[6],',');
    }
  }
};

//--------------------------------------------------
// RelData Methods
//--------------------------------------------------

// Related "internal" pages
// returns an array of all related "internal" pages
page::$methods['related'] = function($page) {
  if ($page->content()->makers() != '') {
    return $page->content()->makers()->split(',');
  }
  elseif ($page->content()->reldata() != '') {
    if (isset(explode('///',$page->content()->reldata())[0])) {
      return str::split(explode('///',$page->content()->reldata())[0],',');
    } else {
      return array();
    }
  } else {
    return array();
  }
};

// Related Groups
// returns an array of related "group" pages only
page::$methods['relatedGroups'] = function($page) {
  
  //$collection = array();
  $collection = new Pages();
  
  if ($page->content()->makers() != '') {
    foreach ($page->makers()->split(',') as $item) {
      if ($apage = site()->page('groups/' . $item)) {
        //$collection[] = $apage; // this makes it return a pages collection
        //$collection[] = $apage; // this makes it return an array of page strings
        $collection->add($apage);
      }
    }
    return $collection;
  }
  
  elseif ($page->content()->reldata() != '') {
    if (isset(explode('///',$page->content()->reldata())[0])) {
      $related = str::split(explode('///',$page->content()->reldata())[0],',');
      foreach ($related as $item) {
        if ($apage = site()->page('courses/' . $item)) {
          //$collection[] = $apage; // this makes it return a pages collection
          //$collection[] = $apage; // this makes it return an array of page strings
          $collection->add($apage);
        }
        if ($apage = site()->page('courses/' . $item)) {
          $collection->add($apage);
        }
      }
      if (!is_null($collection)) {
        return null;
      } else {
        return $collection;;
      }
    }
  }
  
  else {
    return null;
  }

};

// Related Projects
// returns an array of related "project" pages only
page::$methods['relatedProjects'] = function($page) {
  
  $collection = array();
  
  if ($page->content()->makers() != '') {
    foreach ($page->makers()->split(',') as $item) {
      if ($apage = site()->page('projects/' . $item)) {
        //$collection[] = $apage; // this makes it return a pages collection
        $collection[] = $apage;   // this makes it return an array of page strings
      }
    }
    return $collection;
  }
  
  elseif ($page->content()->reldata() != '') {
    if (isset(explode('///',$page->content()->reldata())[0])) {
      $related = str::split(explode('///',$page->content()->reldata())[0],',');
      foreach ($related as $item) {
        if ($apage = site()->page('projects/' . $item)) {
          //$collection[] = $apage; // this makes it return a pages collection
          $collection[] = $apage;   // this makes it return an array of page strings
        }
      }
      return $collection;
    }
  }

};

// "External" links
// returns an array of titled external links
page::$methods['links'] = function($page) {
  if ($page->content()->links() != null and $page->content()->links() != '') {
    return $page->content()->links()->split(',');
  }
  elseif ($page->content()->reldata() != null and $page->content()->reldata() != '') {
    if (isset(explode('///',$page->content()->reldata())[1])) {
      return str::split(explode('///',$page->content()->reldata())[1],',');
    }
  }
};

// Tags
// returns an array of tags
page::$methods['tags'] = function($page) {
  if ($page->content()->reldata() != null and $page->content()->reldata() != '') {
    if (isset(explode('///',$page->content()->reldata())[2])) {
      return str::split(explode('///',$page->content()->reldata())[2],',');
    }
  }
};

// Likes
// returns an array of usernames who "liked" the page
page::$methods['likes'] = function($page) {
  if ($page->content()->reldata() != null and $page->content()->reldata() != '') {
    if (isset(explode('///',$page->content()->reldata())[3])) {
      return str::split(explode('///',$page->content()->reldata())[3],',');
    }
  }
};

// Votes
// returns an array of usernames who voted for the page
page::$methods['votes'] = function($page) {
  if ($page->content()->reldata() != null and $page->content()->reldata() != '') {
    if (isset(explode('///',$page->content()->reldata())[4])) {
      return str::split(explode('///',$page->content()->reldata())[4],',');
    }
  }
};

//--------------------------------------------------
// Settings Methods
//--------------------------------------------------

// Visibility
// returns the page's visibility
page::$methods['visibility'] = function($page) {
  if ($page->content()->visibility() != '') {
    return $page->content()->visibility();
  }
  elseif ($page->content()->settings() != '') {
    if (isset(explode(',',$page->content()->settings())[0])) {
      return trim(explode(',',$page->content()->settings())[0]);
    }
  }
};

// Color
// returns the page's color
page::$methods['color'] = function($page) {
  if ($page->content()->color() != '') {
    return $page->content()->color();
  }
  elseif ($page->content()->settings() != '') {
    if (isset(explode(',',$page->content()->settings())[1])) {
      return trim(explode(',',$page->content()->settings())[1]);
    }
  }
};

// Comments
// returns the page's comments
page::$methods['comments'] = function($page) {
  if ($page->content()->settings() != '') {
    if (isset(str::split($page->content()->settings(),',')[2])) {                           // check if comments setting is present
      if (isset(str::split(str::split($page->content()->settings(),',')[2],'==')[1])) {     // check if comments setting is set
        if (str::split(str::split($page->content()->settings(),',')[2],'==')[1] != 'off') { // check if comments are not off
          return str::split(str::split($page->content()->settings(),',')[2],'==')[1];       // return "on" or whatever it is
          // Eventually return an array of the actual comment objects themselves
        }
      }
    }
  }
};

// Submissions
// returns the page's submissions
page::$methods['submissions'] = function($page) {
  if ($page->content()->settings() != '') {
    if (isset(str::split($page->content()->settings(),',')[3])) {                           // check if submissions setting is present
      if (isset(str::split(str::split($page->content()->settings(),',')[3],'==')[1])) {     // check if submissions setting is set
        if (str::split(str::split($page->content()->settings(),',')[3],'==')[1] != 'off') { // check if submissions are not off
          return str::split(str::split($page->content()->settings(),',')[3],'==')[1];       // return "on" or whatever it is
          // Eventually return an array of the actual submission objects themselves
        }
      }
    }
  }
};

// Price
// returns the event/page's price
page::$methods['price'] = function($page) {
  if ($page->content()->settings() != '') {
    if (isset(str::split($page->content()->settings(),',')[4])) {                           // check if price setting is present
      if (isset(str::split(str::split($page->content()->settings(),',')[4],'=')[1])) {      // check if price setting is set
        if (str::split(str::split($page->content()->settings(),',')[4],'=')[1] != 'off') {  // check if price is not off
          return str::split(str::split($page->content()->settings(),',')[4],'=')[1];        // return the price
        }
      }
    }
  }
};

// Price Description
// returns the event/page's price for item description
page::$methods['priceDescription'] = function($page) {
  if ($page->content()->settings() != '') {
    if (isset(str::split($page->content()->settings(),',')[4])) {                           // check if price setting is present
      if (isset(str::split(str::split($page->content()->settings(),',')[4],'=')[2])) {      // check if price setting is set
        if (str::split(str::split($page->content()->settings(),',')[4],'=')[2] != null) {   // check if price is not off
          return str::split(str::split($page->content()->settings(),',')[4],'=')[2];        // return the price
        }
      }
    }
  }
};

// Equipment Status
// returns the event/page's price
page::$methods['price'] = function($page) {
  if ($page->content()->settings() != '') {
    if (isset(str::split($page->content()->settings(),',')[4])) {                           // check if price setting is present
      if (isset(str::split(str::split($page->content()->settings(),',')[4],'==')[1])) {     // check if price setting is set
        if (str::split(str::split($page->content()->settings(),',')[4],'==')[1] != 'off') { // check if price is not off
          return str::split(str::split($page->content()->settings(),',')[4],'==')[1];       // return the price
        }
      }
    }
  }
};

//--------------------------------------------------
// Hero Methods
//--------------------------------------------------

// Hero image
// returns the hero image (or first image) of a page
page::$methods['heroImage'] = function($page) {

  if ($hero = $page->images()->findBy('name', 'hero')) {
    return $hero;
  } elseif ($page->hasImages()) {
    return $page->images()->sortBy('sort', 'asc')->first();
  } else {
    return null;
  }
  
};

//==================================================
// USER DATA METHODS
// https://makernetwork.org/docs#user-data
//==================================================

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

//--------------------------------------------------
// Permissions
//--------------------------------------------------

page::$methods['isVisibleToUser'] = function($page) {
  //if (array_intersect(array('unlisted'),$page->visibility()->split(','))) {
  if ($page->visibility() == 'unlisted') {
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


page::$methods['groups'] = function($user) {
  if ($user->content()->groupsd() != '') {
    return array('hello');
  } else {
    return array();
  }
};

function isVisibleToUser($page) {
  $isvisible = true;
  if ($page->visibility() != null) { // the page has a visibility setting
    
    if (!site()->user() and in_array($page->visibility(), array('unlisted','groups','private'))) { // hide pages with these settings from the public
      $isvisible = false;
    }
    
    if (site()->user()) { // hide these pages from logged-in users who don't have the right permissions
      if (in_array($page->visibility(), array('public'))) {
        $isvisible = true;
      }
      elseif (!in_array(site()->user(), $page->authors())) {
        if (!array_intersect(str::split(site()->user()->groups()), $page->relatedGroups()->toArray())) {
          $isvisible = false;
        }
      }
    }
    
    if (site()->user() and site()->user()->usertype() and site()->user()->usertype() == 'admin') { // show every page to admins
      $isvisible = true;
    }
  }
  return $isvisible;
}

function isEditableByUser($page) {
  $isEditable = true;
  if (!site()->user()) { // if not logged in
    $isEditable = false;
  }
  if (site()->user()) { // if logged in
    if (!in_array(site()->user(), $page->authors())) {
      $isEditable = false;
    }
  }
  if (site()->user() and site()->user()->usertype() and site()->user()->usertype() == 'admin') { // if user is an admin
    $isEditable = true;
  }
  return $isEditable;
}













/* Remote Image Downloader
  - stores a remote image locally and returns the image's URL
  - cannot return the image object because an error occurs, the image is not readable yet
*/
function downloadedImageURL($filename, $remoteURL) {
  if (!page()->image($filename . '.jpg')) {
    if ($remoteURL == 'youtube') {
      $youtubeid = substr(strstr($filename, '-'), 1);
      $remoteURL = youtube_image($youtubeid);
      $imagepath = kirby()->roots()->content() . '/' . page()->diruri() . '/' . $filename . '.jpg';
    }
    copy($remoteURL, $imagepath);
  }
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