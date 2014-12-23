<?php

/**
 * @file
 * Contains Drupal\workflow\WorkflowGroupInterface.
 */

namespace Drupal\workflow;

use Drupal\Core\Config\Entity\ConfigEntityInterface;

/**
 * Provides an interface defining a workflow group entity.
 */
interface WorkflowGroupInterface extends ConfigEntityInterface {

  /**
   * Returns the group description.
   *
   * @return string
   *   The group description.
   */
  public function getDescription();

  /**
   * Sets the group description.
   *
   * @param string $description
   *   The group description.
   *
   * @return $this
   */
  public function setDescription($description);

}
