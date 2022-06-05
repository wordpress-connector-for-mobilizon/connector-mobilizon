<?php
// Exit if this file is called directly.
if (!defined('ABSPATH')) {
  exit;
}
?>
<div class="<?php echo esc_attr($classNamePrefix); ?>_events-list"
  data-maximum="<?php echo esc_attr($eventsCount); ?>"
  data-group-name="<?php echo esc_attr($groupName); ?>">
  <div style="display: none;"><?php esc_html_e('The events could not be loaded!', 'connector-mobilizon'); ?></div>
  <div style="display: none;"><?php esc_html_e('The group could not be found!', 'connector-mobilizon'); ?></div>
  <ul>
    <li><?php esc_html_e('Loading...', 'connector-mobilizon'); ?></li>
  </ul>
</div>
