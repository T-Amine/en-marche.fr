<?php

namespace AppBundle\Collection;

use AppBundle\Entity\Biography\ExecutiveOfficeMember;
use Doctrine\Common\Collections\ArrayCollection;

class ExecutiveOfficeMemberCollection extends ArrayCollection
{
    public function getExecutiveOfficeMembers(): self
    {
        return $this->filter(function (ExecutiveOfficeMember $executiveOfficeMember) {
            return !$executiveOfficeMember->isExecutiveOfficer();
        });
    }

    public function getExecutiveOfficer(): ExecutiveOfficeMember
    {
        return $this->filter(function (ExecutiveOfficeMember $executiveOfficeMember) {
            return $executiveOfficeMember->isExecutiveOfficer();
        })->first();
    }
}
