<?php

/**
 * @file
 * Contains Drupal\workflow\Form\WorkflowForm.
 */

namespace Drupal\workflow\Form;

use Drupal\Component\Utility\Html;
use Drupal\Core\Entity\EntityForm;
use Drupal\Core\Form\FormStateInterface;
use Drupal\workflow\Entity\WorkflowGroup;

class WorkflowForm extends EntityForm {

  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state) {
    $form = parent::form($form, $form_state);

    $workflow = $this->entity;

    // Make sure we've got a consistent id for edit/add operations.
    $form_id = Html::getUniqueId('workflow_manage_form');
    $form['#id'] = $form_id;

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

    $form['states'] = array(
      '#type' => 'table',
      '#header' => array(t('State'), t('Label'), t('Weight'), t('Operations')),
      '#tabledrag' => array(
        array(
          'action' => 'order',
          'relationship' => 'sibling',
          'group' => 'states-weight',
        ),
      ),
    );

    $states = $form_state->getValue('states', $this->getDefaultStateValues());
    $last_state = end($states);
    if (!empty($last_state['id'])) {
      // Ensure there's always an empty row.
      $states[] = array('id' => '', 'label' => '', 'weight' => 0);
    }

    foreach ($states as $index => $state) {
      $form['states'][$index]['#attributes']['class'][] = 'draggable';
      $form['states'][$index]['#weight'] = $state['weight'];

      $form['states'][$index]['id'] = array(
        '#type' => 'textfield',
        '#title_display' => 'invisible',
        '#default_value' => $state['id'],
      );
      $form['states'][$index]['label'] = array(
        '#type' => 'textfield',
        '#title_display' => 'invisible',
        '#default_value' => $state['label'],
      );
      $form['states'][$index]['weight'] = array(
        '#type' => 'weight',
        '#title' => t('Weight for @title', array('@title' => $state['id'])),
        '#title_display' => 'invisible',
        '#default_value' => $state['weight'],
        '#attributes' => array('class' => array('states-weight')),
      );
      $form['states'][$index]['remove'] = array(
        '#type' => 'submit',
        '#name' => 'remove-' . $index,
        '#value' => t('Remove'),
        '#index' => $index,
        '#limit_validation_errors' => array(array('states')),
        '#submit' => array('::removeStateSubmit'),
        '#ajax' => array(
          'callback' => '::refreshForm',
          'wrapper' => $form_id,
        ),
      );
    }

    $form['add_another_state'] = array(
      '#type' => 'submit',
      '#value' => t('Add another state'),
      '#limit_validation_errors' => array(array('states')),
      '#submit' => array('::addAnotherStateSubmit'),
      '#ajax' => array(
        'callback' => '::refreshForm',
        'wrapper' => $form_id,
      ),
    );

    return $form;
  }

  /**
   * Returns the default state values for the form's entity.
   *
   * @return array
   *   An array of state values.
   */
  public function getDefaultStateValues() {
    if ($this->entity->isNew()) {
      // Add a default state to serve as an example to the user.
      $states = array(array('id' => 'created', 'label' => 'Created', 'weight' => 0));
    }
    else {
      $states = $this->entity->getStates();
    }

    return $states;
  }

  /**
   * Submission handler for the state "Remove" button.
   */
  public static function removeStateSubmit(array $form, FormStateInterface $form_state) {
    $triggering_element = $form_state->getTriggeringElement();
    $index = $triggering_element['#index'];
    $states = $form_state->getValue('states');
    unset($states[$index]);
    $form_state->setValue('states', $states);

    $form_state->setRebuild();
  }

  /**
   * Submission handler for the "Add another state" button.
   */
  public static function addAnotherStateSubmit(array $form, FormStateInterface $form_state) {
    $states = $form_state->getValue('states');
    $states[] = array('id' => '', 'label' => '', 'weight' => 0);
    $form_state->setValue('states', $states);

    $form_state->setRebuild();
  }

  /**
   * Ajax handler.
   */
  public function refreshForm(array $form, FormStateInterface $form_state) {
    return $form;
  }

  /**
   * Overrides EntityForm::buildEntity().
   */
  public function buildEntity(array $form, FormStateInterface $form_state) {
    $states = $form_state->getValue('states');
    // Filter out empty values (empty id or label).
    $states = array_filter($states, function($state) {
      return !empty($state['id']) && !empty($state['label']);
    });
    $form_state->setValue('states', array_values($states));

    return parent::buildEntity($form, $form_state);
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
