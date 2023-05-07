<?php
// Exit if this file is called directly.
if (!defined('ABSPATH')) {
  exit;
}
?>
<div class="<?php echo esc_attr($classNamePrefix); ?>_events-list-php">
  <ul>
    <?php foreach($events as $event) { ?>
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
