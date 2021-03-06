<section class="social border-top text-grey-dark link-orange">
  <div class="wrapper">
    <div class="column col-3 tablet-full">
      <div class="copyright small caps">
        &copy;<?= date('Y') ?> <span title="Hi, friend!"><?= bloginfo('title') ?></span>
      </div>
    </div>
    <div class="column col-9 tablet-full">
      <div class="social-links">
        <? if ( $contact_email = ScriptEd\Helpers::option('contact_email') ) { ?>
          <span class="small caps link email">
            Send Us An <a href="mailto:<?= $contact_email ?>" title="Email ScriptEd">email</a>
          </span>
        <? } ?>
        <? if ( $twitter = ScriptEd\Helpers::option('twitter') ) { ?>
          <span class="small caps link twitter">
            Follow Us On <a href="https://twitter.com/<?= $twitter ?>" target="_blank" title="Follow us on Twitter">Twitter</a>
          </span>
        <? } ?>
        <? if ( $facebook = ScriptEd\Helpers::option('facebook') ) { ?>
          <span class="small caps link facebook">
            Like Us On <a href="<?= $facebook ?>" target="_blank" title="Like us on FaceBook">FaceBook</a>
          </span>
        <? } ?>
        <? if ( $instagram = ScriptEd\Helpers::option('instagram') ) { ?>
          <span class="small caps link instagram">
            Find Us On <a href="<?= $instagram ?>" target="_blank" title="Find us on Instagram">Instagram</a>
          </span>
        <? } ?>
      </div>
    </div>
  </div>
</section>
