<?php

namespace Drupal\vactory_register\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

class NewUserRegisterForm extends FormBase {

  /**
   * @inheritDoc
   */
  public function getFormId()
  {
    return 'vactory_form_user_register';
  }

  /**
   * @inheritDoc
   */
  public function buildForm(array $form, FormStateInterface $form_state)
  {
    

    $is_anonymous = \Drupal::currentUser()->isAnonymous();
    $registration_form = NULL;
    if ($is_anonymous) {
      $entity = \Drupal::entityTypeManager()
        ->getStorage('user')
        ->create([]);
      $formObject = \Drupal::entityTypeManager()
        ->getFormObject('user', 'register')
        ->setEntity($entity);
      $registration_form = \Drupal::formBuilder()->getForm($formObject);
    }
    
    $form['#form_register'] = $registration_form;
    $form['#theme'] = 'vactory_register_form';
    $config = $this->config('vactory_register.settings')->get('allowed_fields');
    asort($config);
    $form['#extension'] = array_keys($config);
    return $form;
  }

  /**
   * @inheritDoc
   */
  public function submitForm(array &$form, FormStateInterface $form_state)
  {
    
  }
}
