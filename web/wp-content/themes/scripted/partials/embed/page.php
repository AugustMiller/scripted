<? global $post ?>

<div <? post_class('page event'); ?>>

  <?= ScriptEd\Helpers::partial('post-info') ?>
  
  <h3><a href="<? the_permalink(); ?>"><?= the_title(); ?></a></h3>
  
  <div class="post-content">
    <? the_excerpt(); ?>
  </div>
  
</div>
