<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ECSPrefix20210607\Symfony\Component\HttpKernel\Exception;

/**
 * @author Ben Ramsey <ben@benramsey.com>
 */
class UnauthorizedHttpException extends \ECSPrefix20210607\Symfony\Component\HttpKernel\Exception\HttpException
{
    /**
     * @param string          $challenge WWW-Authenticate challenge string
     * @param string|null     $message   The internal exception message
     * @param \Throwable|null $previous  The previous exception
     * @param int|null        $code      The internal exception code
     */
    public function __construct(string $challenge, $message = '', \Throwable $previous = null, $code = 0, array $headers = [])
    {
        if (null === $message) {
            trigger_deprecation('symfony/http-kernel', '5.3', 'Passing null as $message to "%s()" is deprecated, pass an empty string instead.', __METHOD__);
            $message = '';
        }
        if (null === $code) {
            trigger_deprecation('symfony/http-kernel', '5.3', 'Passing null as $code to "%s()" is deprecated, pass 0 instead.', __METHOD__);
            $code = 0;
        }
        $headers['WWW-Authenticate'] = $challenge;
        parent::__construct(401, $message, $previous, $headers, $code);
    }
}
