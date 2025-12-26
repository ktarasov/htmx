<?php

declare(strict_types=1);

namespace HTMx\Http;

use Concrete\Core\Http\Request;
use Symfony\Component\HttpFoundation\Request as SymfonyRequest;

class HtmxRequest extends Request
{
    protected static $instance;

    /**
     * @return static
     */
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = static::createFromGlobals();
        }

        return self::$instance;
    }

    /**
     * @param SymfonyRequest $instance
     */
    public static function setInstance(SymfonyRequest $instance)
    {
        self::$instance = $instance;
    }

    /**
     * Indicates that the request is made via Htmx.
     *
     * @return bool
     */
    public function isHtmxRequest(): bool
    {
        return filter_var($this->headers->get('HX-Request', 'false'), FILTER_VALIDATE_BOOLEAN);
    }

    /**
     * Indicates that the request is via an element using hx-boost.
     *
     * @return bool
     */
    public function isBoosted(): bool
    {
        return filter_var($this->headers->get('HX-Boosted', 'false'), FILTER_VALIDATE_BOOLEAN);
    }

    /**
     * The current URL of the browser when the htmx request was made.
     *
     * @return string|null
     */
    public function getCurrentUrl(): ?string
    {
        return $this->headers->get('HX-Current-Url');
    }

    /**
     * Indicates if the request is for history restoration after a miss in the local history cache
     *
     * @return bool
     */
    public function isHistoryRestoreRequest(): bool
    {
        return filter_var($this->headers->get('HX-History-Restore-Request', 'false'), FILTER_VALIDATE_BOOLEAN);
    }

    /**
     * The user response to an hx-prompt.
     *
     * @return string|null
     */
    public function getPromptResponse(): ?string
    {
        return $this->headers->get('HX-Prompt');
    }

    /**
     * The id of the target element if it exists.
     *
     * @return string|null
     */
    public function getTarget(): ?string
    {
        return $this->headers->get('HX-Target');
    }

    /**
     * The name of the triggered element if it exists.
     *
     * @return string|null
     */
    public function getTriggerName(): ?string
    {
        return $this->headers->get('HX-Trigger-Name');
    }

    /**
     * The id of the triggered element if it exists.
     *
     * @return string|null
     */
    public function getTriggerId(): ?string
    {
        return $this->headers->get('HX-Trigger');
    }
}