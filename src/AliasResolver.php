<?php

namespace Daniser\EntityResolver;

class AliasResolver implements Contracts\EntityResolver
{
    /** @var Contracts\EntityResolver */
    protected Contracts\EntityResolver $resolver;

    /** @var string[] */
    protected array $aliases;

    /**
     * AliasResolver constructor.
     *
     * @param Contracts\EntityResolver $resolver
     * @param string[] $aliases
     */
    public function __construct(Contracts\EntityResolver $resolver, array $aliases = [])
    {
        $this->resolver = $resolver;
        $this->aliases = $aliases;
    }

    public function resolve(string $type, $id): object
    {
        try {
            return $this->resolver->resolve($type, $id);
        } catch (Exceptions\EntityException $e) {
            if (! array_key_exists($type, $this->aliases)) {
                throw $e;
            }

            return $this->resolver->resolve($this->aliases[$type], $id);
        }
    }
}
