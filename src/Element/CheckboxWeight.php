<?php

namespace Drupal\vactory_register\Element;

use Drupal\Component\Serialization\Json;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Render\Element\FormElement;


/**
 * Provides an example element.
 *
 * @FormElement("checkbox_weight")
 */
class CheckboxWeight extends FormElement
{
    /**
     * {@inheritdoc}
     */
    public function getInfo()
    {
        $class = get_class($this);
        return [
            '#input' => TRUE,
            '#process' => [
                [$class, 'processCheckboxWeight'],
            ],
            // '#theme' => 'select',
        ];
    }


    /**
     * @param $element
     * @param FormStateInterface $form_state
     * @param $form
     * @return mixed
     */
    public static function processCheckboxWeight(&$element, FormStateInterface $form_state, &$form)
    {

        $element['field'] = [
            '#type' => 'checkbox',
            '#title' => t('Allow Multiple'),
            // '#default_value' => isset($default_value['allow_multiple']) && !empty($default_value['allow_multiple']) ? $default_value['allow_multiple'] : 0,
        ];
      
         $element['weight'] = array(
        '#type' => 'weight',
        '#title' => 'Weight' ,
        '#default_value' => $edit['weight'],
        '#delta' => 10,
        );

        return $element;
    }


} 