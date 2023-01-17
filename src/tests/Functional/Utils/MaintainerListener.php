<?php

declare(strict_types=1);

namespace App\Tests\Functional\Utils;

use DateTime;
use Doctrine\ODM\MongoDB\Event\PreLoadEventArgs;
use MongoDB\BSON\UTCDateTime;

class MaintainerListener
{
    public function __construct(private DateTime $createdDate, private DateTime $updatedDate)
    {
    }

    public function preLoad(PreLoadEventArgs $eventArgs): void
    {
        $data = &$eventArgs->getData();
        $data['createdBy']['date'] = new UTCDateTime($this->createdDate);
        $data['updatedBy']['date'] = new UTCDateTime($this->updatedDate);
    }
}
