<?php

/*
 * (c) Alexandre Quercia <alquerci@email.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Instinct\Component\TypeAutoBoxing\Exception;

use InvalidArgumentException;

class TypeNotFoundException extends InvalidArgumentException
{
    public function __construct($name, \Exception $previous = null, array $alternatives = array())
    {
        $message = sprintf('You have requested a non-existent type "%s".', $name);

        if ($alternatives) {
            if (1 == count($alternatives)) {
                $message .= ' Did you mean this: "';
            } else {
                $message .= ' Did you mean one of these: "';
            }
        }

        $message .= implode('", "', $alternatives).'"?';

        parent::__construct($message, 0, $previous);
    }
}

