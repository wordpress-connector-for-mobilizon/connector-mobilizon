<?php
namespace MobilizonConnector;

// Exit if this file is called directly.
if (!defined('ABSPATH')) {
  exit;
}
?>
<div class="<?php echo esc_attr($classNamePrefix); ?>_events-list">
  <ul style="list-style-type: none; padding-left: 0;">
    <?php foreach ($events as $event) { ?>
    <li style="line-height: 150%; margin-top: 20px;">
      <?php if (isset($event['picture'])) { ?>
      <img alt="<?php echo esc_attr($event['picture']['alt']); ?>" src="<?php echo esc_attr($event['picture']['base64']); ?>" style="display: block; max-width: 100%;">
      <?php } ?>
      <a href="<?php echo esc_attr($event['url']); ?>"><?php echo esc_html($event['title']); ?></a>
      <br>
      <?php echo esc_html(LineFormatter::format_date_time($timeZone, $dateFormat, $timeFormat, $event['beginsOn'], $event['endsOn'])); ?>
      <?php if (isset($event['physicalAddress'])) { ?>
      <br>
      <?php echo esc_html(LineFormatter::format_location($event['physicalAddress']['description'], $event['physicalAddress']['locality'])) ?>
      <?php } ?>
    </li>
    <?php } ?>
  </ul>
  <?php if (isset($groups)) { ?>
  <?php foreach ($groups as $group) { ?>
  <a href="<?php echo esc_attr($group['url']); ?>" class="button" style="display:inline-block; margin-top: 20px;">
    <?php
    /* translators: %s: a group name */
    printf(esc_html__('Show more events of %s', 'connector-mobilizon'), esc_html($group['name']));
    ?>
  </a>
  <?php } ?>
  <?php } else { ?>
  <a href="<?php echo esc_attr($showMoreUrl); ?>" class="button" style="display:inline-block; margin-top: 20px;">
    <?php esc_html_e('Show more events', 'connector-mobilizon'); ?>
  </a>
  <?php } ?>
</div>
