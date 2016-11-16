<?php // Master widget snippet for makers, projects, events, tools, etc. ?>

<?php if ($type != null): ?>

<?php // RELATED SPACES AND HANDBOOKS ?>
<?php if ($type == 'spaces' or $type == 'handbooks'): ?>
  
  <?php $divechoed = false; ?>
  
  <?php foreach($site->page($type)->children() as $relatedpage): ?>
    <?php if (in_array($relatedpage->slug(), $page->related())): ?>    
      <?php if (!$divechoed): ?>
        <div class="widget">
          <?php
            switch ($type) {
              case 'spaces':    $title = 'SPACES'; break;
              case 'handbooks': $title = 'HANDBOOKS'; break;
            }
          ?>
          <h3><?php echo $title ?></h3>
          <?php $divechoed = true ?>
      <?php endif ?>
          <a href="<?php echo $relatedpage->url() ?>">
            <?php if ($type == 'spaces' and $page->parent() == 'equipment'): ?>
              <div class="row silver indicator">
                <!--<img src="<?php echo $relatedpage->images()->first()->crop(40)->url() ?>" width="40" height="40">-->
                <div class="column">
                  <span><?php echo $relatedpage->title() ?></span>
                  <!--<span class="indicator"># of # Available</span>-->
                  <span class="indicator"># of # Available</span>
                </div>
              </div>
            <?php else: ?>
              <div class="row">
                <span><?php echo $relatedpage->title() ?></span>
              </div>
            <?php endif ?>
          </a>
    <?php endif ?>
  <?php endforeach ?>
    
  <?php if ($divechoed == true): ?>
    </div>
  <?php endif ?>
    
<?php endif ?>








<?php // RELATED EQUIPMENT ?>
<?php if ($type == 'equipment'): ?>
  
  <?php $divechoed = false; ?>
  
  <?php foreach($site->page('equipment')->children() as $equipmentpage): ?>
    <?php if ($equipmentpage->related() != null and in_array(page()->slug(), $equipmentpage->related())): ?>
    
      <?php if (!$divechoed): ?>
        <div class="widget">
          <h3>EQUIPMENT</h3>
          <?php $divechoed = true ?>
      <?php endif ?>
          <a href="<?php echo $equipmentpage->url() ?>">
            <div class="row silver indicator">
              <img src="<?php echo $equipmentpage->images()->first()->crop(40)->url() ?>" width="40" height="40">
              <div class="column">
                <span><?php echo $equipmentpage->title() ?></span>
                <?php if ($page->parent() == 'spaces'): ?>
                  <span class="indicator">Status: unknown</span>
                <?php else: ?>
                  <span class="indicator"># of # Available</span>
                <?php endif ?>
              </div>
            </div>
          </a>
    <?php endif ?>
  <?php endforeach ?>
    
  <?php if ($divechoed == true): ?>
    </div>
  <?php endif ?>
    
<?php endif ?>





<?php // LINKS ?>
<?php if ($type == 'links' and $page->links() != null): ?>
  
  <div class="widget">
    <h3>LINKS</h3>
    <ul>
      <?php foreach ($page->links() as $link): ?>
        <?php $part = str::split($link, '==') ?>
        <?php
          switch (true) {
            case str::contains($part[1],'facebook'):
              $linkid = 'link-facebook'; break;
            case str::contains($part[1],'twitter'):
              $linkid = 'link-twitter'; break;
            case str::contains($part[1],'github'):
              $linkid = 'link-github'; break;
            case str::contains($part[1],'drive'):
              $linkid = 'link-drive'; break;
            default:
              $linkid = null;
          }
        ?>
        <li <?php echo ($linkid) ? 'id="' . $linkid . '"' : ''?>><a href="<?php echo $part[1] ?>"><?php echo $part[0] ?></a></li>
      <?php endforeach ?>
    </ul>
  </div>
  
<?php endif ?>

