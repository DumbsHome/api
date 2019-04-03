<?php

namespace App\Doctrine;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Id\AbstractIdGenerator;

class RandomIdGenerator extends AbstractIdGenerator
{
    public function generate(EntityManager $em, $entity)
    {
        $entity_name = $em->getClassMetadata(get_class($entity))->getName();

        $max_attempt = 99;
        $attempt = 0;
        $length = 48;

        while (true) {
            $id = $this->generateRandomString($length);
            $item = $em->find($entity_name, $id);

            if (!$item) {
                return $id;
            }

            $attempt++;
            if ($attempt > $max_attempt) {
                throw new \Exception('Hard to believe, but after '.$attempt.' attempts RandomIdGenerator still failed to return an unique id');
            }
        }
    }

    /**
     * Returns a random string of the given length
     *
     * @param int $length Length of the string (default: 10 characters)
     *
     * @return string
     */
    private function generateRandomString($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        return $randomString;
    }
}
