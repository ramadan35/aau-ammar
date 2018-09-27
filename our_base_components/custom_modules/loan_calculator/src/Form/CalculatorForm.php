<?php

/**
 * @file
 * Contains \Drupal\loan_calculator\Form\RegisterForm.
 */

namespace Drupal\loan_calculator\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Component\Utility\UrlHelper;
use Drupal\Core\Url;
use Drupal\taxonomy\Entity\Term;


require_once("financial_class.php");
/**
 * RegisterForm form.
 */

class CalculatorForm extends FormBase {

    /**
     * {@inheritdoc}
     */
    public function getFormId() {
        return 'loan_calculator_form';
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(array $form, FormStateInterface $form_state) {
        
        $form['some_text1'] = array(
            '#markup' => '<p class="sub_title">'.t('Get an indication of what you coukd pay each month').'</p>'
        );
        $form['loan_type'] = [
            '#type' => 'select',
            '#required' => True,
            '#title' => $this->t('Loan Type'),
            "#options" => array(
                "1" => t("Housing loans"),
                "2" => t("Personal loan"),
            ),
        ];

        $form['amount'] = [
            '#type' => 'textfield',
            '#required' => True,
            '#maxlength_js' => TRUE,
            '#maxlength' => 20,
            '#title' => $this->t('Amount'),
            '#attributes' => [
                'placeholder' => $this->t(''),
            ]
        ];
        $form['interest_rate'] = [
            '#type' => 'textfield',
            '#required' => True,
            '#maxlength_js' => TRUE,
            '#maxlength' => 20,
            '#title' => $this->t('Interset Rate %'),
            '#attributes' => [
                'placeholder' => $this->t(''),
            ]
        ];
        $form['duration_months'] = [
            '#type' => 'textfield',
            '#required' => True,
            '#maxlength_js' => TRUE,
            '#maxlength' => 20,
            '#title' => $this->t('Duration Months'),
            '#attributes' => [
                'placeholder' => $this->t(''),
            ]
        ];
        $form['commissions_charges'] = [
            '#type' => 'textfield',
            '#required' => True,
            '#maxlength_js' => true,
            '#maxlength' => True,
            '#title' => $this->t('Commissions & Charges *'),
            '#attributes' => [
                'placeholder' => $this->t(''),
            ]
        ];
        $form['some_text2'] = array(
            '#markup' => '<p class="info">'.t('Commissions for the first year only (loan amount X 1%),the customer will pay off evaluation/reevaluation fees').'</p>'
        );
        $form['submit'] = [
            '#type' => 'submit',
            '#value' => $this->t('Calculator'),
            "#ajax" => array(
                "wrapper" => "ibanwrapper",
                'callback' => '::submitForm',
                "effect" => "fade"),
        ];
        $form["reset1"] = array(
            "#type" => "textfield",
            "#value" => "Clear",
            '#attributes' => array(
                'readonly' => 'readonly',
            ),
        );
        $form['ibanwrapper'] = array(
            '#type' => 'markup',
            '#prefix' => '<div id="ibanwrapper">',
            '#suffix' => '</div>',
            '#markup' => '',
        );
        $form['#suffix'] = '</div>';

        return $form;
    }

    /**
     * {@inheritdoc}
     */
    public function validateForm(array &$form, FormStateInterface $form_state) {

    }

    public function submitForm(array &$form, FormStateInterface $form_state) {
        $loan_type = $form_state->getValue('loan_type');
        $amount = $form_state->getValue('amount');
        $interest_rate = $form_state->getValue('interest_rate')/100;
        $duration_months = $form_state->getValue('duration_months');
        $commissions_charges = $form_state->getValue('commissions_charges');

        $f = new Financial;
        $loanpayment = $f->PMT(($interest_rate / 12), $duration_months, -$amount);
        
        $total = $loanpayment * 60;
        $full_total1 = sprintf("%.3f", ($total - $amount));

        $rate = $f->RATE($duration_months, $loanpayment, -($amount - $commissions_charges));  /* Second Formula */
        $effective_apr = pow(1 + ($rate), 12) - 1;
        $effective_apr1 = $effective_apr * 100;
        
        $loanpaymentfull = sprintf("%.3f", $loanpayment);
        $full_total = sprintf("%.3f", $full_total1);
        $effective_apr2 = sprintf("%.4f", $effective_apr1); 

        $element = $form['ibanwrapper'];

        $full_loan = '<div class="result">' .'<h2 class="result_label">' . t('Results').'</h2>'
                     . '<div class="value 1">'.'<div class="value-row monthly">'. $loanpaymentfull  . '<div class="labelof">'.t('Monthly Installment ').'</div>'.'</div>' . '</div>'.
                     '<div class="value 2">'.'<div class="value-row total">'. $full_total . '<div class="labelof">'.t('Total Interset Amount ').'</div>'.'</div>' . '</div>'
                     .'<div class="value 3">'.'<div class="value-row effective">'. $effective_apr2 .' %'.'<div class="labelof">'.t('Effective APR ').'</div>'.'</div>' . '</div>'
                     .'</div>';
        $close_button='<span role="button" class="close" data-dismiss="alert" aria-hidden="true" aria-label="Close">×</span>'; 
        
//        if (empty($amount) || empty($interest_rate) || empty($duration_months) || empty($commissions_charges) || empty($loan_type)) {
//            $element['#markup'] = '<div class="alert-danger alert">' . t('Please enter the required field(s)') . $close_button . '</div>';
//            return $element;
//        }
        if (!is_numeric($amount) || !is_numeric($interest_rate) || !is_numeric($duration_months) || !is_numeric($commissions_charges)) {
            $element['#markup'] = '<div class="alert-danger alert">' . t('The value should be a number.') . $close_button . '</div>';
            return $element;
        } else {
            $element['#markup'] = $full_loan;
            return $element;
        }
         $element['#markup'] = $full_loan;
            return $element;
    }

}

?>
