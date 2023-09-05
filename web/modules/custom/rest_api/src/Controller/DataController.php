<?php

namespace Drupal\rest_api\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Entity\EntityTypeManager;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class DataController extends ControllerBase {

  /**
   * Manages entity type plugin definitions.
   *
   * @var \Drupal\Core\Entity\EntityTypeManager
   */
  protected $entityTypeManager;

  /**
   * Constructs a new constructor for DataController.
   *
   * @param \Drupal\Core\Entity\EntityTypeManager $entityTypeManager
   *   Manages entity type plugin definitions.
   */
  public function __construct(EntityTypeManager $entity) {
    $this->entityTypeManager = $entity;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('entity_type.manager'),
    );
  }

  public function result(Request $request) {
    $requested_tags = $request->query->get('tags');
    $requested_count = $request->query->get('count');
    $response = $this->getData($requested_tags, $requested_count);
    return new JsonResponse($response);
  }

  public function getData($tags, $count) {
    $data = [];
    $node = $this->entityTypeManager->getStorage('node');

    if ($tags) {
      $nids = $node
        ->getQuery()
        ->accessCheck(TRUE)
        ->condition('type', 'news')
        ->condition('field_tags', $tags, 'IN');
      $nids = $nids->execute();

      foreach ($nids as $nid) {
        $result = $node->load($nid);
        $data[] = [
          'title' => $result->title->value,
          'body' => $result->body->value,
          'summary' => $result->summary->value,
          'image' => $result->field_image->value
        ];
      }
      return $data;
    }
  }

}
