<?php

/**
 * @file
 * Contains \Drupal\user_registeration\Plugin\Block\RegFormBlock.
 */

namespace Drupal\loan_calculator\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides Custom Block.
 *
 * @Block(
 * id = "loan_calculator_form_block",
 * admin_label = @Translation("Loan Calculator Form Block"),
 * category = @Translation("Blocks")
 * )
 */
class LoanCalculatorBlock extends BlockBase {

    /**
     * {@inheritdoc}
     */
    public function build() {
        $build = array();

        $build['form'] = \Drupal::formBuilder()->getForm('Drupal\loan_calculator\Form\CalculatorForm');

        return $build;
    }

}
