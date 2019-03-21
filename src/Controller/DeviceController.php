<?php

namespace App\Controller;

use App\Entity\Device;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/device")
 *
 * Class DeviceController
 * @package App\Controller
 */
class DeviceController extends AbstractController
{
    /**
     * @Route("/new", name="device_new", methods={"POST"})
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function newAction(Request $request)
    {
        /** @var User $user */
        $user = $this->getUser();

        $em = $this->getDoctrine()->getManager();

        $device = new Device;
        $device
            ->setUser($user)
            ->setPlace($request->request->get('place') ?? null);

        $em->persist($device);
        $em->flush();

        return $this->json([
            'device_id' => $device->getId(),
        ]);
    }

    /**
     * @Route("/")
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function getAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $deviceRepo = $em->getRepository(Device::class);

        $limit = $request->query->get('limit') ?? 10;

        $devices = $deviceRepo->findBy(
            ['user' => $this->getUser()],
            null,
            $limit
        );

        $response = [];

        foreach ($devices as $device) {
            $response[$device->getId()] = [
                'place' => $device->getPlace(),
            ];
        }

        return $this->json($response);
    }
}
