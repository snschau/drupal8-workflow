<?php

namespace Drupal\hello_world\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\node\Entity\Node;
/**
 * Class HelloController.
 *
 * @package Drupal\hello_world\Controller
 */
class HelloController extends ControllerBase {

  /**
   * Hello.
   *
   * @return string
   *   Return Hello string.
   *  try adding a link using l funchtion 
   */
  public function hello($nid) {
    $node = Node::load($nid);
    kint($node);
    return [
      '#type' => 'markup',
      '#markup' => $this->t('Node is @title!', ['@title' => $node->getTitle()])
    ];
  }

}
