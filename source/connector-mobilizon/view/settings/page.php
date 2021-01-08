<?php
// Exit if this file is called directly.
if (!defined('ABSPATH')) {
  exit;
}
?>
<div class="wrap">
  <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
  <form action="options.php" method="post">
    <?php
    settings_fields(self::$OPTIONS_GROUP_NAME);
    do_settings_sections(self::$PAGE_NAME);
    submit_button('Save');
    ?>
  </form>
</div>
