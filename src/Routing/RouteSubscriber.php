<?php

namespace Drupal\vactory_register\Routing;

use Drupal\Core\Routing\RouteSubscriberBase;
use Symfony\Component\Routing\RouteCollection;

class RouteSubscriber extends RouteSubscriberBase {


  /**
   * @inheritDoc
   */
  protected function alterRoutes(RouteCollection $collection)
  {
    // TODO: Implement alterRoutes() method.
    // register form
    //dump($collection);
    if ($route = $collection->get('user.register')) {
      $route->setDefault('_form', '\Drupal\vactory_register\Form\NewUserRegisterForm');
    }
  }
}
