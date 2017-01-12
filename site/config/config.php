<?php

require_once __DIR__ . DS . 'private.php'; // load private information

/*

---------------------------------------
License Setup
---------------------------------------

Please add your license key, which you've received
via email after purchasing Kirby on http://getkirby.com/buy

It is not permitted to run a public website without a
valid license key. Please read the End User License Agreement
for more information: http://getkirby.com/license

*/

c::set('license', 'put your license key here');


/*

---------------------------------------
Kirby Configuration
---------------------------------------

By default you don't have to configure anything to
make Kirby work. For more fine-grained configuration
of the system, please check out http://getkirby.com/docs/advanced/options

*/

/* Looks like ini_set doesn't actually do anything here. They have to be manually set within php.ini */

/* Increase memory limit */
ini_set('memory_limit', '512M');

/* Increase max file size that a user can upload */
ini_set('upload_max_filesize', '100M');

/* Increase max amount of data that can be sent via a POST in a form */
ini_set('post_max_size', '100M');

/* Increase maximum processing time */
ini_set('max_execution_time', 60); // 60 seconds = 1 minute

// Supposedly changes folders that Kirby creates to be 775 instead of 755
// https://forum.getkirby.com/t/content-folder-permissions-on-create/2846
Dir::$defaults['permissions'] = 0775;


// Add additional classes to the guggenheim gallery element
// c::set('guggenheim.classes', 'gallery zoom margin-center');

// Guggenheim is meant to be used with PhotoSwipe
// But if you for some reason don't want to use it, you can remove it additionals with
c::set('guggenheim.photoswipe', true);

// Guggenheim uses some basic srcset and sizes for basic responsiveness and highres support
// if you want to disable it, and make your own
c::set('guggenheim.srcset', false);
//c::set('guggenheim.width', '700');
c::set('guggenheim.width', '720');
c::set('guggenheim.height', '200');

/* Turn on Kirby's cachebuster */
c::set('cachebuster', true);



/* Turn on caching */

if($_SERVER['SERVER_NAME'] != 'makernetwork.org') {
}
c::set('cache', false);
c::set('cache.ignore', array('sitemap'));


/* Turn on GD Lib's image orientation detection. This fixed iOS image rotation issues.
  - https://getkirby.com/docs/developer-guide/configuration/thumbnails
*/
thumb::$defaults['autoOrient'] = 'true';

// Change the sirvy plugin's path
// http://maker.tufts.edu/api/projects?service=json
c::set('sirvy.path', 'api');

/* Turn on debugging */
if($_SERVER['SERVER_NAME'] == 'makernetwork.org') {
  c::set('debug', true);
}

/* Set the timezone */
c::set('timezone','America/New_York');

/* Increase login session duration
   https://forum.getkirby.com/t/login-session-lifetime-extending-for-the-frontend/2922
*/
s::$timeout = 60*24*30; // 1 month of session validity
s::$cookie['lifetime'] = 43000; // expires in 1 month

//cookie::set('kirby_session_auth', $value, $lifetime = 42000, '/blah', $domain = null);
/*
Not including the above makes both kirby_session and kirby_session_auth have an expires of Session
Including them makes it longer - to 2017 or whatever

Eventually the site logs out anyway, but leaves both the kirby_session and kirby_session_auth cookies intact. I'm not sure what the duration is.
If I log out manually, then kirby_session_auth gets destroyed.

*/




// Override carriage returns between fields when using $page->update()
// https://forum.getkirby.com/t/remove-extra-carriage-returns-between-fields-after-using-page-update/5195
data::$adapters['kd']['encode'] = function($data) {

  $result = array();
  foreach($data AS $key => $value) {
    $key = str::ucfirst(str::slug($key));

    if(empty($key) || is_null($value)) continue;

    // avoid problems with arrays
    if(is_array($value)) {
      $value = '';
    }

    // escape accidental dividers within a field
    $value = preg_replace('!(\n|^)----(.*?\R*)!', "$1\\----$2", $value);

    // multi-line content
    if(preg_match('!\R!', $value, $matches)) {
      $result[$key] = $key . ": \n\n" . trim($value);
    // single-line content
    } else {
      $result[$key] = $key . ': ' . trim($value);        
    }

  }
  return implode("\n----\n", $result);

};



