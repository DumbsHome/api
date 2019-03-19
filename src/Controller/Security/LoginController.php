<?php

namespace App\Controller\Security;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LoginController extends AbstractController
{
    /**
     * @Route("/login", name="login", methods={"POST"})
     *
     * @return Response
     */
    public function login()
    {
        /** @var User $user */
        $user = $this->getUser();

        return $this->json([
            'api_token' => $user->getApiToken(),
        ]);
    }
}
