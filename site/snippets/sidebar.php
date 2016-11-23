<div class="sidebar">
  
  <?php // PAGE ICON / LOGO ?>
  <?php if ($icon = $page->image('icon.svg') or $icon = $page->image('icon.png') or $icon = $page->image('icon.jpg')): ?>
    <div id="icon"><img id="icon-img" src="<?php echo $icon->url() ?>"></div>
  <?php endif ?>

  <?php // MAKER PROFILE IMAGE ?>
  <?php if ($page->parent() == 'makers'): ?>
    <?php $user = $site->user($page->slug()); ?>
    <?php if ($avatar = $user->avatar()): ?>
      <div id="icon">
        <img id="icon-img" src="<?php echo $avatar->crop(300, 300)->url() ?>">
        <?php if ($page->isEditableByUser()): ?>
          <div id="icon-add">Change profile photo</div>
        <?php endif ?>
      </div>
    <?php else: ?>
      <?php $counter = ceil( strlen($user->username()) / 4 ); ?>
      <?php $defaultimage = new Asset('/assets/images/avatar-' . $counter . '.svg'); ?>
      <div id="icon" class="<?php echo ($user->color() != "") ? $user->color() : $site->defaultcolor(); ?>">
        <img id="icon-img" src="<?php echo $defaultimage->url() ?>">
        <?php if ($page->isEditableByUser()): ?>
          <div id="icon-add">Change profile photo</div>
        <?php endif ?>
      </div>
    <?php endif ?>
  <?php endif ?>
    
  <?php // FRONTEND EDITING CONTROLS ?>
  <?php // Need to figure out how to enable admins still, multiple operators, maybe a case statement ?>
  <?php if($user = $site->user() and str::contains($page->makers(), $user) or $user = $site->user() and str::contains($page->slug(), $user) or $user = $site->user() and $user->usertype() == 'admin'): ?>
    <div id="button-edit" class="button flash">Edit</div>
    
    <div id="settings" class="">
      <h3>SETTINGS</h3>
      <form method="post" action="savesettings" id="form-settings">
        
        <div class="size-full">
          <?php $class = ($page->visibility()->isNotEmpty()) ? "hasbeenclicked clicked" : "neverclicked"; ?>
          <select name="visibility" id="visibility" class="<?php echo $class ?>">
            <?php foreach ($site->content()->visibilityoptions()->split(',') as $visibility): ?>
              <?php $selected = ($visibility == $page->visibility()) ? "selected " : ""; ?>
              <?php echo '<option ' . $selected . 'value="' . str::slug($visibility) . '">' . ucfirst($visibility) . '</option>' ?>
            <?php endforeach ?>
          </select>
          <label for="visibility">Visibility</label>
        </div>
        
        <div class="size-full">
          <?php $class = ($page->color()->isNotEmpty()) ? "hasbeenclicked clicked" : "neverclicked"; ?>
          <select name="color" id="color" class="<?php echo $class ?>">
            <?php foreach ($site->content()->coloroptions()->split(',') as $color): ?>
              <?php $selected = ($color == $page->color()) ? "selected " : ""; ?>
              <?php echo '<option ' . $selected . 'value="' . $color . '">' . ucfirst($color) . '</option>' ?>
            <?php endforeach ?>
          </select>
          <label for="color">Color</label>
        </div>
        <?php /*
        <div>
          <input type="submit" class="button fullwidth" value="Save Settings">
        </div>
        */ ?>
      </form>
    </div>
    
    <?php // Used for adding new hero images and icons ?>
    <form method="post" action="upload" id="upload-form" enctype="multipart/form-data" style="display:none" >
      <input type="file" accept="image/*" name="avatar" id="avatarToUpload">
      <input type="file" accept="image/*" name="hero" id="heroToUpload">
      <input type="file" accept="image/*" name="image" id="imageToUpload">
    </form>
    
