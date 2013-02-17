<?php

namespace Koala\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class KoalaUserBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
