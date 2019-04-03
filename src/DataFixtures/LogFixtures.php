<?php


namespace App\DataFixtures;

use App\Entity\Device;
use App\Entity\Log;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class LogFixtures extends Fixture
{
    private $MAX_DEVICE = 10;
    private $MAX_LOG_PER_DEVICE = 100;
    private $SEC_BETWEEN_EACH_LOG = 60;

    public function load(ObjectManager $manager)
    {
        /** @var User $user */
        $user = $this->getReference(AppFixtures::ADMIN_USER_REFERENCE);
        $user = $manager->getRepository(User::class)->findOneByApiToken($user->getApiToken());

        $deviceCounter = 0;
        while ($deviceCounter <= $this->MAX_DEVICE) {
            $device = new Device();
            $device->setUser($user);
            $device->setPlace('Device '.$deviceCounter);
            $manager->persist($device);
            $manager->flush();

            $dt = new \DateTime();
            $logCounter = 0;
            while ($logCounter <= $this->MAX_LOG_PER_DEVICE) {
                $log = new Log();
                $log->setDevice($device);
                $log->setDate($dt);
                $log->setType('t');
                $log->setValue(random_int(-12, 32));

                $dt->add(new \DateInterval('PT'.$this->SEC_BETWEEN_EACH_LOG.'S'));
                $logCounter++;
                $manager->persist($log);
                $manager->flush();
            }

            $deviceCounter++;
        }
        $manager->flush();
    }
}
