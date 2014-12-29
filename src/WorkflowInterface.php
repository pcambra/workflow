<?php

/**
 * @file
 * Contains Drupal\workflow\WorkflowInterface.
 */

namespace Drupal\workflow;

use Drupal\Core\Config\Entity\ConfigEntityInterface;
use \Drupal\Core\Config\Entity\ThirdPartySettingsInterface;

/**
 * Provides an interface defining a workflow entity.
 */
interface WorkflowInterface extends ConfigEntityInterface, ThirdPartySettingsInterface {

  /**
   * Returns the workflow group entity.
   *
   * @return \Drupal\workflow\WorkflowGroupInterface
   *   The workflow group entity.
   */
  public function getGroupEntity();

  /**
   * Returns the workflow group.
   *
   * @return string
   *   The group.
   */
  public function getGroup();

  /**
   * Sets the workflow group.
   *
   * @param string $group
   *   The group.
   *
   * @return $this
   */
  public function setGroup($group);

}
