<?php

namespace App\Controller;

use App\Entity\Device;
use App\Entity\Log;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/log")
 *
 * Class LogController
 * @package App\Controller
 */
class LogController extends AbstractController
{
    /**
     * @Route("/new", name="log_new", methods={"POST"})
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

    /**
     * @Route("/", name="log_get", methods={"GET"})
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function getAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $logRepo = $em->getRepository(Log::class);

        $limit = $request->query->get('limit') ?? 10;

        $logs = $logRepo->findByUser($this->getUser(), $limit);

        $response = [];

        foreach ($logs as $log) {
            $response[$log->getId()] = [
                'date' => $log->getDate(),
                'type' => $log->getType(),
                'value' => $log->getValue(),
                'device_id' => $log->getDevice()->getId(),
            ];
        }

        return $this->json($response);
    }

    /**
     * @Route("/bydevice/{device}", name="log_get_by_device", methods={"GET"})
     *
     * @param Request $request
     * @param Device $device
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function getByDeviceAction(Request $request, Device $device)
    {
        $em = $this->getDoctrine()->getManager();
        $logRepo = $em->getRepository(Log::class);

        $limit = $request->query->get('limit') ?? 10;

        $logs = $logRepo->findBy(
            ['device' => $device],
            ['date' => 'DESC'],
            $limit
        );

        $response = [];

        foreach ($logs as $log) {
            $response[$log->getId()] = [
                'date' => $log->getDate(),
                'type' => $log->getType(),
                'value' => $log->getValue(),
                'device_id' => $log->getDevice()->getId(),
            ];
        }

        return $this->json($response);
    }
}
