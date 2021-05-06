<?php
// Exit if this file is called directly.
if (!defined('ABSPATH')) {
  exit;
}
?>
<p>
  <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Title', 'connector-mobilizon'); ?>:</label>
  <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>">
</p>
<p>
  <label for="<?php echo esc_attr($this->get_field_id('eventsCount')); ?>"><?php esc_html_e('Number of events to show', 'connector-mobilizon'); ?>:</label>
  <input class="tiny-text" id="<?php echo esc_attr($this->get_field_id('eventsCount')); ?>" name="<?php echo esc_attr($this->get_field_name('eventsCount')); ?>" type="number" value="<?php echo esc_attr($eventsCount); ?>" min="1">
</p>
<p>
  <label for="<?php echo esc_attr($this->get_field_id('groupName')); ?>"><?php esc_html_e('Group name (optional)', 'connector-mobilizon'); ?>:</label>
  <input class="widefat" id="<?php echo esc_attr($this->get_field_id('groupName')); ?>" name="<?php echo esc_attr($this->get_field_name('groupName')); ?>" type="text" value="<?php echo esc_attr($groupName); ?>">
</p>
