<?php

namespace PHPSTORM_META {
    override(\Yaspa\Factory::make(0),
        map([
            OAuth\ConfirmInstallation::class => OAuth\ConfirmInstallation::class,
            OAuth\SecurityChecks::class => OAuth\SecurityChecks::class,
            Transformers\Authentication\OAuth\ConfirmationRedirect::class => Transformers\Authentication\OAuth\ConfirmationRedirect::class,
        ]));
}