<?php /*
    <div id="settings" class="settings column">
      <h3>SETTINGS</h3>
      <?php if ($page->parent() != 'makers'): ?>
      <div class="row"><span>Visible to:</span></div>
        <select>
          <option>Public</option>
          <option>Tufts MAKE</option>
          <option>Tufts Robotics</option>
          <option>Only Me</option>
        </select>

      <?php endif ?>
      <div class="row"><span>Color:</span></div>
        <select>
          <option>Blue</option>
          <option>Red</option>
          <option>Green</option>
          <option>Purple</option>
          <option>Gold</option>
          <option>Silver</option>
        </select>
    </div>
*/ ?>

  <?php endif ?>




  <?php // MAKERS ?>
  <?php if($page->uid() == 'makers'): ?>
    <h3>FILTER BY:</h3>
    <form id="filters">
      <div>
        <select name="affiliation">
            <option value="">None</option>
          <?php foreach ($site->content()->affiliationoptions()->split(',') as $option): ?>
            <option value="<?php echo str::slug($option,'-') ?>"><?php echo trim($option) ?></option>
          <?php endforeach ?>
        </select>
        <label for="affiliation">Tufts Affiliation</label>
      </div>
      <div>
        <select name="department">
          <option value="">None</option>
          <?php foreach ($site->content()->departmentoptions()->split('##') as $option): ?>
            <option value="<?php echo str::slug($option,'-') ?>"><?php echo trim($option) ?></option>
          <?php endforeach ?>
        </select>
        <label for="department">Department</label>
      </div>
      <div>
        <select name="majors">
          <option value="">None</option>
          <?php foreach ($site->content()->majoroptions()->split('##') as $option): ?>
            <option value="<?php echo str::slug($option,'-') ?>"><?php echo trim($option) ?></option>
          <?php endforeach ?>
        </select>
        <label for="majors">Major</label>
      </div>
      <div>
        <input type="number" name="classyear" min="<?php echo (date("Y") - 99) ?>" max="<?php echo (date("Y") + 8) ?>" maxlength="4" step="1" required>
        <label for="classyear">Class year</label>
      </div>
    </form>
    
    <?php /*
    <div class="filter column">
      <h3>Clubs</h3>
      <form action="">
        <input type="checkbox" checked=""> Robotics<br>
        <input type="checkbox" checked=""> MAKE<br>
        <input type="checkbox" checked=""> Entrepreneurs Society<br>
        <input type="checkbox" checked=""> Crafts House<br>
        <input type="checkbox" checked=""> Computer Science Exchange<br>
        <input type="checkbox" checked=""> Human Factors Society<br>
      </form>
    </div>
    */ ?>
  <?php endif ?>

  <?php // MAKERS ?>
  <?php if($page->uid() == 'projects'): ?>
    <div class="filter">
      <h3>Filter</h3>
      <form action="">
        <input type="checkbox" checked="">Personal<br>
        <input type="checkbox" checked="">Research<br>
        <input type="checkbox" checked="">Group<br>
        <input type="checkbox" checked="">Multidisciplinary<br>
      </form>
    </div>
  <?php endif ?>
  
  <?php // MAKER PROFILES ?>
  <?php if ($page->parent() == 'makers'): ?>
    <?php $user = $site->user($page->slug()) ?>
    <div class="info">

      <?php // Class Year ?>
      <?php echo ($user->classyear() != null) ? '<span>Class of ' . $user->classyear() . '</span>' : ""; ?>
      
      <?php // Major ?>
      <?php echo ($user->major() != null) ? '<span>' . $user->major() . '</span>' : ""; ?>
      
      <?php // Social Media ?>
      <?php echo ($user->twitter() != null) ? '<a href="https://twitter.com/' . $user->twitter() . '">Twitter</a>' : ""; ?>
      <?php echo ($user->linkedin() != null) ? '<a href="https://www.linkedin.com/in/' . $user->linkedin() . '">LinkedIn</a>' : ""; ?>
      
      
    </div>
    
    <!--
    <div class="info column">
      <h3>Groups</h3>
      <span>CEEO</span>
    </div>
    
    <div class="info column">
      <h3>Equipment</h3>
      <span>3D Printing</span>
      <span>Soldering</span>
      <span>Laser cutting</span>
    </div>
    -->
    
  <?php endif ?>


  <?php // EVENTS SORTING ?>
  <?php if($page->uid() == 'events'): ?>
    <div class="hours">
      <h3>SUBSCRIBE</h3>
      <span><a href="https://www.facebook.com/events/1714521768776526/">Google Calendar</a></span>
      <span><a href="https://www.facebook.com/events/1714521768776526/">RSS</a></span>
    </div>
    
    <div class="hours">
      <h3>Clubs:</h3>
      <div class="row"><span><input type="checkbox" name="vehicle" value="all" checked> All</input></span></div>
      <div class="row"><span><input type="checkbox" name="vehicle" value="all"> CSX</input></span></div>
      <div class="row"><span><input type="checkbox" name="vehicle" value="make"> MAKE</input></span></div>
      <div class="row"><span><input type="checkbox" name="vehicle" value="make"> MEGSO</input></span></div>
      <div class="row"><span><input type="checkbox" name="vehicle" value="robotics-"> Robotics</input></span></div>
    </div>

    <div class="hours">
      <h3>Spaces:</h3>
      <div class="row"><span><input type="checkbox" name="vehicle" value="all" checked> All</input></span></div>
      <div class="row"><span><input type="checkbox" name="vehicle" value="make"> Maker Studio</input></span></div>
      <div class="row"><span><input type="checkbox" name="vehicle" value="robotics-"> Crafts Center</input></span></div>
      <div class="row"><span><input type="checkbox" name="vehicle" value="all"> Digital Design Studio</input></span></div>
    </div>

    <div class="hours">
      <h3>Type:</h3>
      <div class="row"><span><input type="checkbox" name="vehicle" value="all" checked> All</input></span></div>
      <div class="row"><span><input type="checkbox" name="vehicle" value="make"> Training</input></span></div>
      <div class="row"><span><input type="checkbox" name="vehicle" value="robotics-"> Speaker</input></span></div>
      <div class="row"><span><input type="checkbox" name="vehicle" value="all"> Workshop</input></span></div>
    </div>
  <?php endif ?>

  <?php // LOCATION INFORMATION ?>
  <?php if($page->location() != ""): ?>
    <div class="location">
      <h3>HOURS & LOCATION</h3>
      <?php $address = $page->location() ?>
      <?php $address = ($page->location() == "Crafts Center" ? "75 Packard Ave, Medford MA 02155" : $page->location()) ?>
      <?php $address = ($page->location() == "Maker Studio" ? "574 Boston Ave, Medford MA 02155" : $page->location()) ?>
      
      <?php $remoteURL = "https://maps.googleapis.com/maps/api/staticmap?center=" . urlencode($address) . '&zoom=16&scale=1&size=250x150&maptype=roadmap&format=jpg&visual_refresh=true&markers=size:mid%7Ccolor:0xff0000%7C%7C' . urlencode($address) ?>
      
      <a href='<?php echo "https://maps.google.com?daddr=" . urlencode($address) ?>'>
        <img src='<?php echo downloadedImageURL('location', $remoteURL); ?>'>
      </a>
      <span id="address"><a href='<?php echo "https://maps.google.com?daddr=" . urlencode($address) ?>'><?php echo $address ?></a></span>
    </div>
  <?php endif ?>
    
  <?php // TIME INFORMATION ?>
  <?php if($page->start() != ""): ?>
    <div class="hours">
      <h3>TIME / DATE</h3>
      <span><?php echo $page->date('l F d','Start') . '<br>' . $page->date('g:i','Start') . ' - ' . $page->date('g:i','End') ?></span>
    </div>
  <?php endif ?>
  
  <?php // TIME INFORMATION NEEDS TO BE MERGED WITH THE ABOVE?>
  <?php if($page->StartDate() != ""): ?>
    <div class="hours">
      <h3>EVENT DATE</h3>
      <span><?php echo $page->date('l F d','StartDate') . '<br>' . $page->date('g:i A','StartDate') . ' - ' . $page->date('g:i A','EndDate') ?></span>
    </div>
  <?php endif ?>
  
  <?php // SPACE HOURS INFORMATION ?>
  <?php if($page->hours() != ""): ?>
    <div class="hours">
      <h3>HOURS</h3>
        <?php
          
          //$hours = preg_split('/(\s)/', $page->hours());
          $part = str::split($page->hours(), '~');
          $hours = (isset($part[0])) ? preg_split('/(\s)/', $part[0]) : '';
          $description = (isset($part[1])) ? $part[1] : '';
            
          list($Sun1, $Sun2, $Mon1, $Mon2, $Tue1, $Tue2, $Wed1, $Wed2, $Thu1, $Thu2, $Fri1, $Fri2, $Sat1, $Sat2) = $hours;
          
          date_default_timezone_set('EST');
          
          echo '<div class="row"' . (date('D') == "Sun" ? 'id="currentday"' : '') . '><span class="day">SUN</span><span class="hour">' . ($Sun1 == $Sun2 ? 'Closed</span></div>' : date('g:i A', strtotime($Sun1)) . ' - ' . date('g:i A', strtotime($Sun2)) . '</span></div>');
          echo '<div class="row"' . (date('D') == "Mon" ? 'id="currentday"' : '') . '><span class="day">MON</span><span class="hour">' . ($Mon1 == $Mon2 ? 'Closed</span></div>' : date('g:i A', strtotime($Mon1)) . ' - ' . date('g:i A', strtotime($Mon2)) . '</span></div>');
          echo '<div class="row"' . (date('D') == "Tue" ? 'id="currentday"' : '') . '><span class="day">TUE</span><span class="hour">' . ($Tue1 == $Tue2 ? 'Closed</span></div>' : date('g:i A', strtotime($Tue1)) . ' - ' . date('g:i A', strtotime($Tue2)) . '</span></div>');
          echo '<div class="row"' . (date('D') == "Wed" ? 'id="currentday"' : '') . '><span class="day">WED</span><span class="hour">' . ($Wed1 == $Wed2 ? 'Closed</span></div>' : date('g:i A', strtotime($Wed1)) . ' - ' . date('g:i A', strtotime($Wed2)) . '</span></div>');
          echo '<div class="row"' . (date('D') == "Thu" ? 'id="currentday"' : '') . '><span class="day">THU</span><span class="hour">' . ($Thu1 == $Thu2 ? 'Closed</span></div>' : date('g:i A', strtotime($Thu1)) . ' - ' . date('g:i A', strtotime($Thu2)) . '</span></div>');
          echo '<div class="row"' . (date('D') == "Fri" ? 'id="currentday"' : '') . '><span class="day">FRI</span><span class="hour">' . ($Fri1 == $Fri2 ? 'Closed</span></div>' : date('g:i A', strtotime($Fri1)) . ' - ' . date('g:i A', strtotime($Fri2)) . '</span></div>');
          echo '<div class="row"' . (date('D') == "Sat" ? 'id="currentday"' : '') . '><span class="day">SAT</span><span class="hour">' . ($Sat1 == $Sat2 ? 'Closed</span></div>' : date('g:i A', strtotime($Sat1)) . ' - ' . date('g:i A', strtotime($Sat2)) . '</span></div>');
          echo '<span>' . strip_tags(kirbytext($description), '<a>') . '</span>';
          
        ?>
      
    </div>
  <?php endif ?>

  <?php // AUTHORS WIDGET ?>
  <?php if($page->parent() != 'makers'): ?>
    <?php snippet('widget', array('type' => 'authors')) ?>
  <?php endif ?>
  
  <?php // GROUPS WIDGET ?>
  <?php if($page->parent() != 'groups'): ?>
    <?php snippet('widget', array('type' => 'groups')) ?>
  <?php endif ?>
  
  <?php // RELEVANT EQUIPMENT WIDGET - displays each piece of Equipment related to this Handbook ?>
  <?php if($page->parent() == "handbooks"): ?>
    <?php snippet('widget', array('type' => 'equipment')) ?>
  <?php endif ?>
  
  <?php // RELEVANT SPACES WIDGET - displays each Handbook related to this piece of Equipment ?>
  <?php if($page->parent() == "equipment"): ?>
    <?php snippet('widget', array('type' => 'spaces')) ?>
  <?php endif ?>
  
  <?php // RELEVANT HANDBOOKS WIDGET - displays each Handbook related to this piece of Equipment ?>
  <?php if($page->parent() == "equipment" or $page->parent() == "groups"): ?>
    <?php snippet('widget', array('type' => 'handbooks')) ?>
  <?php endif ?>
  
  
  
  <?php // TABLE OF CONTENTS ?>
  <?php if($page->intendedTemplate() == 'handbook' or $page->intendedTemplate() == 'article' or $page->intendedTemplate() == 'project'): ?>
    <?php if(preg_match_all('/(?<!#)#{2}([^#].*)\n/', $page->text(), $matches)): ?>
      <div class="toc sticky">
        <div>
          <h3>CONTENTS</h3>
          <a onclick="window.scrollTo(0,0);">&#8673;</span>
        </div>
        <?php
            /*
            if(preg_match_all('/<h2 id="(.*?)"><a href=".*?">(.*?)<\/a><\/h2>/', $page->text()->kirbytext(), $matches)) {
              echo "blah";
              print_r($matches);
            }
            */
            /* /\n## (.*)\n/ */
            /* Not outputting first H2 if it's the very first thing in doc */
            
            /* Grab all H2's and H2's only from the markdown-formatted text using regex
              Negative lookbehind: http://stackoverflow.com/questions/9306202/regex-for-matching-something-if-it-is-not-preceded-by-something-else
              Look for ## without another # beforehand, then match everything after until the newline
            */
            echo '<ul>';
            foreach($matches[1] as $match) {
              //echo $match;
              echo '<li><a href="#' . str::slug($match) . '">' . $match . '</a></li>';
            }
            echo "</ul>";
            
            //print_r($matches[1]);
          
          //echo $page->text();
        ?>
      </div>
    <?php endif ?>
  <?php endif ?>







<?php
function getMakerRole($person) {

  if(preg_match("/" . page()->slug() . " == (.*?) \|\|/", site()->user($person)->roles(), $matches)) {
    return $matches[1];
  }
  
  else {
    return "blah";
  }


}
?>

</div>