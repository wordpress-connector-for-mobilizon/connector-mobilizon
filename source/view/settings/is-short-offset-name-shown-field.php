<?php
// Exit if this file is called directly.
if (!defined('ABSPATH')) {
  exit;
}
?>
<input id="<?php echo esc_attr($args['label_for']); ?>"
  name="<?php echo esc_attr(self::$OPTION_NAME_IS_SHORT_OFFSET_NAME_SHOWN); ?>"
  type="checkbox"
  <?php echo $isShortOffsetNameShown == true ? 'checked' : ''; ?>>
<p class="description">
  <?php esc_html_e('The time zone of this WordPress installation is used. Whether the current offset should be displayed in brackets after the time, e.g. 10:00 (UTC)', 'connector-mobilizon'); ?>
</p>
