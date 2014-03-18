<?php

namespace Omnidoo\Rbac\Permission;

/**
 * Interface for permission
 */
interface PermissionInterface
{
    /**
     * Get the permission name
     *
     * You really must return the name of the permission as internally, the casting to string is used
     * as an optimization to avoid type checkings
     *
     * @return string
     */
    public function __toString();
}
