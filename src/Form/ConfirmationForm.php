<?php

namespace Drupal\vactory_register\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Implements an example form.
 */
class ConfirmationForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'user_confirmation';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {  
    $form['container'] = [
      '#type' => 'container',
      '#attributes' => [
        'class' => [
          'box-wrapper',
          'd-flex flex-row',
        ],
      ]
    ];

     for ($i = 1; $i <= 5; $i++) {
      $form['container']['item'.$i] = array(
        '#type' => 'number',
        '#wrapper_attributes' => [
          'style' => 'width:40px',
          'class' => 'mr-1'
        ],
      );
    }


    
    $form['actions']['#type'] = 'actions';
    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Confirmer'),
      '#button_type' => 'primary',
    ];
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $tempstore = \Drupal::service('tempstore.private');
    $store = $tempstore->get('vactory_register');
    $otp = (string)$store->get('otp');
    $code = '';
    for ($i = 1; $i <= 5; $i++) {
      $code = $code.$form_state->getValue('item'.$i);
    }
    

    if($code == $otp){
      $pass = $this->generate_password();
      $last_name = $store->get('field_last_name');
      $telephone = $store->get('field_telephone');
      $language = \Drupal::languageManager()->getCurrentLanguage()->getId();
      $user = \Drupal\user\Entity\User::create();

      // Mandatory.
      $user->setPassword($pass);
      $user->enforceIsNew();
      $user->setEmail($telephone.'@tpe.com');
      $user->setUsername($telephone);

      // Optional.
      $user->set('init', $telephone.'@tpe.com');
      $user->set('langcode', $language);
      $user->set('preferred_langcode', $language);
      $user->set('preferred_admin_langcode', $language);
      $user->set('field_telephone', $telephone);
      $user->set('field_last_name', $last_name);
      // $user->addRole('rid');
      $user->activate();

      // Save user account.
      $result = $user->save();

      $telephone_prefix = preg_replace("/^0/", "212", $telephone);
      $otp_service = \Drupal::service('vactory_otp.send_otp');
      $otp = $otp_service->sendOtpBySms($telephone_prefix, 'Votre mot de pass TPE est',$pass);
    }else{
      
    }
    


    
    
   
  }

  private function generate_password() {

    $allowed_characters = 'abcdefghijkmnopqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ23456789';
  
    $max = strlen($allowed_characters) - 1;
    $pass = '';
    for ($i = 0; $i < 10; $i++) {
      $pass .= $allowed_characters[random_int(0, $max)];
    }
    return $pass;
  }

}