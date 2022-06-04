<?php
// Exit if this file is called directly.
if (!defined('ABSPATH')) {
  exit;
}
?>
<ul class="<?php echo esc_attr($classNamePrefix); ?>_events-list"
  data-maximum="<?php echo esc_attr($eventsCount); ?>"
  data-group-name="<?php echo esc_attr($groupName); ?>">
  <li style="display: none;"><?php esc_html_e('The events could not be loaded!', 'connector-mobilizon'); ?></li>
  <li style="display: none;"><?php esc_html_e('The group could not be found!', 'connector-mobilizon'); ?></li>
</ul>
