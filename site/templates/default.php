<?php // Authentication ?>
<?php if (!$page->isVisibleToUser()): ?>
  <?php snippet('header') ?>
  <div class="main">
    <div class="container">
      <div class="sidebar"></div>
      <main class="content">
        <article>
          <h1>
            <?php echo ($site->errorPage()->title() != "") ? $site->errorPage()->title() : "" ?>
          </h1>
          <div class="text">
            <?php echo ($site->errorPage()->text() != "") ? $site->errorPage()->text()->kirbytext() : "" ?>
          </div>
        </article>
      </main>
    </div>
  </div>
  <?php snippet('footer') ?>
<?php else: ?>

<?php snippet('header') ?>

<?php snippet('hero', array('type' => 'fullwidth')) ?>



<div class="main">
  <div class="container">
    
    <?php if (!empty($page->authors())): ?>
        <?php snippet('sidebar') ?>
    <?php endif ?>
    
    <?php if ($page->links() != '' or $page->equipment() != '' or $page->handbooks() != ''): ?>
      <div class="sidebar rightsidebar">
        <?php snippet('widget', array('type' => 'links')) ?>
        <?php snippet('widget', array('type' => 'equipment')) ?>
        <?php snippet('widget', array('type' => 'handbooks')) ?>
      </div>
    <?php endif ?>
    
    <main class="content">
      <article>
        
        <div class="title" data-editable data-name="title">
          <h1><?php echo ($page->title() != "") ? $page->title()->html() : "" ?></h1>
        </div>
        
        <?php if($page->text() != ''): ?>
          <div class="text" data-editable data-name="text"><?php echo $page->text()->kirbytext() ?></div>
        <?php elseif($user = $site->user() and $page->slug() == $user or $user = $site->user() and $user->usertype() == 'admin' and $page->parent() == 'makers'): ?>
          <div class="text" data-editable data-name="text"><p placeholder="Click the edit button to add a brief description of yourself."></p></div>
        <?php elseif($page->isEditableByUser() and $page->uid() != 'projects'): ?>
          <div class="text" data-editable data-name="text"><p placeholder="Click the edit button to add content to this page."></p></div>
        <?php else: ?>
          <div class="text" data-editable data-name="text"><p></p></div>
        <?php endif ?>
        
        <?php if($page->uid() == 'makers'): ?>
          <?php snippet('cards', array('type' => 'makers')) ?>
        <?php endif ?>
        
      </article>
      
      <?php // MAKER PROFILES ?>
      <?php if ($page->parent() == 'makers'): ?>
        
        <?php snippet('cards', array('type' => 'projects',  'maker' => $page->slug())) ?>
        <?php snippet('cards', array('type' => 'articles',  'maker' => $page->slug())) ?>
        <?php snippet('cards', array('type' => 'handbooks', 'maker' => $page->slug())) ?>
        <?php snippet('cards', array('type' => 'groups',    'maker' => $page->slug())) ?>
        
        <?php if($page->find('gallery') and $page->find('gallery')->hasImages()): ?>
          <h2>Gallery</h2>
          <?php echo guggenheim($page->find('gallery')->images(), array('width' => c::get('guggenheim.width'), 'height' => '150', 'border' => 4)) ?>
        <?php endif ?>
        
      <?php endif ?>
      
      <?php if($page->uid() == 'groups'): ?>
        <?php snippet('cards', array('type' => 'groups')) ?>
      <?php endif ?>
      <?php if($page->parent() == 'groups'): ?>
        <h2>Projects</h2>
        <?php snippet('cards', array('type' => 'projects', 'group' => $page->uid())) ?>
        <h2>Makers</h2>
        <?php snippet('cards', array('type' => 'makers', 'group' => $page->uid())) ?>
        <h2>Articles</h2>
        <?php snippet('cards', array('type' => 'articles', 'group' => $page->uid())) ?>
      <?php endif ?>
      
      <?php if($page->uid() == 'articles'): ?>
        <?php snippet('cards', array('type' => 'articles')) ?>
      <?php endif ?>
      
      <?php if($page->uid() == 'courses'): ?>
        <?php snippet('cards', array('type' => 'courses')) ?>
      <?php endif ?>
      <?php if($page->isChildOf($site->find('courses'))): ?>
        <?php snippet('cards', array('type' => 'projects', 'group' => $page->uid())) ?>
      <?php endif ?>
      
      <?php if($page->uid() == 'learn'): ?>
        <?php snippet('cards', array('type' => 'courses')) ?>
        <?php snippet('cards', array('type' => 'handbooks')) ?>        
      <?php endif ?>
      
      <?php if($page->uid() == 'make'): ?>
        <?php snippet('cards', array('type' => 'projects')) ?>
        <?php snippet('cards', array('type' => 'challenges')) ?>
      <?php endif ?>
      
      <?php if($page->uid() == 'connect'): ?>
        <?php snippet('cards', array('type' => 'makers')) ?>
        <?php snippet('cards', array('type' => 'articles')) ?>
        <?php snippet('cards', array('type' => 'groups')) ?>
      <?php endif ?>
      
      <?php if($page->uid() == 'projects'): ?>
        <?php snippet('cards', array('type' => 'projects')) ?>
      <?php endif ?>
      
      <?php if($page->uid() == 'bugs'): ?>
        <?php snippet('cards', array('type' => 'bugs')) ?>
      <?php endif ?>
      
      <?php if($page->uid() == 'spaces'): ?>
        <?php snippet('cards', array('type' => 'spaces')) ?>
      <?php endif ?>
      
      <?php if($page->uid() == 'handbooks'): ?>
        <?php snippet('cards', array('type' => 'handbooks')) ?>
      <?php endif ?>
      
      <?php if($page->uid() == 'equipment'): ?>
        <?php snippet('cards', array('type' => 'equipment')) ?>
      <?php endif ?>
      
      <?php if($page->uid() == 'books'): ?>
        <?php snippet('cards', array('type' => 'books')) ?>
      <?php endif ?>
      
      <?php if($page->uid() == 'challenges'): ?>
        <?php snippet('cards', array('type' => 'challenges')) ?>
      <?php endif ?>
      
      <?php if($page->isChildOf($site->find('challenges'))): ?>
        <?php snippet('cards') ?>
      <?php endif ?>
      
      <?php if($page->parent() == 'events' && $page->hasChildren()): ?>
        <?php snippet('cards', array('type' => 'projects')) ?>
      <?php endif ?>
      
      
      
      <?php // http://stackoverflow.com/questions/2915864/php-how-to-find-the-time-elapsed-since-a-date-time
        function humanDate($date) {
          
          $time = time() - $date; // to get the time since that moment
          $time = ($time < 1) ? 1 : $time;
          $tokens = array (
            //31536000 => 'year',
            //2592000 => 'month',
            //604800 => 'week',
            86400 => 'day',
            3600 => 'hour',
            60 => 'minute',
            1 => 'second'
          );
          
          if ($time > (2592000*2)) { // over 2 months
            return date('M \'y', $date);
          }
          elseif ($time > 2592000) { // over 1 month
            return date('M j', $date);
          }
          elseif ($time > (604800*2)) { // over 2 weeks
            return date('M j', $date);
          }
          elseif ($time < 60) { // under 60 seconds
            return 'just now';
          }
          else {
            foreach ($tokens as $unit => $text) {
              if ($time < $unit) continue;
              $numberOfUnits = floor($time / $unit);
              return $numberOfUnits . ' ' . $text . (($numberOfUnits > 1) ? 's' : '') . ' ago';
            }
          }
        }
      ?>
      
      
      <?php if($page->comments()): ?>
        <div class="discussion">
          
          <div id="discussion-header" class="row">
            <h2>Discussion</h2>
            
            <div id="discussion-sections" class="row">
              
              <div>
                <span>Makers</span>
                <span><?php echo $page->comments()->count() ?> comments</span>
              </div>
              
              <div>
                <span>Disqus</span>
                <span># comments</span>
              </div>
              
              <div>
                <span>Links</span>
                <span># links</span>
              </div>

            </div>
          </div>
          
          <?php $commentcount = 0; ?>
          <?php foreach($page->comments() as $comment): ?>
            
            <?php
              $user = $site->user($comment->authors()->first());
              $userurl = $site->url() . "/makers/" . $user->username();
              $firstname = $user->firstname();
              $fullname = $user->firstname() . ' ' . $user->lastname();
                            
              $commentdate = strtotime($comment->dateCreated());
              $exactdate = date('M j, Y g:ia', $commentdate);
              $humandate = humanDate($commentdate);
              $datemodified = ($comment->dateModified()) ? date('M j, Y g:ia', strtotime($comment->dateModified())) : '';
              
              $commentcount++;
            ?>
            
            <div class="item row" id="comment-<?php echo $commentcount ?>" data-id="<?php echo $comment->slug() ?>">
                
              <div>
                <?php if ($user->usertype() == 'admin'): ?>
                  <div class="user-badge">
                    <div><?php echo (new Asset('/assets/images/icon-mod.svg'))->content() ?></div>
                    <span class="tooltip">Moderator</span>
                  </div>
                <?php endif ?>
                <a href="<?php echo $site->url() . "/makers/" . $user->username() ?>" class="user-avatar">
                  <img src="<?php echo userAvatar($user->username(), 40) ?>" width="40" height="40" class="<?php echo userColor($user->username()) ?>">
                </a>
              </div>
              
              <div class="column">
                <div>
                  <a class="user-firstname" href="<?php echo $userurl ?>"><?php echo $firstname ?></a>
                  <div>
                    <?php if ($datemodified != ''): ?>
                      <span data-role="editbutton" title="<?php echo $datemodified ?>">Edited /</span>
                    <?php endif ?>
                    <a class="comment-date" title="<?php echo $exactdate ?>" href="<?php echo $page->url() . '#comment-' . $commentcount ?>"><?php echo $humandate ?></a>
                  </div>
                </div>
                <div class="text"><?php echo $comment->text()->kirbytext() ?></div>
              </div>
                
            </div>
            
          <?php endforeach ?>
          
          <?php if ($page->isEditableByUser()): ?>
            <div class="item row" id="add-comment">
              <div>
                <?php if ($user->usertype() == 'admin'): ?>
                  <div class="user-badge">
                    <div><?php echo (new Asset('/assets/images/icon-mod.svg'))->content() ?></div>
                    <span class="tooltip">Moderator</span>
                  </div>
                <?php endif ?>
                <a href="<?php echo $site->url() . "/makers/" . $user->username() ?>" class="user-avatar">
                  <img src="<?php echo userAvatar($user->username(), 40) ?>" width="40" height="40" class="<?php echo userColor($user->username()) ?>">
                </a>
              </div>
              
              <div class="column">
                <div>
                  <a class="user-firstname" href="<?php echo 'Blah' ?>"><?php echo $site->user()->firstname() ?></a>
                  <div>
                    <span data-role="editbutton" title=""></span>
                    <a class="comment-date" title="" href=""></a>
                  </div>
                </div>
                
                <div class="text" contentEditable="true">
                  <p placeholder="Add text here"></p>
                </div>
                
                <div class="post">
                  <div class="button" id="save-comment">Post</div>
                </div>
              </div>
            </div>
          <?php endif ?>
          
          
          
          
        </div>
      <?php endif ?>
      
      <?php /*
      <?php if($page->parent() == 'events'): ?>
        <?php echo guggenheim($page->images(), array('width' => 800, 'height' => 200, 'border' => 10)); ?>
      <?php endif ?>
      */ ?>
      
      <?php if($page->uid() == 'events'): ?>
        <h2>Upcoming Events</h2>
        <?php snippet('cards', array('type' => 'events', 'time' => 'upcoming')) ?>
        <h2>Past Events</h2>
        <?php snippet('cards', array('type' => 'events', 'time' => 'past')) ?>
        <?php snippet('events') ?>
      <?php endif ?>
      
    </main>
    
  </div>
</div>

<?php snippet('footer') ?>

<?php endif ?>