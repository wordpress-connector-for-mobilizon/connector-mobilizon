<?php
namespace MobilizonConnector;

// Exit if this file is called directly.
if (!defined('ABSPATH')) {
  exit;
}
?>
<div class="<?php echo esc_attr($classNamePrefix); ?>_events-list">
  <?php
  /* translators: %s is replaced with the name of the group. */
  echo esc_html(sprintf(__('The group "%s" could not be found!', 'connector-mobilizon'), $groupName));
  ?>
</div>
