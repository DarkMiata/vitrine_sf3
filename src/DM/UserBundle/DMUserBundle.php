<?php

namespace DM\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class DMUserBundle extends Bundle
{
  public function getParent() {

  return 'FOSUserBundle';
  }

}
