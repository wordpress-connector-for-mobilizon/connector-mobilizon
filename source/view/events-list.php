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
  data-group-name="<?php echo esc_attr($groupName); ?>"
  data-time-zone="<?php echo esc_attr($timeZone); ?>"
  <?php echo $isShortOffsetNameShown ? 'data-is-short-offset-name-shown' : ''; ?>>
  <li style="display: none;"><?php esc_html_e('The events could not be loaded!', 'connector-mobilizon'); ?></li>
  <li style="display: none;"><?php esc_html_e('The group could not be found!', 'connector-mobilizon'); ?></li>
</ul>

<?php /*print_r($data);*/ ?>
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
