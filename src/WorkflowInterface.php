<?php

/**
 * @file
 * Contains Drupal\workflow\WorkflowInterface.
 */

namespace Drupal\workflow;

use Drupal\Core\Config\Entity\ConfigEntityInterface;

/**
 * Provides an interface defining a workflow entity.
 */
interface WorkflowInterface extends ConfigEntityInterface
{

  /**
   * Returns the workflow group.
   *
   * @return string
   *   The group.
   */
  public function getGroup();

  /**
   * Returns the workflow group entity.
   *
   * @return \Drupal\workflow\WorkflowGroupInterface
   *   The workflow group entity.
   */
  public function getGroupEntity();

}
