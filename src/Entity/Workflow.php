<?php

/**
 * @file
 * Contains Drupal\workflow\Entity\Workflow.
 */

namespace Drupal\workflow\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBase;
use Drupal\Core\Config\Entity\ThirdPartySettingsTrait;
use Drupal\workflow\WorkflowInterface;

/**
 * Defines the workflow entity.
 *
 * @ConfigEntityType(
 *   id = "workflow",
 *   label = @Translation("Workflow"),
 *   handlers = {
 *     "list_builder" = "Drupal\workflow\Controller\WorkflowListBuilder",
 *     "form" = {
 *       "add" = "Drupal\workflow\Form\WorkflowForm",
 *       "edit" = "Drupal\workflow\Form\WorkflowForm",
 *       "delete" = "Drupal\workflow\Form\WorkflowDeleteForm"
 *     }
 *   },
 *   config_prefix = "workflow",
 *   admin_permission = "administer site configuration",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid"
 *   },
 *   links = {
 *     "edit-form" = "entity.workflow.edit_form",
 *     "delete-form" = "entity.workflow.delete_form"
 *   }
 * )
 */
class Workflow extends ConfigEntityBase implements WorkflowInterface {

  use ThirdPartySettingsTrait;

  /**
   * The workflow id.
   *
   * @var string
   */
  protected $id;

  /**
   * The workflow label.
   *
   * @var string
   */
  protected $label;

  /**
   * The workflow group id.
   *
   * @var string
   */
  protected $group;

  /**
   * The workflow states.
   *
   * @var array
   */
  protected $states = array();

  /**
   * {@inheritdoc}
   */
  public function getGroupEntity() {
    return WorkflowGroup::load($this->group);
  }

  /**
   * {@inheritdoc}
   */
  public function getGroup() {
    return $this->group;
  }

  /**
   * {@inheritdoc}
   */
  public function setGroup($group) {
    $this->group = $group;
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getStates() {
    return $this->states;
  }

  /**
   * {@inheritdoc}
   */
  public function setStates(array $states) {
    $this->states = $states;
    return $this;
  }

}
