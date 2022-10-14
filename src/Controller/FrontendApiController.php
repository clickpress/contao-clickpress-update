<?php

declare(strict_types=1);

/*
 * This file is part of the metten-promocodes-bundle.
 *
 * (c) Stefan Schulz-Lauterbach
 *
 * @license proprietary
 */

namespace Clickpress\Update\Controller;

use Contao\CoreBundle\ContaoCoreBundle;
use Contao\Environment;
use Contao\System;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\TokenNotFoundException;

/**
 * @Route(
 *     "/api/update/{token}",
 *     name=FrontendApiController::class,
 *     defaults={"_scope": "frontend"},
 *     methods={"GET"})
 */
class FrontendApiController extends AbstractController
{
    public function __invoke($token): JsonResponse
    {
        sleep(1);
        $confToken = System::getContainer()->getParameter('clickpress_update.token');

        if ($confToken !== $token) {
            throw new TokenNotFoundException();
        }

        $version = ContaoCoreBundle::getVersion();
        $header = ['Access-Control-Allow-Origin' => '*'];

        return new JsonResponse(['token' => $token, 'version' => $version], 200, $header);
    }
}
