<?php
namespace RemiBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use RemiBundle\Entity\Athlete;
use RemiBundle\Form\AthleteType;

class AthleteController extends Controller
{

    /**
     * @Route("/athletes", name="remi_athlete_index")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $athlete = new Athlete();

        $form = $this->createForm(AthleteType::class, $athlete);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em->persist($athlete);
            $em->flush();
            $this->addFlash('notice', $this->get('translator')->trans('notice.athlete.add'));
        }

        $athletes = $em->getRepository('RemiBundle:Athlete')->findAll();
        return $this->render('RemiBundle:Athlete:index.html.twig', [
            'form'     => $form->createView(),
            'athletes' => $athletes
        ]);
    }

    /**
     * @Route("/athlete/{id}", name="remi_athlete_show")
     */
    public function showAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $athlete = $em->getRepository('RemiBundle:Athlete')->find($id);

        $form = $this->createForm(AthleteType::class, $athlete);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em->persist($athlete);
            $em->flush();
            $this->addFlash('notice', $this->get('translator')->trans('notice.athlete.update'));
    	}

        return $this->render('RemiBundle:Athlete:show.html.twig', [
            'form'     => $form->createView(),
            'athlete'  => $athlete
        ]);
    }

    /**
     * @Route("/athlete/{id}/delete", name="remi_athlete_delete")
     */
    public function deleteAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $athlete = $em->getRepository('RemiBundle:Athlete')->find($id);

        $em->remove($athlete);
        $em->flush();
        $this->addFlash('notice', $this->get('translator')->trans('notice.athlete.delete'));

        return $this->redirectToRoute('remi_athlete_index');
    }
}
