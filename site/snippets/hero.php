<?php $imagesold = $page->images()->filter(function($image){ return str::contains($image->filename(), 'hero'); }); ?>
<?php $images = $page->images()->filterBy('name', '*=', 'hero'); ?>

<?php if($page->uid() == 'projects'): ?>
  <?php $images = $page->children()->filterBy('visibility','public')->sortBy('created','desc')->images()->filterBy('name', '==', 'hero')->limit(10) ?>
<?php endif ?>

<?php if($page->uid() == 'articles'): ?>
  <?php $images = $page->children()->filterBy('visibility','public')->sortBy('created','desc')->images()->filterBy('name', '*=', 'hero')->limit(10) ?>
<?php endif ?>

<?php if($page->uid() == 'equipment'): ?>
  <?php $images = $page->children()->filterBy('visibility','public')->sortBy('created','desc')->images()->filterBy('name', '*=', 'hero')->limit(10) ?>
<?php endif ?>

<?php // HERO VIDEO URL ?>
<?php if ($page->hero() != ""): ?>
  <div id="hero" class="hero fullwidth video">
    <?php echo kirbytag(array('video' => $page->hero())) ?>
  </div>
<?php endif ?>

<?php // HERO VIDEO FILE ?>
<?php if ($video = $page->file('hero.mp4')): ?>

  <div id="hero" class="hero fullwidth video">
    <?php echo kirbytag(array('video' => $video->filename())) ?>
  </div>

<?php // HERO CAROUSELS ?>
<?php elseif ($image = $page->image('hero-1.jpg') OR $image = $page->image('hero-1.png') or $page->uid() == 'projects' or $page->uid() == 'articles' or $page->uid() == 'equipment'): ?>

  <?php if ($type == "fullwidth"): ?>
    <div id="hero" class="hero fullwidth carousel">
      <?php foreach($images as $image): ?>
        <figure>
          <img class="hero-image" src="<?php echo thumb($image, array('width' => 1200, 'height' => 300, 'crop' => true))->url() ?>">
          <?php if (!$image->caption()->empty() or !$image->title()->empty()): ?>
            <figcaption><h2><?php echo $image->title() ?></h2><h3><?php echo $image->subtitle() ?></h3></figcaption>
          <?php endif ?>
        </figure>
      <?php endforeach ?>
    </div>
    
  <?php else: ?>
    <div id="hero" class="hero carousel">
      <?php foreach($images as $image): ?>
        <figure><?php echo $images->url() ?>
          <img class="hero-image" src="<?php echo thumb($image, array('width' => 1200, 'height' => 300, 'crop' => true))->url() ?>">
          <?php if (!$image->caption()->empty() or !$image->title()->empty()): ?>
            <figcaption><h2><?php echo $image->title() ?></h2><h3><?php echo $image->subtitle() ?></h3></figcaption>
          <?php endif ?>
        </figure>
      <?php endforeach ?>
    </div>
  
  <?php endif ?>

<?php // HERO SINGULAR IMAGE ?>
<?php elseif ($image = $page->images()->filterBy('name', '==', 'hero')->first() and $page->hero()->isEmpty() or ($page->parent() == 'makers' or $page->parent() == 'handbooks' or $page->parent() == 'projects' or $page->parent() == 'groups') and $page->hero()->isEmpty()): ?>
  
  <?php if($page->parent() == 'makers' and !$page->images()->filterBy('name', '*=', 'hero')->first()): ?>
    <?php $image = new Asset('/assets/images/hero-add.png'); ?>
  <?php endif ?>

  <?php if($page->parent() == 'projects' and !$page->images()->filterBy('name', '*=', 'hero')->first()): ?>
    <?php $image = new Asset('/assets/images/hero-add.png'); ?>
  <?php endif ?>

  <?php if($page->parent() == 'groups' and !$page->images()->filterBy('name', '*=', 'hero')->first()): ?>
    <?php $image = new Asset('/assets/images/hero-add.png'); ?>
  <?php endif ?>

  <div id="hero" class="<?php echo ($image->ratio() >= 3.5) ? 'fullwidth' : '' ?><?php echo ($image->filename() == 'hero-add.png') ? ' invisible' : '' ?>">
    <div class="container">
      <?php if ($image->filename() == 'hero-add.png'): ?>
        <?php echo kirbytag(array('image' => $image->filename(), 'type' => 'hero', 'default' => 'true')) ?>
      <?php else: ?>
        <?php echo kirbytag(array('image' => $image->filename(), 'type' => 'hero')) ?>
      <?php endif ?>
    </div>
  </div>

  <?php // Maker Images in Project Pages ?>
  <?php
  /*
  <div class="section-makers">
    <?php foreach($page->makers()->split() as $maker): ?>
      <?php if($blah = $site->user($maker)): ?>
        <a class="maker" href="<?php echo $site->url() . "/makers/" . $maker ?>">
          <?php if($avatar = $site->user($maker)->avatar()): ?>
            <img src="<?php echo $site->user($maker)->avatar()->crop(60, 60)->url() ?>" alt="">
          <?php else: ?>
            <?php $actualpath = kirby()->roots()->index() . "/assets/images/profile-default.png" ?>
            <?php $regularpath = $site->url() . "/assets/images/profile-default.png" ?>
            <?php $defaultimage = new Media($actualpath,$regularpath) ?>
            <img src="<?php echo thumb($defaultimage, array('width' => 60, 'height' => 60, 'crop' => true))->url() ?>">
          <?php endif ?>
        </a>
      <?php endif ?>
    <?php endforeach ?>
  </div>
  */
  ?>

<?php endif ?>




