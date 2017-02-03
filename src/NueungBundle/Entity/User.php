<?php
// src/AppBundle/Entity/User.php

namespace NueungBundle\Entity;


use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * Many Users have Many Groups.
     * @ORM\ManyToMany(targetEntity="Skill", inversedBy="users")
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    private $skills;

    public function __construct()
    {
        parent::__construct();
        // your own logic
    }

    /**
     * Add skill
     *
     * @param \NueungBundle\Entity\Skill $skill
     *
     * @return User
     */
    public function addSkill(\NueungBundle\Entity\Skill $skill)
    {
        $this->skills[] = $skill;

        return $this;
    }

    /**
     * Remove skill
     *
     * @param \NueungBundle\Entity\Skill $skill
     */
    public function removeSkill(\NueungBundle\Entity\Skill $skill)
    {
        $this->skills->removeElement($skill);
    }

    /**
     * Get skills
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSkills()
    {
        return $this->skills;
    }
}