<?php // AUTHORS ?>
<?php if ($type == 'authors'): ?>
  
  <?php
    $plural = false;
    $authors = $page->authors();
    if (isset($authors[1])) { // if the array has a second element, then there are multiple authors
      $plural = true;
    }
  ?>
  
  <?php if(isset($authors) or $page->isEditableByUser()): ?>
    <div class="widget">

      <?php /* Set the widget title */
        switch ($page->parent()) {
          case 'clubs':
            $title = 'OFFICERS'; break;
          case 'spaces':
            $title = 'STAFF'; break;
          case 'handbooks':
          case 'articles':
            $title = ($plural) ? 'AUTHORS' : 'AUTHOR'; break;
          default:
            $title = ($plural) ? 'MAKERS' : 'MAKER'; break;
        }
      ?>
      
      <h3><?php echo $title ?></h3>
      
      <?php if (isset($authors)): ?>
        <div class="authors" id="authors">
          <?php foreach(str::split($authors) as $author): ?>
  
            <?php
              $part = str::split($author, '~');
              $username = (isset($part[0])) ? $part[0] : '';
              $role     = (isset($part[1])) ? $part[1] : '';
            ?>
  
            <?php if($site->user($username)): ?>
              <a href="<?php echo $site->url() . "/makers/" . $username ?>" data-username="<?php echo $site->user($username)->username() ?>">
                
                <?php if ($page->isEditableByUser()): ?>
                  <div class="author-delete"></div>
                <?php endif ?>
                
                <div class="row">
                  <img src="<?php echo userAvatar($username, 40) ?>" width="40" height="40" class="<?php echo userColor($username) ?>">
                  <div class="column">
                    <span><?php echo $site->user($username)->firstname() . ' ' . $site->user($username)->lastname() ?></span>
                    <?php if($role): ?>
                      <span><?php echo $role ?></span>
                    <?php /*
                    <?php elseif(preg_match("/" . $page->slug() . " == (.*?) ~~/", $site->user($username)->roles(), $matches)): ?>
                      <span><?php echo $matches[1]; ?></span>
                    */ ?>
                    <?php elseif($site->user($username)->major() != null): ?>
                      <span><?php echo $site->user($username)->major() ?></span>
                    <?php endif ?>
                  </div>
                </div>
                
              </a>
              <?php /* Eventually display a name with no associated user account. Not needed for now. */ ?>
              <?php /*
              <?php else: ?>
                <a>
                  <div class="author-delete"></div>
                  <div class="row">
                    <img src="<?php echo userAvatar($username, 40) ?>" width="40" height="40" class="blue">
                    <div class="column">
                      <span><?php echo $username ?></span>
                    </div>
                  </div>
                </a>
              */ ?>
            <?php endif ?>
            
          <?php endforeach ?>
        </div>
      <?php endif ?>
      
      <?php if ($page->isEditableByUser()): ?>
        <?php $image = new Asset('/assets/images/hero-add.png'); ?>
        <form id="form-author-add" class="invisible">
          <div>
            <input type="text" id="author-add" autocomplete="off">
            <label>Add a maker</label>
            <ul id="author-results"></ul>
          </div>
  
        </form>
      <?php endif ?>
      
    </div>
  <?php endif ?>

<?php endif ?>







<?php // Groups ?>
<?php if ($type == 'groups'): ?>
  
  <?php
    $plural = false;
    $groups = $page->groups();
    if (isset($groups[1])) { // if the array has a second element, then there are multiple groups
      $plural = true;
    }
  ?>
  
  <?php if ($groups != null or $page->isEditableByUser()): ?>
    <div class="widget">
      
      <?php /* Set the widget title */
        $title = ($plural) ? 'GROUPS' : 'GROUP';
      ?>
      
      <h3><?php echo $title ?></h3>
      
      <div class="groups" id="groups">
        <?php if (isset($groups)): ?>
          <?php foreach ($groups as $group): ?>
            <?php $grouppage = $site->page('groups/' . $group) ?>
              <a data-username="<?php echo $grouppage->slug() ?>" href="<?php echo $grouppage->url() ?>">
                
                <?php if ($page->isEditableByUser()): ?>
                  <div class="author-delete"></div>
                <?php endif ?>
                
                <div class="row">
                  
                  <img src="<?php echo groupLogo($grouppage->slug(), 40) ?>" width="40" height="40" class="<?php echo groupColor($grouppage->slug()) ?>">
                  
                  <div class="column">
                    <span><?php echo $grouppage->title() ?></span>
                    <?php // <span># members</span> ?>
                  </div>
                </div>
              </a>
          <?php endforeach ?>
        <?php endif ?>
      </div>
      
      <?php if ($page->isEditableByUser()): ?>
        <form id="form-group-add" class="invisible">
          <div>
            <input type="text" id="group-add" autocomplete="off">
            <label>Add a group</label>
            <ul id="group-results"></ul>
          </div>
  
        </form>
      <?php endif ?>
      
    </div>
  <?php endif ?>
<?php endif ?>








<?php else: ?>
  <?php echo "Error: the web administrator forgot to set the widget type" ?>
<?php endif ?>