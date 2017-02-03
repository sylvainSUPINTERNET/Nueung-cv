<?php

namespace NueungBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use NueungBundle\Entity\Skill;
use NueungBundle\Services\SkillManager;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class SkillController extends Controller
{


    /**
     * @Route("/skill", name="skill_home")
     */
    public function indexAction(Request $request)
    {

        $currentUser = $this->getUser(); // current User
        $currentUserName = $currentUser->getUserName();
        $em = $this->get('doctrine')->getEntityManager();


        $skillService = new SkillManager($currentUserName, $em); // skill service
        $skillsOfUser = $skillService->getSkills(); //all skill find for user in paramter return by the service

        return $this->render('NueungBundle:Skill:index.html.twig', array(
                "username" => $currentUser->getUserName(),
                "skills" => $skillsOfUser,
            )
        );
    }

    /**
     * @Route("/skill/add", name="skill_add")
     */

    public function addSkillAction(Request $request)
    {

        $currentUser = $this->getUser(); // current User
        $currentUserName = $currentUser->getUserName();
        $em = $this->get('doctrine')->getEntityManager();


        $skillToCreate = new Skill();
        $formAddSkill = $this->createFormBuilder($skillToCreate)
            ->add('name', TextType::class, array('label' => "Name : "))
            ->add('level', NumberType::class, array('label' => "Your level (maximum 3) : "))
            ->add('save', SubmitType::class, array('label' => 'Add now'))
            ->getForm();

        $formAddSkill->handleRequest($request);

        if ($formAddSkill->isSubmitted() && $formAddSkill->isValid()) {
            $name = $formAddSkill["name"]->getData();
            $level = $formAddSkill["level"]->getData();

            //get service name / level (to push inside the method who add the skill into db);
            $skillService = new SkillManager($currentUserName, $em);
            $skillService->addSkill($name, $level, $currentUser);
            //return $this->redirectToRoute('skill_add');
            return $this->redirect($this->generateUrl('skill_add'));
        }


        return $this->render('NueungBundle:Skill:add.html.twig', array(
                //params for twig
                "username" => $currentUserName,
                "formAddSkill" => $formAddSkill->createView(),
            )
        );
    }

    /**
     * @Route("/skill/delete/{id}", name="skill_delete")
     */

    public function deleteSkillAction(Request $request, $id)
    {

        $currentUser = $this->getUser(); // current User
        $currentUserName = $currentUser->getUserName();
        $em = $this->get('doctrine')->getEntityManager();

        $skillToDelete = $em->getRepository('NueungBundle:Skill')->find($id);

        $skillService = new SkillManager($currentUserName, $em); // skill service

        $choix = $request->request->get('deleteChoice');
        if (!empty($choix) && $choix[0] == "yes") {
            $skillService = new SkillManager($currentUserName, $em); // skill service
            $skillToDelete = $skillService->deleteSkill($id,$choix); //all skill find for user in paramter return by the service

            return $this->redirectToRoute('skill_home');
        }

        return $this->render('NueungBundle:Skill:delete.html.twig', array(
                //params for twig
                "username" => $currentUserName,
                "skillToDelete" => $skillToDelete
            )
        );
    }
}
