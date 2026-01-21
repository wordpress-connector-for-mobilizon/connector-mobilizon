<?php
namespace MobilizonConnector;

// Exit if this file is called directly.
if (!defined('ABSPATH')) {
  exit;
}
?>
<div class="<?php echo esc_attr($classNamePrefix); ?>_events-list">
  <ul class="<?php echo esc_attr($classNamePrefix); ?>_events-list__list" style="list-style-type: none; padding-left: 0;">
    <?php foreach ($events as $event) { ?>
    <li class="<?php echo esc_attr($classNamePrefix); ?>_events-list__event" style="line-height: 150%; margin-top: 20px;">
      <?php if (isset($event['picture'])) { ?>
      <div class="<?php echo esc_attr($classNamePrefix); ?>_events-list__picture">
        <img alt="<?php echo esc_attr($event['picture']['alt']); ?>" src="<?php echo esc_attr($event['picture']['base64']); ?>">
      </div>
      <?php } ?>
      <div class="<?php echo esc_attr($classNamePrefix); ?>_events-list__title">
        <a href="<?php echo esc_attr($event['url']); ?>"><?php echo esc_html($event['title']); ?></a>
      </div>
      <div class="<?php echo esc_attr($classNamePrefix); ?>_events-list__date">
        <?php echo esc_html(LineFormatter::format_date_time($timeZone, $dateFormat, $timeFormat, $event['beginsOn'], $event['endsOn'])); ?>
      </div>
      <?php if (isset($event['physicalAddress'])) { ?>
      <div class="<?php echo esc_attr($classNamePrefix); ?>_events-list__location">
        <?php echo esc_html(LineFormatter::format_location($event['physicalAddress']['description'], $event['physicalAddress']['locality'])) ?>
      </div>
      <?php } ?>
    </li>
    <?php } ?>
  </ul>
  <div class="<?php echo esc_attr($classNamePrefix); ?>_events-list__more-section">
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
</div>
