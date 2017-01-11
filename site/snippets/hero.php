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
            <figcaption><span><?php echo $image->title() ?></span><br><span><?php echo $image->subtitle() ?></span></figcaption>
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
<?php elseif ($image = $page->images()->filterBy('name', '==', 'hero')->first() and $page->hero()->isEmpty()): ?>

  <div id="hero" class="<?php echo ($image->ratio() >= 3.5) ? 'fullwidth' : '' ?>">
    <div class="container">
      <?php echo kirbytag(array('image' => $image->filename(), 'type' => 'hero')) ?>
    </div>
  </div>
  
<?php // NO HERO ?>
<?php else: ?>

  <div class="fullwidth">
    <div class="container">
      <div id="hero-add"><span>Add a featured image</span></div>
    </div>
  </div>

<?php endif ?>

























