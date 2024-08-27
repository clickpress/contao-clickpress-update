<?php

namespace Clickpress\Update\Controller;

use Contao\CoreBundle\ContaoCoreBundle;
use Contao\System;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;


#[Route('/api/update/{token}', name: 'api_update', defaults: ['_scope' => 'frontend'])]
class FrontendApiController extends AbstractController
{
    public function __invoke($token): JsonResponse
    {
        $confToken = System::getContainer()->getParameter('clickpress_update.token');

        if ($confToken !== $token) {
            return new JsonResponse(['token' => $token, 'version' => null], 200);
        }

        $version = ContaoCoreBundle::getVersion();
        $header = ['Access-Control-Allow-Origin' => '*'];

        return new JsonResponse(['token' => $token, 'version' => $version], 200, $header);
    }
}
