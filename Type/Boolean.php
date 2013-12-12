<?php

/*
 * (c) Alexandre Quercia <alquerci@email.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Instinct\Component\TypeAutoBoxing\Type;

/**
 * @author Alexandre Quercia <alquerci@email.com>
 */
class Boolean extends Enum
{
    protected $defaultValueSet = true;
    protected $defaultValue = false;

    public function __construct(array $parameters = array())
    {
        $parameters['enum.values'] = array(true, false);

        parent::__construct($parameters);
    }
}
