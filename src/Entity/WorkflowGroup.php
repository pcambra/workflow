<?php

/**
 * @file
 * Contains Drupal\workflow\Entity\WorkflowGroup.
 */

namespace Drupal\workflow\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBase;
use Drupal\workflow\WorkflowGroupInterface;

/**
 * Defines the WorkflowGroup entity.
 *
 * @ConfigEntityType(
 *   id = "workflow_group",
 *   label = @Translation("Workflow group"),
 *   handlers = {
 *     "list_builder" = "Drupal\workflow\Controller\WorkflowGroupListBuilder",
 *     "form" = {
 *       "add" = "Drupal\workflow\Form\WorkflowGroupForm",
 *       "edit" = "Drupal\workflow\Form\WorkflowGroupForm",
 *       "delete" = "Drupal\workflow\Form\WorkflowGroupDeleteForm"
 *     }
 *   },
 *   config_prefix = "workflow_group",
 *   admin_permission = "administer site configuration",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid"
 *   },
 *   links = {
 *     "edit-form" = "entity.workflow_group.edit_form",
 *     "delete-form" = "entity.workflow_group.delete_form"
 *   }
 * )
 */
class WorkflowGroup extends ConfigEntityBase implements WorkflowGroupInterface
{

  /**
   * The group id.
   *
   * @var string
   */
  protected $id;

  /**
   * The group label.
   *
   * @var string
   */
  protected $label;

  /**
   * The group description.
   *
   * @var string
   */
  protected $description;

  /**
   * {@inheritdoc}
   */
  public function getDescription() {
    return $this->description;
  }

  /**
   * {@inheritdoc}
   */
  public function setDescription($description) {
    $this->description = $description;
  }

}
