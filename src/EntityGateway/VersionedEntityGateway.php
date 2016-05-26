<?php

namespace Refaktor\Blog\EntityGateway;

interface VersionedEntityGateway {
    /**
     * @return void
     */
    public function upgradeDatabase();
}