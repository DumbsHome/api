<?php

namespace App\Controller;

use App\Entity\Device;
use App\Entity\Log;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Annotation\Route;

class LogController extends AbstractController
{
    /**
     * @Route("/log/new", name="log_new", methods={"POST"})
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     * @throws \Exception
     */
    public function newAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $deviceRepo = $em->getRepository(Device::class);

        $device = $deviceRepo->findOneBy(
            [
                'id' => $request->request->get('device_id'),
                'user' => $this->getUser(),
            ]
        );

        if ($device === null) {
            throw new BadRequestHttpException("Device with id "
                . $request->request->get('device_id')
                . " does not exist");
        }

        $log = new Log;
        $log
            ->setDevice($device)
            ->setDate($request->request->get('date') ?? new \DateTime())
            ->setType($request->request->get('type'))
            ->setValue($request->request->get('value'));

        $em->persist($log);
        $em->flush();

        return $this->json([
            'log_id' => $log->getId(),
        ]);
    }
}
