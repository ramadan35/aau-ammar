<?php

/**
 * @file
 * Contains \Drupal\user_registeration\Plugin\Block\RegFormBlock.
 */

namespace Drupal\iban_calculator\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides Custom Block.
 *
 * @Block(
 * id = "iban_calculator_form_block",
 * admin_label = @Translation("Iban Calculator Form Block"),
 * category = @Translation("Blocks")
 * )
 */
class IbanCalculatorBlock extends BlockBase {

    /**
     * {@inheritdoc}
     */
    public function build() {
        $build = array();

        $build['form'] = \Drupal::formBuilder()->getForm('Drupal\iban_calculator\Form\CalculatorForm');

        return $build;
    }

}
