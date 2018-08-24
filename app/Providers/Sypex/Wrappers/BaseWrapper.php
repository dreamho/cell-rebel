<?php

namespace Ranking\Providers\Sypex\Wrappers;

class BaseWrapper
{
    public function __construct(array $data)
    {
        foreach ($data as $key => $value)
        {
            $propName = str_replace(' ', '', lcfirst(ucwords(str_replace(['-', '_'], ' ', $key))));
            $this->{$propName} = $value;
        }
    }
}