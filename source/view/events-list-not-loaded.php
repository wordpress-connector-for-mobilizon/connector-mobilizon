<?php
namespace MobilizonConnector;

// Exit if this file is called directly.
if (!defined('ABSPATH')) {
  exit;
}
?>
<div class="<?php echo esc_attr($classNamePrefix); ?>_events-list <?php echo esc_attr($classNamePrefix); ?>_events-list--error">
  <?php esc_html_e('The events could not be loaded!', 'connector-mobilizon'); ?>
</div>
