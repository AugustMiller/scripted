<?

  /*
    Helpers
  */

  # ACF Customizations
  require_once("config/acf.php");

  # Mailchimp API
  require_once("lib/Mailchimp.php");
  require_once("config/mc.php");

  # Stripe
  require_once("lib/stripe-php/lib/Stripe.php");
  require_once("config/stripe.php");

  # Underscore PHP Port
  require_once("lib/Underscore.php");

  # PHP Markdown
  require_once("lib/Parsedown.php");
  $Parsedown = new Parsedown();

  # Get Site Option
  function se_option ( $option = false ) {
    $options = get_fields('option');
    if ( $option && isset($options[$option]) ) {
      return $options[$option];
    } else {
      return false;
    }
  }

  # Pretty Print
  function pp ( $var ) {
    echo '<pre>';
    print_r($var);
    echo '</pre>';
  }

  # Log Object to JavaScript Console
  function cc ( $var ) {
    echo '<script>console.log(';
    print_r( json_encode($var) );
    echo ');</script>';
  }

  # Process Text

  function markdown ( $text ) {
    return $Parsedown->text( $text );
  }

  function speak_number ( $number ) {
    $speakables = array("zero","one","two","three","four","five","six","seven","eight","nine","ten");
    return ( ( $number > abs(10) || $number < 0 ) ? $number : $speakables[abs($number)] );
  }

  # Tags
  function se_meta_tags ( ) {
    if ( $tags = se_option('tags') ) {
      $tag_list = __::pluck( $tags, 'tag');
      return implode(',', $tag_list);
    }
  }

  # Partials
  function get_partial ( $name ) {
    return ( get_template_directory() . '/partials/' . $name .'.php' );
  }

  # Post Embeds
  function get_embed ( $name ) {
    include ( get_template_directory() . '/embed/' . $name . '.php' );
  }

  # Formatted Page Titles
  function se_page_title ( $post ) {
    if ( is_singular( array( 'post', 'se_news', 'se_event', 'se_press_kit', 'se_project', 'se_resource', 'se_mention' ) ) ) {
      return '<span class="parent-page archive"><a href="' . get_post_type_archive_link( $post->post_type ) . '">' . get_post_type_object( $post->post_type )->labels->singular_name . '</a>:</span> <span class="subpage-title">' . get_the_title() . '</span>';
    } else if ( is_archive() ) {
      return post_type_archive_title(null, false);
    } else if ( is_single() or is_page() ) {
      if ( count( $ancestors = get_post_ancestors($post) ) ) {
        $parent = __::first($ancestors);
        return '<span class="parent-page"><a href="' . get_permalink($parent) . '">' . get_the_title($parent) . '</a>:</span> <span class="subpage-title">' . get_the_title() . '</span>';
      } else {
        return get_the_title();
      }
    } else {
      return "lol";
    }
  }

  # Sibling/Child Page Links
  function se_page_links ( $page ) {
    $tree = get_post_ancestors( $page );
    if ( !count( $tree ) ) {
      // No parent pages. Get the children pages.
      return get_posts( array(
        'post_type' => 'page',
        'post_status' => 'publish',
        'post_parent' => $page->ID,
        'orderby' => 'menu_order'
      ));
    } else {
      // There are parent pages.
      return get_posts( array(
        'post_type' => 'page',
        'post_status' => 'publish',
        'post_parent' => __::first($tree),
        'orderby' => 'menu_order'
      ));
    }
  }


  /*
    Custom Post Types & Configuration

    To allow functions.php to express the primary features of the site, we'll split out the Custom Post Type Registrations into their own files. Each CPT file contains a few initializers, triggered by a management function attached to the init event.
  */

  # Narrative / Story
  require_once('config/narratives.php');

  # Volunteer Applications
  require_once('config/volunteers.php');

  # Post Override
  require_once('config/post.php');

  # Aggregator
  require_once('config/aggregator.php');

  # Events
  require_once('config/events.php');

  # Resources
  require_once('config/resources.php');

  # Student Projects
  require_once('config/projects.php');

  # Media Mentions
  require_once('config/mentions.php');

  # Press Releases & Kits
  require_once('config/press-kits.php');

  # Donors
  require_once('config/gifts.php');

  add_action('init', 'init_custom_post_types');

  function init_custom_post_types ( ) {
    # add_cpt_narratives();
    # add_cpt_volunteer_applications();
    # add_cpt_news();

    add_cpt_aggregator();
    add_cpt_post_override();

    add_cpt_events();
    add_cpt_resources();
    add_cpt_projects();
    add_cpt_pingbacks();
    add_cpt_press_kits();
    add_cpt_gifts();

    add_post_type_support('page', 'excerpt');
  }

  add_filter( 'pre_get_posts', 'add_cpt_to_main_query' );

  function add_cpt_to_main_query ( $query ) {
    if ( $query->get('post_type') == 'se_aggregator' && ! is_admin() ) {
      $query->set( 'post_type', array( 'post', 'se_event', 'se_resource', 'se_project' ) );
    }
    return $query;
  }

  /*
    Site-wide Options
  */

  add_filter( 'pre_get_shortlink', '__return_empty_string' );

  /*
    Menus
  */

  # Header
  register_nav_menu( 'primary', 'Header Navigation Menu' );

  # Blog Sections
  register_nav_menu( 'blog', 'Blog Sidebar' );

  # Press Sections
  register_nav_menu( 'press', 'Press Information Sidebar' );

  # About
  register_nav_menu( 'about', 'About ScriptEd page collection');


  # Spiff up the Administration Interface

  add_action('admin_init', 'init_admin_customizations');

  function init_admin_customizations ( ) {
    
  }

  /*
    Scripts & Styles
  */

  # Stylesheets

  function se_register_theme_styles ( ) {
    wp_register_style('main', get_template_directory_uri() . '/stylesheets/se.css' );
    wp_enqueue_style('main');
  }

  add_action( 'wp_enqueue_scripts', 'se_register_theme_styles' );


  # Scripts

  function se_register_theme_scripts ( ) {
    if ( SE_ENVIRONMENT == 'development' ) {

      require_once('config/js-development.php');

    } else {

      require_once('config/js-production.php');
#//use.typekit.net/fxj8drj.js
    }
  }

  add_action( 'wp_enqueue_scripts', 'se_register_theme_scripts' );


  /*
    Mailchimp & Newsletter Signup
  */

