<?php
// Exit if this file is called directly.
if (!defined('ABSPATH')) {
  exit;
}
?>
<input class="regular-text code"
  id="<?php echo esc_attr($args['label_for']); ?>"
  name="<?php echo esc_attr(self::$OPTION_NAME_URL); ?>"
  type="url"
  value="<?php echo esc_attr($url); ?>">
<p class="description">
  <?php esc_html_e('The URL of the Mobilizon instance whose events you want to list, e.g. https://example.net', $textDomain); ?>
</p>
