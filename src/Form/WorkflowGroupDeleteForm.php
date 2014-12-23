<?php

/**
 * @file
 * Contains Drupal\workflow\Form\WorkflowGroupDeleteForm.
 */

namespace Drupal\workflow\Form;

use Drupal\Core\Entity\EntityConfirmFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;

/**
 * Builds the form to delete a WorkflowGroup.
 */
class WorkflowGroupDeleteForm extends EntityConfirmFormBase {

  /**
   * {@inheritdoc}
   */
  public function getQuestion() {
    return $this->t('Are you sure you want to delete %name?', array('%name' => $this->entity->label()));
  }

  /**
  * {@inheritdoc}
  */
  public function getCancelUrl() {
    return new Url('entity.workflow_group.list');
  }

  /**
  * {@inheritdoc}
  */
  public function getConfirmText() {
    return $this->t('Delete');
  }

  /**
  * {@inheritdoc}
  */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->entity->delete();
    drupal_set_message($this->t('Group %label has been deleted.', array('%label' => $this->entity->label())));
    $form_state->setRedirectUrl($this->getCancelUrl());
  }
}
