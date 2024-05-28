<?php

if (!function_exists("add_unix_mins")) {
    function add_unix_mins($old_unix, $minute) {
        $timeclass = new \DateTimeImmutable();
        return $timeclass->setTimestamp($old_unix)
                    ->setTimezone(new \DateTimeZone("Asia/Jakarta"))
                    ->add(new \DateInterval('PT' . $minute . 'M'))
                    ->getTimestamp();
    }
}

