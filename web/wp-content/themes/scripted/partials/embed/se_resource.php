<? global $post ?>
<? $resource = get_fields(); ?>

<div <? post_class('post resource'); ?>>

  <?= ScriptEd\Helpers::partial('post-info', ['post' => $post]) ?>
  
  <h3><a href="<? the_permalink() ?>"><?= the_title(); ?></a></h3>

  <? if ( $resource['link'] ) { ?>
    <div class="post-quote">
      <blockquote>
        <?= $resource['quote'] ?>
      </blockquote>
      <? if ( $resource['link_source'] ) { ?>
        <div class="attribution small text-grey-dark">
          <a href="<?= $resource['link'] ?>"><?= $resource['link_source'] ?></a>
        </div>
      <? } ?>
    </div>
  <? } ?>

  <div class="post-content">
    <?= the_content(); ?>
  </div>

  <? if ( $resource['attachment'] ) { ?>
    <div class="download-box clearfix">
      <a class="button small blue float-right" href="<?= $resource['attachment']['url'] ?>">Download</a>
      <h6>
        <span class="icon-file icon float-left large text-blue"></span>
        <?= $resource['attachment']['title'] ?>
      </h6>
    </div>
  <? } ?>

</div>
