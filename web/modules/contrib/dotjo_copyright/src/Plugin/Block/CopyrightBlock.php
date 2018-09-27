<?php

namespace Drupal\dotjo_copyright\Plugin\Block;
use Drupal\Core\Block\BlockBase;


/**
 * Provides a 'copyright' block.
 *
 * @Block(
 *   id = "copyright_block",
 *   admin_label = @Translation("copyright"),
 *   category = @Translation("Custom dotjo copyright block ")
 * )
 */
class CopyrightBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
       $config = \Drupal::config('system.site');
    return array(
      '#type' => 'markup',
      '#markup' =>  ('' .'© '. '  ' .date(Y  ). ' ' .'' .t('Developed By').''.'<a href="http://dot.jo/en" target="_blank" > dot.jo</a>').' ' .t(' All Rights Reserved.')
    );
  }

} 

