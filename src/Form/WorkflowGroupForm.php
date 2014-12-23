<?php

/**
 * @file
 * Contains Drupal\workflow\Form\WorkflowGroupForm.
 */

namespace Drupal\workflow\Form;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityForm;
use Drupal\Core\Form\FormStateInterface;

class WorkflowGroupForm extends EntityForm
{

  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state) {
    $form = parent::form($form, $form_state);

    $workflow_group = $this->entity;
    $form['label'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Label'),
      '#maxlength' => 255,
      '#default_value' => $workflow_group->label(),
      '#required' => TRUE,
    );
    $form['id'] = array(
      '#type' => 'machine_name',
      '#default_value' => $workflow_group->id(),
      '#machine_name' => array(
        'exists' => '\Drupal\workflow\Entity\WorkflowGroup::load',
      ),
      '#disabled' => !$workflow_group->isNew(),
    );
    $form['description'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Description'),
      '#default_value' => $workflow_group->getDescription(),
    );

    return $form;
  }

  /**
  * {@inheritdoc}
  */
  public function save(array $form, FormStateInterface $form_state) {
    $workflow_group = $this->entity;
    $status = $workflow_group->save();

    if ($status) {
      drupal_set_message($this->t('Saved the %label group.', array(
        '%label' => $workflow_group->label(),
      )));
    }
    else {
      drupal_set_message($this->t('The %label group was not saved.', array(
        '%label' => $workflow_group->label(),
      )));
    }
    $form_state->setRedirect('entity.workflow_group.list');
  }
}
