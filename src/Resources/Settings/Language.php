<?php

namespace Ominity\Api\Resources\Settings;

use Ominity\Api\Resources\BaseResource;

class Language extends BaseResource
{
    /**
     * Always 'language'
     *
     * @var string
     */
    public $resource;

    /**
     * ISO 639-1 language code.
     *
     * @var string
     */
    public $code;

    /**
     * Enlgish translation of the language.
     *
     * @var string
     */
    public $name;

    /**
     * Endonym (native name of the language).
     *
     * @var string
     */
    public $native;

    /**
     * Is the language set as default?
     *
     * @var bool
     */
    public $isDefault;

    /**
     * Is the language active and used for translations?
     *
     * @var bool
     */
    public $isEnabled;

    /**
     * @var \stdClass
     */
    public $_links;
}