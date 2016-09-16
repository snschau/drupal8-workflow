<?php

namespace Drupal\downloads_widget\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a 'DownloadsWidget' block.
 *
 * @Block(
 *  id = "downloads_widget",
 *  admin_label = @Translation("Downloads widget"),
 * )
 */
class DownloadsWidget extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $build = [];
    $build['downloads_widget']['#markup'] = 'Implement DownloadsWidget.';

    return $build;
  }

}
