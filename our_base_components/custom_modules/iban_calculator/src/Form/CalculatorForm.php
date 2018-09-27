<?php

/**
 * @file
 * Contains \Drupal\iban_calculator\Form\RegisterForm.
 */

namespace Drupal\iban_calculator\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Component\Utility\UrlHelper;
use Drupal\Core\Url;
use Drupal\taxonomy\Entity\Term;

/**
 * RegisterForm form.
 */
class CalculatorForm extends FormBase {

    /**
     * {@inheritdoc}
     */
    public function getFormId() {
        return 'iban_calculator_form';
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(array $form, FormStateInterface $form_state) {
        
        $nids = \Drupal::entityQuery('node')->condition('type', 'Machine_name_of_your_content_type')->execute();
        $nodes = \Drupal\node\Entity\Node::loadMultiple($nids);   
        $language = \Drupal::languageManager()->getCurrentLanguage()->getId();
        $selectBranchesid = array();

        foreach ($nodes as $key => $node) {

            if ($language == 'en') {
                $branch_id = $node->get('Machine_name_of_your_field')->value;
                $branch_name = $node->get('title')->getString();
                $selectBranchesid[$branch_id] = $branch_name;

                
            }
            if ($language == 'ar') {
                if ($node->hasTranslation($language)) {
                    $branch_id = $node->get('Machine_name_of_your_field')->value;
                    $branch_name = \Drupal::entityManager()->getTranslationFromContext($node)->get('title')->getString();
                    $selectBranchesid[$branch_id] = $branch_name;
                }
            }
        }
        $form['some_text1'] = array(
            '#markup' => '<p class="sub_title">'.t('To genrate you IBAN number please fill the below information:').'</p>'
        );
        $form['branch_id'] = [
            '#type' => 'select',
            '#required' => false,
            '#title' => $this->t('Branch ID *'),
            "#options" => $selectBranchesid,
        ];

        $form['customer_number'] = [
            '#type' => 'textfield',
            '#required' => TRUE,
            '#maxlength_js' => TRUE,
            '#maxlength' => 7,
            '#title' => $this->t('Customer Number'),
            '#attributes' => [
                'placeholder' => $this->t(''),
            ]
        ];
        $form['currency'] = [
            '#type' => 'select',
            '#required' => false,
            '#title' => $this->t('Currency *'),
            "#options" => $this->getVocabularyTermsArray('Machine_name_of_your_vocabulary1'),
        ];
        $form['ledger'] = [
            '#type' => 'select',
            '#required' => false,
            '#title' => $this->t('Ledger *'),
            "#options" => $this->getVocabularyTermsArray('Machine_name_of_your_vocabulary2'),
        ];
        $form['sub_account'] = [
            '#type' => 'textfield',
            '#required' => TRUE,
            '#maxlength_js' => TRUE,
            '#maxlength' => 3,
            '#title' => $this->t('Sub Account'),
            '#attributes' => [
                'placeholder' => $this->t(''),
            ]
        ];
        $form['ibanwrapper'] = array(
            '#type' => 'markup',
            '#prefix' => '<div id="ibanwrapper">',
            '#suffix' => '</div>',
            '#markup' => '',
        );
        $form["reset1"] = array(
            "#type" => "textfield",
            "#value" => "Clear",
            '#attributes' => array(
                'readonly' => 'readonly',
            ),
        );
        $form['submit'] = [
            '#type' => 'submit',
            '#value' => $this->t('Generate IBAN'),
            "#ajax" => array(
                "wrapper" => "ibanwrapper",
                'callback' => '::submitForm',
                "effect" => "fade"),
        ];
        $form['#suffix'] = '</div>';

        return $form;
    }

    public function getVocabularyTermsArray($vocabulary_name) {
        $vocabulary = $vocabulary_name;
        $language = \Drupal::languageManager()->getCurrentLanguage()->getId();
        $query = \Drupal::entityQuery('taxonomy_term');
        $query->condition('vid', $vocabulary);
        $query->sort('weight');
        $tids = $query->execute();
        $terms = \Drupal\taxonomy\Entity\Term::loadMultiple($tids);
        $termsArray = [];

        foreach ($terms as $term) {
            if ($term->hasTranslation($language)) {
                $translated_term = \Drupal::service('entity.repository')->getTranslationFromContext($term, $language);
                $tid = $term->id();
                $value = $term->field_value->value;
                $termsArray += [
                    $value => $translated_term->getName()
                ];
            }
        }
        return $termsArray;
    }

    /**
     * {@inheritdoc}
     */
    public function validateForm(array &$form, FormStateInterface $form_state) {
//      $branch_id = $form_state->getValue('branch_id');
//      if(isEmpty($branch_id)){
//           $form_state->setErrorByName('branch_id', $this->t('Mobile number is too short.'));
//      }
    }

    /**
     * {@inheritdoc}
     */
    public function submitForm(array &$form, FormStateInterface $form_state) {
        $branch_id = $form_state->getValue('branch_id');
        $customer_number = $form_state->getValue('customer_number');
        $currency = $form_state->getValue('currency');
        $ledger = $form_state->getValue('ledger');
        $sub_account = $form_state->getValue('sub_account');

        $ajib = "AJIB";

        $branchIDx10 = $branch_id * 10;

        $customerNumberLength = strlen($customer_number);
        $customer_number = str_repeat("0", 8 - $customerNumberLength) . $customer_number;

        $currencyLenght = strlen($currency);
        $currency = str_repeat("0", 3 - $currencyLenght) . $currency;

        $ledgerLenght = strlen($ledger);
        $ledger = str_repeat("0", 4 - $ledgerLenght) . $ledger;

        $sub_accLenght = strlen($sub_account);
        $sub_acc = str_repeat("0", 3 - $sub_accLenght) . $sub_acc;
        
        $customer_number2 = sprintf("%07d", $customer_number);
        $sub_account2 = sprintf("%03d", $sub_account);
        
        $formula1 = $ajib . $branchIDx10 . $customer_number2 . $currency . $ledger . $sub_account2;
        $formula2 = $formula1 . "JO00";
        $mid = substr($formula2, 4, 22);
        $formula3 = "10191811" . $mid . "192400";

        $leftformula3 = substr($formula3, 0, 9);
        $D7 = ($leftformula3) - (int) ($leftformula3 / 97) * 97;
        $formula4 = str_replace($leftformula3, $D7, $formula3);

        $leftformula4 = substr($formula4, 0, 9);
        $D8 = ($leftformula4) - (int) ($leftformula4 / 97) * 97;

        $formula5 = str_replace($leftformula4, $D8, $formula4);

        $leftformula5 = substr($formula5, 0, 9);
        $D9 = ($leftformula5) - (int) ($leftformula5 / 97) * 97;

        $formula6 = str_replace($leftformula5, $D9, $formula5);


        $leftformula6 = substr($formula6, 0, 9);
        $D10 = ($leftformula6) - (int) ($leftformula6 / 97) * 97;

        $formula7 = str_replace($leftformula6, $D10, $formula6);

        $leftformula7 = substr($formula6, 0, 9);
        $D11 = ($leftformula7) - (int) ($leftformula7 / 97) * 97;

        $formula8 = str_replace($leftformula7, $D11, $formula7);


        $leftformula7 = substr($formula7, 0, 9);
        $D11 = ($leftformula7) - (int) ($leftformula7 / 97) * 97;

        $mid = substr($formula2, 26, 2);

        $D12 = 98 - $D11;
        if ($D12 < 10) {
            $D12 = '0' . $D12;
        }

        $IBAN = 'JO' . $D11 . $formula1;

        $IBAN = chunk_split($IBAN, 4, ' ');

        $element = $form['ibanwrapper'];

        //Split after 4 digites
        $full_iban = '<div class="result">'.'<h2 class="result_label">' . t('Results') .'</h2>'. '<div class="value">'. $IBAN. '</div>' . '</div>';


        $close_button = '<span role="button" class="close" data-dismiss="alert" aria-hidden="true" aria-label="Close">×</span>';

        if (empty($branch_id) || empty($currency) || empty($ledger)) {
            $element['#markup'] = '<div class="alert-danger alert">' . t('Please enter the required field(s)') . $close_button . '</div>';
            return $element;
        }
        if (!is_numeric($customer_number) || !is_numeric($sub_account)) {
            $element['#markup'] = '<div class="alert-danger alert">' . t('The value should be a number.') . $close_button . '</div>';
            return $element;
        } else {
            $element['#markup'] = $full_iban;
            return $element;
        }
    }

}

?>
