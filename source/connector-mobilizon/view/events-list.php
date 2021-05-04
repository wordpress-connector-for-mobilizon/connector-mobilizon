<?php
// Exit if this file is called directly.
if (!defined('ABSPATH')) {
  exit;
}
?>
<ul class="<?php echo esc_attr($classNamePrefix); ?>_events-list"
  data-url="<?php echo esc_attr($url); ?>"
  data-locale="<?php echo esc_attr($locale); ?>"
  data-maximum="<?php echo esc_attr($eventsCount); ?>"
  data-group-name="<?php echo esc_attr($groupName); ?>">
  <li style="display: none;"><?php echo esc_html_e('The events could not be loaded!', $textDomain); ?></li>
</ul>
