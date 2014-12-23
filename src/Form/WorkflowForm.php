<?php

/**
 * @file
 * Contains Drupal\workflow\Form\WorkflowForm.
 */

namespace Drupal\workflow\Form;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityForm;
use Drupal\Core\Form\FormStateInterface;
use Drupal\workflow\Entity\WorkflowGroup;

class WorkflowForm extends EntityForm
{

  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state) {
    $form = parent::form($form, $form_state);

    $workflow = $this->entity;
    $form['label'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Label'),
      '#maxlength' => 255,
      '#default_value' => $workflow->label(),
      '#required' => TRUE,
    );
    $form['id'] = array(
      '#type' => 'machine_name',
      '#default_value' => $workflow->id(),
      '#machine_name' => array(
        'exists' => '\Drupal\workflow\Entity\Workflow::load',
      ),
      '#disabled' => !$workflow->isNew(),
    );
    // @todo We probably want to move the group selection to the screen
    // before the add form, and remove the form field completely.
    $groups = WorkflowGroup::loadMultiple();
    $group_options = array();
    foreach ($groups as $group) {
      $group_options[$group->id()] = $group->label();
    }
    $form['group'] = array(
      '#type' => 'select',
      '#title' => $this->t('Group'),
      '#options' => $group_options,
      '#default_value' => $workflow->getGroup(),
      '#required' => TRUE,
    );

    return $form;
  }

  /**
  * {@inheritdoc}
  */
  public function save(array $form, FormStateInterface $form_state) {
    $workflow = $this->entity;
    $status = $workflow->save();

    if ($status) {
      drupal_set_message($this->t('Saved the %label workflow.', array(
        '%label' => $workflow->label(),
      )));
    }
    else {
      drupal_set_message($this->t('The %label workflow was not saved.', array(
        '%label' => $workflow->label(),
      )));
    }
    $form_state->setRedirect('entity.workflow.list');
  }
}
