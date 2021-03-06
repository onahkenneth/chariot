<?php

namespace Awesomite\Chariot\Collector;

use Awesomite\Chariot\Exceptions\CannotGenerateLinkException;
use Awesomite\Chariot\LinkInterface;
use Awesomite\Chariot\LinkParamsTrait;

/**
 * @internal
 */
class LinkCollector implements LinkInterface
{
    use LinkParamsTrait;

    /**
     * @var callable[]
     */
    private $getters;

    private $handler;

    /**
     * @param string     $handler
     * @param callable[] $getters
     */
    public function __construct(string $handler, array $getters)
    {
        $this->handler = $handler;
        $this->getters = $getters;
    }

    public function toString(): string
    {
        $result = (string) $this;
        if ($result === static::ERROR_CANNOT_GENERATE_LINK) {
            throw new CannotGenerateLinkException($this->handler, $this->params);
        }

        return $result;
    }

    public function __toString(): string
    {
        foreach ($this->getters as $getter) {
            /** @var LinkInterface $link */
            $link = $getter();
            $link->withParams($this->params);
            $link->withPrefix($this->prefix);
            $result = (string) $link;
            if ($result !== static::ERROR_CANNOT_GENERATE_LINK) {
                return $result;
            }
        }

        return static::ERROR_CANNOT_GENERATE_LINK;
    }
}
