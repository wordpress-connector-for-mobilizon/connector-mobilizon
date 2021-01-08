<?php
// Exit if this file is called directly.
if (!defined('ABSPATH')) {
  exit;
}
?>
<ul class="<?php echo esc_attr($classNamePrefix); ?>_events-list"
  data-maximum="<?php echo esc_attr($eventsCount); ?>"
  data-url="<?php echo esc_attr($url); ?>">
  <li style="display: none;"><?php echo esc_html_e('The events could not be loaded!', $textDomain); ?></li>
</ul>
