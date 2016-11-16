<nav id="navigation" role="navigation">
  
  <div class="container">
  
  <div class="menu">
    <div class="logo">
      <a href="<?php echo url() ?>">
        <?php $logo = new Asset('/assets/images/logo-white-2.svg'); ?>
        <img id="logo-1" src="<?php echo url('assets/images/logo-white-2.svg') ?>" width="152px" alt="<?php echo $site->title()->html() ?>" />
        <img id="logo-2" src="<?php echo url('assets/images/logo-white.svg') ?>" alt="<?php echo $site->title()->html() ?>" />
      </a>
    </div>
  
    <ul class="menu">
      
      <li><a href="<?php echo $site->page('spaces')->url() ?>" <?php echo ($page->uid() == 'spaces' OR $page->isChildOf('spaces')) ? ' class="active"' : ''; ?>>Spaces</a></li>
      <li><a href="<?php echo $site->page('handbooks')->url() ?>" <?php echo ($page->uid() == 'handbooks' OR $page->isChildOf('handbooks')) ? ' class="active"' : ''; ?>>Handbooks</a></li>
      <li><a href="<?php echo $site->page('equipment')->url() ?>" <?php echo ($page->uid() == 'equipment' OR $page->isChildOf('equipment')) ? ' class="active"' : ''; ?>>Equipment</a></li>
      <li><a href="<?php echo $site->page('makers')->url() ?>" <?php echo ($page->uid() == 'makers' OR $page->isChildOf('makers')) ? ' class="active"' : ''; ?>>Makers</a></li>
      <li><a href="<?php echo $site->page('groups')->url() ?>" <?php echo ($page->uid() == 'groups' OR $page->isChildOf('groups')) ? ' class="active"' : ''; ?>>Groups</a></li>
      <li><a href="<?php echo $site->page('projects')->url() ?>" <?php echo ($page->uid() == 'projects' OR $page->isChildOf('projects')) ? ' class="active"' : ''; ?>>Projects</a></li>
      <?php /*
      <li><a href="<?php echo $site->page('events')->url() ?>" <?php echo ($page->uid() == 'events' OR $page->isChildOf('events')) ? ' class="active"' : ''; ?>>Events</a></li>
      */ ?>
      
    </ul>
  </div>
  
  <ul class="menu menu-secondary">
    <?php if ($_SERVER['SERVER_NAME'] == 'tuftsmake.com'): ?>
      <li><a href="&#109;&#97;ilto&#58;and%79&#98;rare%&#54;&#69;&#64;g&#109;a%&#54;9l&#46;&#99;%6&#70;m">Report an issue</a></li>
    <?php else: ?>
      <li><a href="<?php echo $site->page('about')->url() ?>">About</a></li>
      <li><a href="https://www.facebook.com/groups/535093299989314">Follow</a></li>
      <li><a href="&#109;&#97;ilto&#58;and%79&#98;rare%&#54;&#69;&#64;g&#109;a%&#54;9l&#46;&#99;%6&#70;m">Contact</a></li>
    <?php endif ?>
    
    <?php if($site->user() == null): ?>
    <li>
      <a id="button-signup" class="login">Sign up</a>
    </li>
    <?php else: ?>
    <li>
      <a href="<?php echo $page->url() . '/logout' ?>">Logout</a>
    </li>
    <?php endif ?>
    
    <li class="login">
    <?php if($user = $site->user()): ?>
      <!--
      <figure class="user-avatar">
        <?php if($avatar = $user->avatar()): ?>
          <img src="<?php echo $avatar->url() ?>">
        <?php else: ?>
          <img src="<?php echo url('assets/images/avatar.png') ?>">
        <?php endif ?>
      </figure>
      -->
      <a href="<?php echo $site->url() . "/makers/" . $user->username() ?>">
        <?php echo esc($user->firstName()) ?>
      </a>
      <ul class="submenu">
        <li>
          <a href="<?php echo $page->url() . '/logout' ?>">Logout</a>
        </li>
      </ul>
    <?php else: ?>
      <!--<a href="<?php echo url('login') ?>">Log in</a>-->
      <a id="button-login" class="login">Log in</a>
    <?php endif ?>
    </li>

  </ul>
  
  </div>
  
</nav>

<?php /*
<nav id="subnavigation" role="navigation">
  <div class="container">
    <ul class="menu">
      <li class="tocselector"><a><img src="<?php echo url('assets/images/menu-toc.svg') ?>"></a></li>
      <li><a>Research</a></li>
      <li><a>Courses</a></li>
      <li><a>Handbooks</a></li>
      <li><a>Equipment</a></li>
      <li><a>Spaces</a></li>
      <li><a>Projects</a></li>
      <li><a>Ideas</a></li>
      <li><a>Challenges</a></li>
      <li><a>Events</a></li>
    </ul>
    <ul class="menu menu-secondary">
      
      <li class="search">
        <form class="search-container" action="<?php echo $site->url() . '/search'?>">
          <a><img src="<?php echo url('assets/images/menu-search.svg') ?>"></a>
          <input id="search-box" type="text" class="search-box" name="s">
          <input type="submit" id="search-submit">
        </form>
      </li>
      
      <li class="fontselector"><a><img src="<?php echo url('assets/images/menu-font.svg') ?>"></a></li>
      <li class="styleselector"><a><img src="<?php echo url('assets/images/menu-color.svg') ?>"></a></li>


    </ul>
  </div>
</nav>
*/ ?>
