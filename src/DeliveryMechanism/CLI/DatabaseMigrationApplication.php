<?php

namespace Refaktor\Blog\DeliveryMechanism\CLI;
use Refaktor\Blog\EntityGateway\VersionedEntityGateway;

/**
 * Todo this needs splitting
 */
class DatabaseMigrationApplication extends CLIApplication {
	public function execute() {
		$versionedGateways = $this->getConfiguration('versionedGateways');

		foreach ($versionedGateways as $versionedGateway) {
			/**
			 * @var VersionedEntityGateway $versionedGatewayObject
			 */
			$versionedGatewayObject = $this->getDIC()->make($versionedGateway);

			$versionedGatewayObject->upgradeDatabase();
		}
	}
}