c::set('routes', array(
  
  // On non-public pages, display the standard error page if the visitor isn't logged in and/or hasn't been given permission
  // https://forum.getkirby.com/t/return-error-page-if-field-value-is-something/3894
  
  // ROBOTS.TXT FILE
  array(
    'pattern' => 'robots.txt',
    'action'  => function() {
      echo '<pre style="word-wrap: break-word; white-space: pre-wrap;">';
      if($_SERVER['SERVER_NAME'] != 'drewbaren.com' and $_SERVER['SERVER_NAME'] != 'tuftsmake.com' and $_SERVER['SERVER_NAME'] != 'makernetwork.org') {
        echo 'User-agent: *<br>Disallow: /thumbs/<br>Disallow: /makers<br>Disallow: /drafts/<br>Sitemap: ' . site()->url() . '/sitemap';
        foreach (site()->index()->filterBy('visibility','unlisted') as $hiddenpage) {
          echo '<br>Disallow: /' . $hiddenpage->uri();
        }
      } else {
        echo 'User-agent: *<br>Disallow: /';
        foreach (site()->index()->filterBy('visibility','unlisted') as $hiddenpage) {
          echo '<br>Disallow: /' . $hiddenpage->uri();
        }
      }
      echo '</pre>';
    }
  ),
  
  // LOGIN
  array(
		'pattern' => array('login', '(.+login)'), // matches any url ending in login
    'method' => 'POST',
    'action'  => function() {
      $currentpath = str_replace(array('/maker/','/ne/','/login','login','/forgot','forgot'),'',$_SERVER['REQUEST_URI']);
      if($user = site()->user(get('username')) and $user->login(get('password'))) {
        //s::$timeout = 120;
        //s::set($timeout, $value = 120);
        //s::$cookie['lifetime'] = 0;
        //s::set($cookie, $value = 0);
        //cookie::set('kirby_session_auth', '', $lifetime = 55, $path = '/', $domain = null);
        //cookie::set('kirby_session_auth', $value, $lifetime = 42000, $path = '/', $domain = null, $secure = true, $httpOnly = true);
        //c::set('panel.session.timeout', 2160); // 36 hours
        //cookie::set('username', site()->user()->username(), $expires = 42000, $path = '/', $domain = null, $secure = true);
        return go($currentpath);
      } elseif ($user = site()->users()->findBy('email', get('username')) and $user->login(get('password'))){
        return go($currentpath);
      } else {        
        return go($currentpath . '/login:failed');
      }
    }
  ),
  
  // LOGOUT
  array(
		'pattern' => array('logout', '(.+logout)'), // matches any url ending in logout
    'action'  => function() {
      if($user = site()->user()) {
        $user->logout();
      }
      $currentpath = str_replace(array('/maker/','/ne/','/logout','logout'),'',$_SERVER['REQUEST_URI']);
      return go($currentpath);
    }
  ),

  array(
		'pattern' => array('signup', '(.+signup)'), // matches any url ending in signup
		'method' => 'POST',
    'action'  => function() {
      
      $site = site();

      // redirect logged in users to the homepage
      if($site->user()) go('/');
    
      // handle the signup form submission
      if(r::is('post') and get('signup')) {
        
        // check if the username already exists, and if not, run the signup method
        if(!$site->user(get('username'))) {
          
          // create the new user.php file
        	try {
    			  $user = $site->users()->create(array(
    			    'username'  => get('username'),
    				  'firstname' => get('firstname'),
    			    'lastname'  => get('lastname'),
    			    'email'     => strtolower(get('email')),
    			    'tuftsemail'=> strtolower(get('tuftsemail')),
    			    'password'  => get('password'),
    			    'resetkey'  => '',
    			    'resetdate' => '',
    			    'language'  => 'en',
    			    'usertype'  => 'user',
    			    'registrationdate' => date('Y-m-d H:i:s'),
    			    'usegravatar' => false,
    			    'color'       => strtolower(get('color')),
    			    'school'      => get('school'),
    			    'affiliation' => get('affiliation'),
    			    'department'  => get('dept'),
    			    'major'       => get('major'),
    			    'classyear'   => get('classyear'),
    			    'birthyear'   => get('birthyear'),
    			    'groups'      => 'me-184-robotics',
    			  ));
    			} catch(Exception $e) {
    			  $e->getMessage();
    			}
    			
    			// create the new maker profile page
    			try {
    				$firstandlast = get('firstname') . " " . get('lastname');
    			  $newPage = page('makers')->children()->create(get('username'), 'maker', array(
    			    'title' => $firstandlast,
    			    'created' => date('Y-m-d H:i:s'),
    			    'modified' => date('Y-m-d H:i:s'),
    			    'modifiedby' => get('username'),
              'makers' => get('username'),
              'visibility' => 'public',
              'color' => strtolower(get('color')),
              'hero' => '',
    			    'text'  => '',
    			  ));
    			} catch(Exception $e) {
    			  echo $e->getMessage();
    			}
          
          // send user info to the RFID database
          if($site->url() == "https://maker.tufts.edu") {
      			try {
      				$link = pg_Connect(c::get('RFIDcredentials'));
      				$uname = get('username');
      				$fname = get('firstname');
      				$lname = get('lastname');
      				$email = get('email');
      				$Temail = get('tuftsemail');
      				$dept = get('dept');
      				$C_year = get('classyear');
      				$byear = get('birthyear');
      				$Rship = get('affiliation');
      				
              $UserAdd = "INSERT INTO users(uid, uname, fname, lname, email, temail, reg_date, exp_date, dept, class, byear) 
                      VALUES (DEFAULT,'$uname','$fname','$lname','$email','$Temail',DEFAULT,DEFAULT,$dept,$C_year,$byear);";
      				$NewUser = pg_exec($link, $UserAdd);
      				
              // Create admin_log to capture new user creation
              $ip = $_SERVER['REMOTE_ADDR'];
              $log_call = "INSERT INTO Admin_log(uid, action, ip) VALUES ($uid,'Created new user through maker.tufts.edu - $uname', '$ip')";
              $admin_log = pg_exec($link, $log_call);
      				
      			} catch(Exception $e) {
      				echo 'failed to send to Database';
      			  echo $e->getMessage();
      			}
      		}
    			
    			// log the user in and redirect them to their new profile page
          try {
            $user->login(get('password'));
            go('/makers/' . get('username'));
          } catch(Exception $e) {
            $error = true;
          }
    
    		} else {
          $error = true;
          echo "Username is taken";
        }
      } else {
        $error = false;  
      }
    
      return array('error' => $error);

    }
  ),
  
  // SEND PASSWORD RESET EMAIL
  array(
    'pattern' => 'forgot',
    'method' => 'POST',
    'action'  => function() {
      if($user = site()->users()->findBy('email',strtolower(get('email')))) {
        try {
  
          // set the reset key
          $resetkey = substr(md5(rand()), 0, 50);
          $resetdate = date('Y-m-d H:i:s');
          site()->user($user->username())->update(array(
            'resetkey' => $resetkey,
            'resetdate' => $resetdate
          ));
          // echo 'Great, updated the resetkey, check your email';
          
          // send them an email
          $email = email(array(
            'service' => 'html_email',
            'to'      => $user->email(),
            'from'    => 'happyrobot@maker.tufts.edu',
            'subject' => 'Maker Network Password Reset',
            'body'    => '
              <html>
                <head>
                  <title>Maker Network Password Reset</title>
                </head>
                <body>
                  <p>Hi ' . $user->firstname() . ',</p>
                  <p>You can reset your password by opening this link. It will expire within one hour and can only be used once.</p>
                  <p>' . site()->url() . '/username:' . $user->username() . '/resetkey:' . $resetkey . '/</p>
                  <p>- Maker Network Email Robot</p>
                </body>
              </html>
            '
          ));
          
          if($email->send()) {
            $currentpath = str_replace(array('/maker/','/ne/','/login','login','/forgot','forgot'),'',$_SERVER['REQUEST_URI']);
            return go($currentpath . 'forgot:success');
          } else {
            echo $email->error();
            return go($currentpath . 'forgot:failed');
          }
        	
        } catch(Exception $e) {
          echo $e->getMessage();
        }
  
      } else {
        $error = true;
        //echo "Nope, that user does not exist";
        return go($currentpath . 'forgot:failed');
      }
    }
  ),
  
  // RESET PASSWORDS
  array(
    'pattern' => 'reset',
    'method' => 'POST',
    'action'  => function() {
      
      // compare to the key to the one stored in the login txt file
      // if they match and the purge date is not reached, reset the user's password
      // delete the key in the login txt file
  
      $username  = get('username');
      $key = get('resetkey');
      $newpassword = get('newpassword');
  
      if($user = site()->users()->findBy('username', $username)) {
      	if($user->resetkey() == $key) {                                      // If the keys match...
      		if(strtotime($user->resetdate()) > (time() - 86400)) {               // And if the time period is right
  	        site()->user($user->username())->update(array(                   // Then reset the password and wipe the key
  	        	'resetkey' => null,
  	        	'resetdate' => null,
  	          'password' => $newpassword,
  	        ));
            if($user = site()->user($username) and $user->login(get('newpassword'))) { // And log them in for convenience
              return go(site()->url().'/reset:success');
            } else {
              return go(site()->url().'/reset:failed');
            }
      		}
      		else {
  		      $error = true;
  		      echo "Sorry, this link seems to have expired. Submit a new password reset request. Error 1";
      		}
      	}
      	else {
  	      $error = true;
  	      echo "Sorry, this link seems to have expired. Submit a new password reset request. Error 2";
      	}
      }
      else {
        $error = true;
        echo "Sorry, something weird seems to be going on. Email the web admin, andybraren. Error 3";
      }
    }
  ),


  // New page creation at temp location
  array(
		'pattern' => array('new', '(.+new)'), // matches any url ending in new
    'action'  => function() {
      $currentpath = str_replace(array('/maker/','/new','/'),'',$_SERVER['REQUEST_URI']);
      $newpage = date('His');
      try {
        //page()->create($newpage, 'project', array(
        page()->create('projects/' . $newpage, 'project', array(
          'title' => 'New project title',
          'created'  => date('Y-m-d H:i:s'),
          'modified' => date('Y-m-d H:i:s'),
          'modifiedby' => site()->user()->username(),
          'makers' => site()->user()->username() . ', me-184-robotics',
          'visibility' => 'public',
          'color' => '',
          'hero' => '',
          'text' => ''
        ));
        return go($currentpath . '/' . $newpage);
      } catch(Exception $e) {
        return page('error');
      }
    }
  ),
  array(
    //'pattern' => array('new', '(:any)/new/(:any)'),
    'pattern' => array('(:num)', '(:any)/new/(:num)'),
    'action'  => function() {
      $url = $_SERVER['REQUEST_URI'];
      return page('new/' . basename($url));
    }
  ),
	
  // SAVE PAGES
	array(
		'pattern' => array('save', '(.+save)'), // matches any url ending in save
		'method' => 'POST',
		'action'  => function() {
  		
  		$targetpage = site()->page($_POST['page']);
  		$originaltitle = $targetpage->title();
  		
  		$title = (isset($_POST['title'])) ? $_POST['title'] : $targetpage->title();
  		$text  = (isset($_POST['text'])) ? $_POST['text'] : $targetpage->text();
  		
  		/* DateData */
  		$dateCreated = $targetpage->dateCreated();
  		$dateModified  = date('Y-m-d H:i:s');
  		//$modifiedBy = site()->user(get('username'));
  		
  		/* UserData */
  		$authors = (isset($_POST['authors'])) ? $_POST['authors'] : implode(', ', $targetpage->authors());
  		$oldauthors = '';
  		$subscribers = '';
  		$subscriberEmails = '';
  		$registrants = '';
  		$attendees = '';
  		
  		// Existing requests
  		$requests = (isset($_POST['requests'])) ? $_POST['requests'] : implode(', ', $targetpage->requests());
  		  $requests = (isset($_POST['join'])) ? implode(', ', array_merge($targetpage->requests(), array($_POST['join']))) : $requests;
  		
  		/* RelData */
  		$relatedGroups = (isset($_POST['groups'])) ? $_POST['groups'] : $targetpage->groups();
  		
  		/* Settings */
  		$visibility  = (isset($_POST['visibility'])) ? $_POST['visibility'] : $targetpage->visibility();
  		$color  = (isset($_POST['color'])) ? $_POST['color'] : $targetpage->color();
  		$comments = 'off';
  		$submissions = 'off';
  		$price = 'off';
  		
      try {
        site()->page($targetpage)->update(array(
          'Title'  => $title,
          'DateData' => $dateCreated . ', ' . $dateModified,
          'UserData' => $authors . ' /// ' . $oldauthors . ' /// ' . $subscribers . ' /// ' . $subscriberEmails . ' /// ' . $registrants . ' /// ' . $attendees . ' /// ' . $requests,
          'RelData' => $relatedGroups,
          'Settings' => $visibility . ', ' . $color . ', comments == ' . $comments . ', submissions == ' . $submissions . ', price == ' . $price,
          'Hero' => '',
          'Text'  => $text,
        ));
        //echo var_dump($_POST);

        if ($title != $originaltitle) {
          $currentlocation = kirby()->roots()->content() . '/' . $targetpage->diruri();
          $newlocation = kirby()->roots()->content() . '/' . $targetpage->parent()->diruri() . '/' . str::slug($title);
          rename($currentlocation, $newlocation);
          
          $redirecturl = site()->url() . '/' . $targetpage->parent()->diruri() . '/' . str::slug($title);
          
          $response = array('redirecturl' => $redirecturl); // redirect to new url
          echo json_encode($response);
        }
        
      } catch(Exception $e) {
        echo $e->getMessage();
      }
          
		}
	),
	
  // DELETE PAGES
	array(
		'pattern' => array('delete', '(.+delete)'), // matches any url ending in save
		'method' => 'POST',
		'action'  => function() {
  		
  		$targetpage = site()->page($_POST['page']);
  		$redirecturl = site()->url() . '/' . $targetpage->parent()->diruri();
  		
      try {
        
        $targetpage->delete();
        
        $response = array('redirecturl' => $redirecturl);
        echo json_encode($response);
        
      } catch(Exception $e) {
        echo $e->getMessage();
      }
          
		}
	),
	
	
  // UPLOAD
	array(
		'pattern' => array('uploadnew', '(.+uploadnew)'),
		'method' => 'POST',
		'action'  => function() {
  		
  		$targetpage = site()->page($_POST['page']);
  		$files = (isset($_FILES['file']['name'])) ? $_FILES['file']['name'] : '';
  		
      $target_dir = kirby()->roots()->content() . '/' . $targetpage->uri() . '/';
      $filename = pathinfo($_FILES['files']['name'],PATHINFO_FILENAME);
      
      $extension = strtolower(pathinfo($_FILES['files']['name'], PATHINFO_EXTENSION));
      
      $fileurl = $targetpage->url() . '/' . $filename . '.' . $extension;
      $fileurl = site()->contentURL() . '/' . $targetpage->uri() . '/' . $filename . '.' . $extension;
      
      $target_file = $target_dir . $filename . '.' . $extension;

      // Check for any old files with the same name, of any extension, and delete them
    	//$oldfiles = glob($target_dir . $filename . '.' . $extension);
    	$oldfile = $target_dir . $filename . '.' . $extension;
    	if (file_exists($oldfile)) {
      	unlink($oldfile);
    	}
    	
      // Save the file in the right place
      try {
        
        move_uploaded_file($_FILES['files']['tmp_name'], $target_file);
        
        $response = array('filename' => $filename . '.' . $extension, 'fileurl' => $fileurl, 'extension' => $extension);
        echo json_encode($response, JSON_UNESCAPED_SLASHES);
        
      } catch(Exception $e) {
        echo $e->getMessage();
      }
          
		}
	),
	



  // SAVE AVATAR OR ICON, or possibly ContentTools uploads and eventually videos and other files as well
	array(
    'pattern' => array('upload', '(.+upload)', 'makerbox'),
		'method' => 'POST',
		'action'  => function() {
      try {
        
        //print_r($_REQUEST);
        
        // All this code just to get the target uri should probably be replaced with template logic instead just to pass it along. For now I'm putting it in this statement to allow the makerbox to work, but this should be fixed elsewhere eventually
        if (empty($_POST['username'])) {
          $originurl = preg_replace('/\/[^\/]+:.+\/?$/','',$_SERVER['HTTP_REFERER']); // removes Kirby parameters like /../error:whatever/message:blah
          $originslug = basename($originurl);
          
          // need to get the page's uri path but also account for the homepage potentially not being located at /
          $scheme = parse_url($originurl, PHP_URL_SCHEME);
          $hostname = parse_url($originurl, PHP_URL_HOST);
          $baseurl = $scheme . '://' . $hostname . '/' . basename(site()->url());
          $targeturi = str_replace($baseurl,'',$originurl);
        }
        
        // gets us something like /var/www/drewbaren.com/maker/content/frontend-editing-example/
          $originurl = preg_replace('/\/[^\/]+:.+\/?$/','',$_SERVER['HTTP_REFERER']); // removes Kirby parameters like /../error:whatever/message:blah
          $originslug = basename($originurl);
          
          // need to get the page's uri path but also account for the homepage potentially not being located at /
          $scheme = parse_url($originurl, PHP_URL_SCHEME);
          $hostname = parse_url($originurl, PHP_URL_HOST);
          $baseurl = $scheme . '://' . $hostname . '/' . basename(site()->url());
          $targeturiblah = str_replace($baseurl,'',$originurl);
      
      //echo $targeturiblah;
        
        //$newnew = str_replace('https://makernetwork.org/','',$targeturiblah);
        $newnew = str_replace(site()->url() . '/','',$targeturiblah);
        
        $pathParts = explode( '/', parse_url($targeturiblah, PHP_URL_PATH) );
        $lastParts = array( array_pop($pathParts), array_pop($pathParts) );
        $targeturi = $newnew;
        
        $reload = 0;

        // Images uploaded with username data are from Makerboxes, and should go to maker profiles
        if (!empty($_POST['username'])) {
          $targeturi = '/makers/' . $_POST['username'] . '/gallery';
          $target_dir = kirby()->roots()->content() . $targeturi . '/';
          if (!file_exists($target_dir)) {
            mkdir($target_dir, 0775, true);
          }
        }
        
        // ContentTools (and makerbox) image uploads
        if (!empty($_FILES['image']['name'])) {
          $name = 'image'; // use the image's regular filename
          //$target_dir = kirby()->roots()->content() . $targeturi . '/';
          $target_dir = kirby()->roots()->content() . '/' . $targeturi . '/';
          $target_filename = pathinfo($_FILES['image']['name'],PATHINFO_FILENAME);
        }
        
        //if (!empty($_POST['hero'])) {
        if (!empty($_FILES['hero']['name'])) {
          $name = 'hero';
          //$target_dir = kirby()->roots()->content() . $targeturi . '/';
          $target_dir = kirby()->roots()->content() . '/' . $targeturi . '/';
          $target_filename = 'hero';
          site()->page($targeturi)->touch();
          $reload = 1;
        }
        //if (!empty($_POST['avatar'])) {
        if (!empty($_FILES['avatar']['name'])) {
          $name = 'avatar';
          $target_dir = kirby()->roots()->avatars() . '/';
          $target_filename = $originslug;
          $reload = 1;
        }
        
        $extension = strtolower(pathinfo($_FILES[$name]['name'], PATHINFO_EXTENSION));
        $extension = ($extension == 'jpeg' ? 'jpg' : $extension); // rename jpeg to jpg because it's nicer
        
        $target_file = $target_dir . $target_filename . '.' . $extension;
        
        $uploadOk = 1;
        
        // Check if the file is actually an image
        /*
        if(getimagesize($_FILES[$name]['tmp_name']) == false) {
          $uploadOk = 0;
          $error = "hey";
        }
        */
        
        // Allow certain file formats
        if($extension != 'jpg' && $extension != 'png' && $extension != 'jpeg' && $extension != 'gif' ) {
          $uploadOk = 0;
          $error = "heyyy" . $target_dir . "blah";
        }
        
        // See whether $uploadOk was set to 0 by one of the checks above
        if ($uploadOk == 0) {
          return go($originurl . '/error:upload1' . $error);
        } else {
          
          // Check for any old files with the same name, of any extension, and delete them
        	$oldfiles = glob($target_dir . $target_filename . ".*");
        	foreach ($oldfiles as $oldfile) {
        		unlink($oldfile);
        	}
          
          // Save the file in the right place
          if (move_uploaded_file($_FILES[$name]["tmp_name"], $target_file)) {

            /* Use GD Lib to detect image orientation and rotate if necessary
              - https://forum.getkirby.com/t/wrong-orientation-of-images-portrait-landscape-after-upload/692/19
              - https://github.com/getkirby/starterkit/blob/0b4a6e8cf929237621d77adb996e98b08d234004/kirby/toolkit/lib/thumb.php
            */
            try {
              $img = new abeautifulsite\SimpleImage($target_file);
              //echo $target_file;
              $img->auto_orient();
              @$img->save($target_file);
            } catch(Exception $e) {
              echo "Error rotating image";
            }
            
            if (empty($_POST['username'])) {
              $blah = $originurl . '/' . $target_filename . '.' . $extension;
              //echo $blah;
              $blah = str_replace(' ', '%20', $blah);
              $arr = array('size' => $_FILES["image"]["size"], 'url' => $blah, 'filename' => $target_filename . '.' . $extension);
              echo json_encode($arr, JSON_UNESCAPED_SLASHES);
            }
            
            if ($reload == 1) {
              return go($originurl); // Successfully moved
            }
            
            if (!empty($_POST['username'])) {
              // send an email when the image comes from the RFID system
              try {
                $email = email(array(
                  'service' => 'html_email',
                  'from'    => 'happyrobot@maker.tufts.edu',
                  'subject' => 'New photo from the Maker Studio',
                  'body'    => '
                    <html>
                      <head>
                        <title>New photo from the Maker Studio</title>
                      </head>
                      <body>
                        <p>The photo you just snapped from the Maker Studio has been added to your Maker Profile.</p>
                        <p>- Maker Network Email Robot</p>
                      </body>
                    </html>
                  '
                ));
                
                // Multiple recipients
                // https://forum.getkirby.com/t/send-e-mail-to-multiple-receipients/2903/6
                //foreach(array('andybraren@gmail.com','tuftsceeohelp@gmail.com') as $to) {
                foreach(array('andybraren@gmail.com') as $to) {
                  $result = $email->send(array('to' => $to));
                }
                
              } catch(Exception $e) {
                echo $e->getMessage();
              }
            }
            
          }
        }
        
      } catch(Exception $e) {
        return go($originurl . '/error:upload3');
      }
    }
	),

  // SAVE IMAGES
  // https://github.com/GetmeUK/ContentTools/issues/38
	array(
    'pattern' => array('upload-image', '(.+upload-image)'),
		'method' => 'POST',
		'action'  => function() {
      try {
        
        //print_r($_REQUEST);
        
        // gets us something like /var/www/drewbaren.com/maker/content/frontend-editing-example/
        $target_dir = kirby()->roots()->content() . '/' . str_replace(array('/maker/','/ne/','/upload-image'),'',$_SERVER['REQUEST_URI']) . '/';
        $target_url = site()->url() . '/' . str_replace(array('/maker/','/ne/','/upload-image'),'',$_SERVER['REQUEST_URI']) . '/';
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        $uploadOk = 1;
        $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
        // Check if image file is an actual image or a fake image
        if(isset($_POST["submit"])) {
            $check = getimagesize($_FILES["image"]["tmp_name"]);
            if($check !== false) {
                echo "File is an image - " . $check["mime"] . ".";
                $uploadOk = 1;
            } else {
                echo "File is not an image.";
                $uploadOk = 0;
            }
        }
        // Check if file already exists
        if (file_exists($target_file)) {
          //echo "Sorry, file already exists.";
          //echo "File already exists. Overwriting.";
          //echo $target_file;
          unlink($target_file);
          //$uploadOk = 0;
          $uploadOk = 1;
        }
        // Check file size
        /*
        if ($_FILES["image"]["size"] > 1500000) {
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }
        */
        // Allow certain file formats
        if($imageFileType != "jpg" && $imageFileType != "JPG" &&
           $imageFileType != "png" && $imageFileType != "PNG" &&
           $imageFileType != "jpeg"&& $imageFileType != "JPEG" &&
           $imageFileType != "gif" && $imageFileType != "GIF") {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }
        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
        // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                
                /* Use GD Lib to detect image orientation and rotate if necessary
                  - https://forum.getkirby.com/t/wrong-orientation-of-images-portrait-landscape-after-upload/692/19
                  - https://github.com/getkirby/starterkit/blob/0b4a6e8cf929237621d77adb996e98b08d234004/kirby/toolkit/lib/thumb.php
                */
                try {
                  $img = new abeautifulsite\SimpleImage($target_file);
                  //echo $target_file;
                  $img->auto_orient();
                  @$img->save($target_file);
                } catch(Exception $e) {
                  echo "Error rotating image";
                }
    
                //$arr = array('size' => $_FILES["image"]["size"], 'url' => 'https://drewbaren.com/maker/content/frontend-editing-example/'.$_FILES["image"]["name"].'');
                $arr = array('size' => $_FILES["image"]["size"], 'url' => $target_url.$_FILES["image"]["name"].'');


                echo json_encode($arr);
    
            } else {
                echo "Sorry, there was an error uploading your file.";
                echo '<br>' . $target_dir;
            }
        }

      } catch(Exception $e) {
        $error = true;
        echo "Dang, image not uploaded. Blame Andy.";
      }
    }
	),
  // Insert the saved image for ContentTools
	array(
    'pattern' => array('insert-image', '(.+insert-image)'),
		'method' => 'POST',
		'action'  => function() {
      try {
        $items = list($width, $height) = getimagesize($_POST['url']);
        
        if ($items[0] > $_POST['width']) {
          $newwidth = $_POST['width'];
          $newheight = ($_POST['width'] / $items[0]) * $items[1];
        } else {
          $newwidth = $items[0];
          $newheight = $items[1];
        }
    
        $arr = array('url' => $_POST['url'], 'width' => $_POST['width'], 'crop' => $_POST['crop'],
         'alt'=> "Image", 'size' => array($newwidth, $newheight)); // size piece tweaked based on GitHub comments
    
        echo json_encode($arr);
      } catch(Exception $e) {
        $error = true;
        echo "Dang, image not inserted. Blame Andy.";
      }
    }
	),



















  // ICAL
  array(
    'pattern' => 'events/webcal',
    'action'  => function() {
      
      $blah = "BEGIN:VCALENDAR
        VERSION:2.0
        PRODID:-//Maker Network//EN 
        CALSCALE:GREGORIAN
        METHOD:PUBLISH
        X-ORIGINAL-URL:http://maker.tufts.edu/events
        X-WR-CALNAME:Maker Network Events
        BEGIN:VTIMEZONE
        TZID:America/New_York
        X-LIC-LOCATION:America/New_York
        BEGIN:DAYLIGHT
        TZOFFSETFROM:-0500
        TZOFFSETTO:-0400
        TZNAME:EDT
        DTSTART:19700308T020000
        RRULE:FREQ=YEARLY;BYMONTH=3;BYDAY=2SU
        END:DAYLIGHT
        BEGIN:STANDARD
        TZOFFSETFROM:-0400
        TZOFFSETTO:-0500
        TZNAME:EST
        DTSTART:19701101T020000
        RRULE:FREQ=YEARLY;BYMONTH=11;BYDAY=1SU
        END:STANDARD
        END:VTIMEZONE

      ";
      
      $blah = join("\n", array_map("trim", explode("\n", $blah)));
      echo $blah;

      foreach(site()->page('events')->children()->filterBy('StartDate','<',date('c'))->sortBy('StartDate','asc')->limit(100) as $event) {
        echo "BEGIN:VEVENT" . "\r\n";
        echo "DTSTAMP:" . $event->date('Ymd','Created') . "T" . $event->date('his','Created') . "Z\r\n";
        echo "DTSTART;TZID=America/New_York:" . $event->date('Ymd','StartDate') . "T" . $event->date('His','StartDate') . "\r\n";
        echo "DTEND;TZID=America/New_York:" . $event->date('Ymd','EndDate') . "T" . $event->date('His','EndDate') . "\r\n";
        echo "STATUS:CONFIRMED" . "\r\n";
        echo "SUMMARY:" . $event->title() . "\r\n";
        echo "DESCRIPTION:" . $event->text()->excerpt(200) . "\r\n";
        echo "CLASS:PUBLIC" . "\r\n";
        echo "CREATED:20150911T133713Z" . "\r\n";
        echo "GEO:42.36;-71.18" . "\r\n";
        echo "LOCATION:" . $event->place() . "\r\n";
        echo "URL:" . $event->url() . "\r\n";
        echo "LAST-MODIFIED:20150915T134400Z" . "\r\n";
        echo "UID:" . $event->uid() . "\r\n";
        echo "END:VEVENT" . "\r\n";
        echo "\r\n";
      }
        echo "END:VCALENDAR";

    }
  ),

  // RECEIVE RASPBERRY PI IP ADDRESS
  array(
    'pattern' => 'raspberry',
    'action'  => function() {
  
      try {
        site()->page('raspberry')->update(array(
          'raspberryip'  => param('raspip')
        ));
        echo param('raspip');
      }

      catch(Exception $e) {
        echo $e->getMessage();
      }
      
    }
  ),
  


  // Convert pages to new datedata
  array(
    'pattern' => 'changepagetimes',
    'action'  => function() {
    
      foreach(site()->page('challengess')->children() as $targetpage) {
        try {
          $targetpage->create($targetpage->uri() . '1', 'challenge', array(
            'Title'  => $targetpage->title(),
            'DateData' => $targetpage->created() . ', ' . $targetpage->content()->modified() . ' == ' . $targetpage->modifiedby() . ', ' . '2016-09-10 20:50:00' . ', ' . $targetpage->startdate() . ', ' . $targetpage->enddate(),
            'Makers' => $targetpage->makers(),
            'Visibility' => $targetpage->visibility(),
            'Submissions' => $targetpage->submissions(),
            'Color' => $targetpage->color(),
            'Hero' => $targetpage->hero(),
            'Text' => $targetpage->text(),
          ));
        }
        
        catch(Exception $e) {
          echo $e->getMessage();
          echo "no";
        }
      }
      
      echo "dyo";
      
    }
  ),




  // Convert pages to new datedata
  array(
    'pattern' => 'stripe',
    'method' => 'POST',
    'action'  => function() {
      
      require_once('../site'); // need to find the right place
      
      \Stripe\Stripe::setApiKey("sk_test_RHH3uO4EmYB9qobfbPzvuYGd"); // Set secret key
      $token = $_POST['stripeToken']; // Get the form's Stripe token
      $email = $_POST['stripeEmail']; // Get the form's email
      
      try { // Charge the card
        $charge = \Stripe\Charge::create(array(
          "amount" => 1000, // Amount in cents
          "currency" => "usd",
          "source" => $token,
          "description" => "Example charge"
          ));
      } catch(\Stripe\Error\Card $e) {
        // The card has been declined
      }
      
      
      echo "hi";
      
    }
  ),





));











