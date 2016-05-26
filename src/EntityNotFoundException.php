<?php


namespace Refaktor\Blog;

/**
 * This exception declares that a given entity could not be found by the entity gateway.
 */
class EntityNotFoundException extends \Exception implements EntityGatewayException {

}