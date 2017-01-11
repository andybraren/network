<nav id="navigation" role="navigation">
  
  <div class="container">
  
    <ul class="menu">
      
      <div class="logo">
        <a href="<?php echo url() ?>">
          <?php $logo = new Asset('/assets/images/logo-white-2.svg'); ?>
          <img id="logo-1" src="<?php echo url('assets/images/logo-white-2.svg') ?>" width="152px" alt="<?php echo $site->title()->html() ?>" />
          <img id="logo-2" src="<?php echo url('assets/images/logo-white.svg') ?>" alt="<?php echo $site->title()->html() ?>" />
        </a>
      </div>
        
      <?php if($_SERVER['SERVER_NAME'] == 'makernetwork.org'): ?>
      
        <?php if ($site->page('learn')): ?>
          <li><a href="<?php echo $site->page('learn')->url() ?>" <?php echo (in_array($page->uid(), array('learn','courses','handbooks','books'))  or $page->isDescendantOf('courses') or $page->isDescendantOf('handbooks') or $page->isDescendantOf('books')) ? ' class="active"' : '' ?>>Learn</a></li>
        <?php endif ?>
        
        <?php if ($site->page('make')): ?>
          <li>
            <a href="<?php echo $site->page('make')->url() ?>" <?php echo (in_array($page->uid(), array('make','ideas','projects','challenges')) or $page->isDescendantOf('make') or $page->isDescendantOf('projects') or $page->isDescendantOf('challenges')) ? ' class="active"' : '' ?>>Make</a>
            <ul>
              <li><a>Ideas</a></li>
              <li><a href="https://makernetwork.org/projects">Projects</a></li>
              <li><a href="https://makernetwork.org/challenges" class="active">Challenges</a></li>
              <li><a>Materials</a></li>
            </ul>
          </li>
        <?php endif ?>
        
        <?php if ($site->page('connect')): ?>
          <li><a href="<?php echo $site->page('connect')->url() ?>" <?php echo (in_array($page->uid(), array('connect','articles','makers','groups')) or $page->isDescendantOf('articles') or $page->isDescendantOf('makers') or $page->isDescendantOf('groups')) ? ' class="active"' : '' ?>>Connect</a></li>
        <?php endif ?>
        
        <?php if ($site->page('spaces')): ?>
          <li><a href="<?php echo $site->page('spaces')->url() ?>" <?php echo ($page->uid() == 'spaces'  or $page->isDescendantOf('spaces')) ? ' class="active"' : '' ?>>Spaces</a></li>
        <?php endif ?>
        
        <?php if ($site->page('equipment')): ?>
          <li><a href="<?php echo $site->page('equipment')->url() ?>" <?php echo ($page->uid() == 'equipment'  or $page->isDescendantOf('equipment')) ? ' class="active"' : '' ?>>Equipment</a></li>
        <?php endif ?>
        
        <?php if ($site->page('events')): ?>
          <li><a href="<?php echo $site->page('events')->url() ?>" <?php echo ($page->uid() == 'events' or $page->isDescendantOf('events')) ? ' class="active"' : '' ?>>Events</a></li>
        <?php endif ?>

      <?php endif ?>
      
      <?php if($_SERVER['SERVER_NAME'] != 'makernetwork.org'): ?>
        <li><a href="<?php echo $site->page('spaces')->url() ?>" <?php echo ($page->uid() == 'spaces' OR $page->isDescendantOf('spaces')) ? ' class="active"' : ''; ?>>Spaces</a></li>
        <li><a href="<?php echo $site->page('handbooks')->url() ?>" <?php echo ($page->uid() == 'handbooks' OR $page->isDescendantOf('handbooks')) ? ' class="active"' : ''; ?>>Handbooks</a></li>
        <li><a href="<?php echo $site->page('equipment')->url() ?>" <?php echo ($page->uid() == 'equipment' OR $page->isDescendantOf('equipment')) ? ' class="active"' : ''; ?>>Equipment</a></li>
        <li><a href="<?php echo $site->page('makers')->url() ?>" <?php echo ($page->uid() == 'makers' OR $page->isDescendantOf('makers')) ? ' class="active"' : ''; ?>>Makers</a></li>
        <li><a href="<?php echo $site->page('groups')->url() ?>" <?php echo ($page->uid() == 'groups' OR $page->isDescendantOf('groups')) ? ' class="active"' : ''; ?>>Groups</a></li>
        <li><a href="<?php echo $site->page('projects')->url() ?>" <?php echo ($page->uid() == 'projects' OR $page->isDescendantOf('projects')) ? ' class="active"' : ''; ?>>Projects</a></li>
      <?php endif ?>
        
    </ul>
  
    <ul class="menu menu-secondary">
      <?php if ($_SERVER['SERVER_NAME'] == 'makernetwork.org'): ?>
        <li><a href="<?php echo $site->page('docs')->url() ?>" <?php echo ($page->uid() == 'docs' OR $page->isChildOf('docs')) ? ' class="active"' : ''; ?>>Docs</a></li>
        <li><a href="https://github.com/andybraren/network">Download</a></li>
      <?php elseif ($_SERVER['SERVER_NAME'] == 'tuftsmake.com'): ?>
        <li><a href="&#109;&#97;ilto&#58;and%79&#98;rare%&#54;&#69;&#64;g&#109;a%&#54;9l&#46;&#99;%6&#70;m">Report an issue</a></li>
      <?php else: ?>
        <li><a href="<?php echo $site->page('about')->url() ?>">About</a></li>
        <li><a href="https://www.facebook.com/groups/535093299989314">Follow</a></li>
      <?php endif ?>
      
      <li><a href="&#109;&#97;ilto&#58;and%79&#98;rare%&#54;&#69;&#64;g&#109;a%&#54;9l&#46;&#99;%6&#70;m">Contact</a></li>
      
      
      <?php if ($_SERVER['SERVER_NAME'] == 'makernetwork.org'): ?>
        <?php if($site->user() != null): ?>
          <li><a href="<?php echo $page->url() . '/logout' ?>">Logout</a></li>
        <?php endif ?>
      <?php else: ?>
        <?php if($site->user() == null): ?>
          <li><a class="button-signup" class="login">Sign up</a></li>
        <?php else: ?>
          <li><a href="<?php echo $page->url() . '/logout' ?>">Logout</a></li>
        <?php endif ?>
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
        <a id="datausername" href="<?php echo $site->url() . "/makers/" . $user->username() ?>" data-username="<?php echo $user->username() ?>">
          <?php echo esc($user->firstName()) ?>
        </a>
        <ul class="submenu">
          <li>
            <a href="<?php echo $page->url() . '/logout' ?>">Logout</a>
          </li>
        </ul>
      <?php else: ?>
        <a id="button-login" class="login">Log in</a>
      <?php endif ?>
      </li>
    </ul>
  
  </div>
  
