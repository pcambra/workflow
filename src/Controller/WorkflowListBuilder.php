<?php

/**
 * @file
 * Contains Drupal\workflow\Controller\WorkflowListBuilder.
 */

namespace Drupal\workflow\Controller;

use Drupal\Core\Config\Entity\ConfigEntityListBuilder;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Component\Utility\String;

/**
 * Provides a listing of workflows.
 */
class WorkflowListBuilder extends ConfigEntityListBuilder
{

  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header['label'] = $this->t('Workflow');
    $header['id'] = $this->t('Machine name');
    $header['group'] = $this->t('Group');
    return $header + parent::buildHeader();
  }

  /**
  * {@inheritdoc}
  */
  public function buildRow(EntityInterface $entity) {
    $row['label'] = String::checkPlain($entity->label());
    $row['id'] = $entity->id();
    $row['group'] = String::checkPlain($entity->getGroupEntity()->label());
    return $row + parent::buildRow($entity);
  }
}
