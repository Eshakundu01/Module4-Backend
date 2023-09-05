<?php

namespace Drupal\rest_api\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * The form which determines the data to provide as response.
 */
class ParameterForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'parameter_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['tags'] = [
      '#type' => 'entity_autocomplete',
      '#title' => $this->t('Tags'),
      '#target_type' => 'taxonomy_term',
      '#selection_settings' => [
        'target_bundles' => ['tags'],
      ],
      '#description' => 'Search a single tag',
    ];

    $form['count'] = [
      '#type' => 'number',
      '#title' => $this->t('Count of Data Item'),
    ];

    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Submit'),
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $form_state->setRedirect('rest.data', [], ['query' => [
      'tags' => $form_state->getValue('tags'),
      'count' => $form_state->getValue('count'),
    ]]);
  }
}
