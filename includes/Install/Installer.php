<?php

namespace Alamgir\DokanHelper\Install;

/**
 * Installer class
 *
 * @since 1.0.0
 */
class Installer {

    /**
     * Prepare for install when activated plugin
     *
     * @since 1.0.0
     */
    public function prepare_install() {
        $this->update_version();
    }

    /**
     * Update plugin version
     *
     * @since 1.0.0
     */
    public function update_version() {
        update_option( 'dokan_helper_version', DOKAN_HELPER_VERSION );
    }
}
