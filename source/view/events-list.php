<?php
// Exit if this file is called directly.
if (!defined('ABSPATH')) {
  exit;
}
?>
<div class="<?php echo esc_attr($classNamePrefix); ?>_events-list-php">
  <div class="general-error" style="display: none;"><?php esc_html_e('The events could not be loaded!', 'connector-mobilizon'); ?></div>
  <div class="group-not-found" style="display: none;"><?php esc_html_e('The group could not be found!', 'connector-mobilizon'); ?></div>
  <ul>
    <?php foreach($data['data']['events']['elements'] as $event) { ?>
    <li>
      <a href="<?php echo esc_attr($event['url']); ?>"><?php echo esc_html_e($event['title']); ?></a>
      <br>
      <?php echo esc_html_e(Formatter::format_date($locale, $timeZone, $event['beginsOn'], $event['endsOn'], $isShortOffsetNameShown)); ?>
      <?php if (isset($event['physicalAddress'])) { ?>
      <br>
      <?php echo esc_html_e(Formatter::format_location($event['physicalAddress']['description'], $event['physicalAddress']['locality'])) ?>
      <?php } ?>
    </li>
    <?php } ?>
  </ul>
</div>
