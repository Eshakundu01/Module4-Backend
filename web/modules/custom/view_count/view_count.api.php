<?php

/**
 * @file
 * Hooks that are provided by the my module.
 */

use Drupal\node\NodeInterface;

/**
 * @addtogroup hooks
 * @{
 */

/**
 * This hooks allows modules to respond whenever the total number of times the
 * anonymous user has viewed a specific node during their current session is
 * increased.
 *
 * @param int $current_count
 *   The number of times that the current user has viewed the node during this
 *   session.
 * @param \Drupal\node\NodeInterface $node
 *   The node being viewed.
 */
function hook_track_count($current_count, NodeInterface $node) {
  // If this is the first time the user has viewed this node we display a
  // message letting them know.
  if (\Drupal::currentUser()->isAnonymous()) {
    if ($current_count === 1) {
      \Drupal::messenger()->addMessage('Viewed the node %title 1 time.', ['%title' => $node->label()]);
    }
  }
}

/**
 * @} End of "addtogroup hooks".
 */
