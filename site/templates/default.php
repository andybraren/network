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

    <?php if($page->uid() != 'groups' and $page->uid() != 'spaces' and $page->uid() != 'projects' and $page->uid() != 'handbooks' and $page->uid() != 'articles' and $page->uid() != 'equipment' and $page->uid() != 'books' and $page->uid() != 'courses' and $page->uid() != 'learn'): ?>
      <?php snippet('sidebar') ?>
    <?php endif ?>

    <?php if($page->parent() == 'articles' or $page->parent() == 'spaces' or $page->parent() == 'groups' or $page->parent() == 'handbooks' or $page->uid() == 'docs' or $page->parent() == 'projects' and $page->uid() != 'courses' and $page->uid() != 'learn'): ?>
      <div class="sidebar rightsidebar">
        <?php snippet('widget', array('type' => 'links')) ?>
        <?php snippet('widget', array('type' => 'equipment')) ?>
        <?php /*
        <h3>LINKS</h3>
          <li><a href="https://google.com">Google</a></li>
          <li><a href="https://google.com">Stack Overflow</a></li>
        <h3>FILES</h3>
        <ul id="blah">
          <li>Test file 1</li>
          <li>Test file 2</li>
          <li>Test file 3</li>
        </ul>
        */ ?>
        <?php /*
        <div id=disquswidget class=widget>
          <script src="//tinkertry.disqus.com/combination_widget.js?num_items=10&hide_mods=1&color=grey&default_tab=recent&excerpt_length=200"></script><style media=screen>#dsq-combo-widget a,#dsq-combo-widget cite,#dsq-combo-widget div,#dsq-combo-widget img,#dsq-combo-widget li,#dsq-combo-widget ol,#dsq-combo-widget p,#dsq-combo-widget ul{font-size:.85rem;line-height:1.2rem;border:0;padding:0;margin:0;float:none;text-indent:0;background:0 0}#dsq-combo-widget li,#dsq-combo-widget ol,#dsq-combo-widget ul{list-style-type:none;list-style-image:none;background:0 0;display:block}#dsq-combo-widget #dsq-combo-content a,#dsq-combo-widget #dsq-combo-content cite,#dsq-combo-widget #dsq-combo-content div,#dsq-combo-widget #dsq-combo-content img,#dsq-combo-widget #dsq-combo-content li,#dsq-combo-widget #dsq-combo-content ol,#dsq-combo-widget #dsq-combo-content p,#dsq-combo-widget #dsq-combo-content ul{border:0;padding:0;margin:0;float:none;text-indent:0;background:0 0}#dsq-combo-widget #dsq-combo-content li,#dsq-combo-widget #dsq-combo-content ol,#dsq-combo-widget #dsq-combo-content ul{list-style-type:none;list-style-image:none;background:0 0;display:block}.dsq-clearfix:after{content:".";display:block;height:0;clear:both;visibility:hidden}#dsq-combo-widget{text-align:left}#dsq-combo-widget #dsq-combo-tabs{float:left}#dsq-combo-widget #dsq-combo-content{position:static}#dsq-combo-widget #dsq-combo-content h3{float:none;text-indent:0;background:0 0;padding:0;border:0;margin:0 0 10px 0;font-size:16px}#dsq-combo-widget #dsq-combo-tabs li{display:inline;float:left;margin-right:2px;padding:0 5px;text-transform:uppercase}#dsq-combo-widget #dsq-combo-tabs li a{text-decoration:none;font-weight:700;font-size:10px}#dsq-combo-widget #dsq-combo-content .dsq-combo-box{margin:0 0 20px;padding:12px;clear:both}#dsq-combo-widget #dsq-combo-content .dsq-combo-box li{padding-bottom:10px;margin-bottom:10px;overflow:hidden;word-wrap:break-word}#dsq-combo-widget #dsq-combo-content .dsq-combo-avatar{float:left;height:48px;width:48px;margin-right:15px}#dsq-combo-widget #dsq-combo-content .dsq-combo-box cite{font-weight:700;font-size:14px}span.dsq-widget-clout{background-color:#FF7300;color:#FFF;padding:0 2px}#dsq-combo-logo{text-align:right}#dsq-combo-widget.blue #dsq-combo-tabs li.dsq-active{background:#E1F3FC}#dsq-combo-widget.blue #dsq-combo-content .dsq-combo-box{background:#E1F3FC}#dsq-combo-widget.blue #dsq-combo-tabs li{background:#B5E2FD}#dsq-combo-widget.blue #dsq-combo-content .dsq-combo-box li{border-bottom:1px dotted #B5E2FD}#dsq-combo-widget.grey #dsq-combo-tabs li.dsq-active{background:#f0f0f0}#dsq-combo-widget.grey #dsq-combo-content .dsq-combo-box{background:#f0f0f0}#dsq-combo-widget.grey #dsq-combo-tabs li{background:#ccc}#dsq-combo-widget.grey #dsq-combo-content .dsq-combo-box li{border-bottom:1px dotted #ccc}#dsq-combo-widget.green #dsq-combo-tabs li.dsq-active{background:#f4ffea}#dsq-combo-widget.green #dsq-combo-content .dsq-combo-box{background:#f4ffea}#dsq-combo-widget.green #dsq-combo-tabs li{background:#d7edce}#dsq-combo-widget.green #dsq-combo-content .dsq-combo-box li{border-bottom:1px dotted #d7edce}#dsq-combo-widget.red #dsq-combo-tabs li.dsq-active{background:#fad8d8}#dsq-combo-widget.red #dsq-combo-content .dsq-combo-box{background:#fad8d8}#dsq-combo-widget.red #dsq-combo-tabs li{background:#fdb5b5}#dsq-combo-widget.red #dsq-combo-content .dsq-combo-box li{border-bottom:1px dotted #fdb5b5}#dsq-combo-widget.orange #dsq-combo-tabs li.dsq-active{background:#fae6d8}#dsq-combo-widget.orange #dsq-combo-content .dsq-combo-box{background:#fae6d8}#dsq-combo-widget.orange #dsq-combo-tabs li{background:#fddfb5}#dsq-combo-widget.orange #dsq-combo-content .dsq-combo-box li{border-bottom:1px dotted #fddfb5}div#dsq-combo-logo{display: none;}</style>
        </div>
        */ ?>
      </div>
    <?php endif ?>
    
    <main class="content">
      <article>
  
        <div data-editable data-name="title">
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
        <?php snippet('cards', array('type' => 'projects', 'group' => $page->uid())) ?>
        <?php snippet('cards', array('type' => 'makers', 'group' => $page->uid())) ?>
        <?php snippet('cards', array('type' => 'articles', 'group' => $page->uid())) ?>
      <?php endif ?>

      <?php if($page->uid() == 'articles'): ?>
        <?php snippet('cards', array('type' => 'articles')) ?>
      <?php endif ?>
      
      <?php if($page->uid() == 'courses'): ?>
        <?php snippet('cards', array('type' => 'courses')) ?>
      <?php endif ?>
      
      <?php if($page->uid() == 'learn'): ?>
        <?php snippet('cards', array('type' => 'handbooks')) ?>
        <?php snippet('cards', array('type' => 'courses')) ?>
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

      <?php if($page->isChildOf($site->find('books'))): ?>
        <?php snippet('cards', array('type' => 'projects')) ?>
      <?php endif ?>

      <?php if($page->parent() == 'events' && $page->hasChildren()): ?>
        <?php snippet('cards', array('type' => 'projects')) ?>
      <?php endif ?>

      <?php if($page->find('comments')): ?>
        <h2>Discussion</h2>
        <?php foreach($page->find('comments')->children() as $comment): ?>
          <?php $name = $site->user($comment->makers())->firstname() . ' ' . $site->user($comment->makers())->lastname() ?>
          <?php echo $name . ' ' . $comment->date('M d, Y', 'created') . ': ' . $comment->text() ?>
        <?php endforeach ?>
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