</nav>

<?php if (!in_array($page->uid(), array('home','spaces','events','search','equipment','docs'))): ?>
  <nav id="subnavigation" role="navigation">
    <div class="container">
      
      <ul class="menu">
        <li class="tocselector"><a><img src="<?php echo url('assets/images/menu-toc.svg') ?>"></a></li>
        
        <?php if (in_array($page->uid(), array('learn','courses','handbooks','books')) or $page->isDescendantOf('courses') or $page->isDescendantOf('handbooks') or $page->isDescendantOf('books')): ?>
          <?php if ($site->page('courses')): ?>
            <li><a href="<?php echo $site->page('courses')->url() ?>" <?php echo ($page->uid() == 'courses' OR $page->isDescendantOf('courses')) ? ' class="active"' : '' ?>>Courses</a></li>
          <?php endif ?>
          
          <?php if ($site->page('handbooks')): ?>
            <li><a href="<?php echo $site->page('handbooks')->url() ?>" <?php echo ($page->uid() == 'handbooks' OR $page->isDescendantOf('handbooks')) ? ' class="active"' : '' ?>>Handbooks</a></li>
          <?php endif ?>
          
          <?php if ($site->page('books')): ?>
            <li><a href="<?php echo $site->page('books')->url() ?>" <?php echo ($page->uid() == 'books' OR $page->isDescendantOf('books')) ? ' class="active"' : '' ?>>Books</a></li>
          <?php endif ?>
        <?php endif ?>
        
        <?php if (in_array($page->uid(), array('make','ideas','projects','challenges')) or $page->isDescendantOf('projects') or $page->isDescendantOf('challenges')): ?>
          <li><a>Ideas</a></li>
          <?php if ($site->page('projects')): ?>
            <li><a href="<?php echo $site->page('projects')->url() ?>" <?php echo ($page->uid() == 'projects' OR $page->isDescendantOf('projects')) ? ' class="active"' : '' ?>>Projects</a></li>
          <?php endif ?>
          <?php if ($site->page('challenges')): ?>
            <li><a href="<?php echo $site->page('challenges')->url() ?>" <?php echo ($page->uid() == 'challenges' OR $page->isDescendantOf('challenges')) ? ' class="active"' : '' ?>>Challenges</a></li>
          <?php endif ?>
          <li><a>Materials</a></li>
        <?php endif ?>
        
        <?php if (in_array($page->uid(), array('connect','articles','makers','groups')) or $page->isDescendantOf('articles') or $page->isDescendantOf('makers') or $page->isDescendantOf('groups')): ?>
          <?php if ($site->page('articles')): ?>
            <li><a href="<?php echo $site->page('articles')->url() ?>" <?php echo ($page->uid() == 'articles' OR $page->isDescendantOf('articles')) ? ' class="active"' : '' ?>>Articles</a></li>
          <?php endif ?>
          <?php if ($site->page('makers')): ?>
            <li><a href="<?php echo $site->page('makers')->url() ?>" <?php echo ($page->uid() == 'makers' OR $page->isDescendantOf('makers')) ? ' class="active"' : '' ?>>Makers</a></li>
          <?php endif ?>
          <?php if ($site->page('groups')): ?>
            <li><a href="<?php echo $site->page('groups')->url() ?>" <?php echo ($page->uid() == 'groups' OR $page->isDescendantOf('groups')) ? ' class="active"' : '' ?>>Groups</a></li>
          <?php endif ?>
        <?php endif ?>
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
<?php endif ?>
