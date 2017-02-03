<?php

namespace NueungBundle\Services;


use Symfony\Component\HttpFoundation\Request;
use NueungBundle\Entity\Skill;
use NueungBundle\Entity\User;

class SkillManager
{

    protected $skills;
    protected $currentUserName;
    protected $em;


    public function __construct($username, \Doctrine\ORM\EntityManager $em)
    {
        $this->em = $em;
        $this->currentUserName = $username;
        $this->skills = $this->getSkills();
    }


    public function getSkills()
    {
        $user = $this->em->getRepository('NueungBundle:User')->findBy(array("username" => $this->currentUserName));
        $skillsOfUser = $user[0]->getSkills();
        return $skillsOfUser;
    }

    public function addSkill($name, $level, $user)
    {
        $name = (string)$name; //force cast for data base validation
        $level = (int)$level; //same thing

        $newSkill = new Skill();
        $newSkill->setName($name);
        $newSkill->setLevel($level);

        $user->addSkill($newSkill); // use $this->getUser() to have an instance of object to use many to many methods !

        $this->em->persist($newSkill);
        $this->em->flush();


        return "Skill : " . $newSkill->getName() . " add with succes !";


    }

    public function deleteSkill($id, $choix){
            $skillToRemove = $this->em->getRepository('NueungBundle:Skill')->find($id);
            $this->em->remove($skillToRemove);
            $this->em->flush($skillToRemove);

        return "Skill deleted called";
    }


    public function getCurrentUserName()
    {
        return $this->currentUserName;
    }

    public function setCurrentUserName($userNameToSet)
    {
        $this->currentUserName = $userNameToSet;
    }

}
