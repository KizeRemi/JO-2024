<?php
namespace RemiBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use RemiBundle\Entity\Discipline;
use RemiBundle\Form\DisciplineType;

class DisciplineController extends Controller
{

    /**
     * @Route("/disciplines", name="remi_discipline_index")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $discipline = new Discipline();

        $form = $this->createForm(DisciplineType::class, $discipline);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em->persist($discipline);
            $em->flush();
        $this->addFlash('notice', $this->get('translator')->trans('notice.discipline.add'));
        }

        $disciplines = $em->getRepository('RemiBundle:Discipline')->findAll();

        return $this->render('RemiBundle:Discipline:index.html.twig', [
            'form'        => $form->createView(),
            'disciplines' => $disciplines
        ]);
    }

    /**
     * @Route("/discipline/{id}", name="remi_discipline_show")
     */
    public function showAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $discipline = $em->getRepository('RemiBundle:Discipline')->find($id);

        $form = $this->createForm(DisciplineType::class, $discipline);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em->persist($discipline);
            $em->flush();
            $this->addFlash('notice', $this->get('translator')->trans('notice.discipline.update'));
        }

        return $this->render('RemiBundle:Discipline:show.html.twig', [
            'form'        => $form->createView(),
            'discipline'  => $discipline
        ]);
    }

    /**
     * @Route("/discipline/{id}/delete", name="remi_discipline_delete")
     */
    public function deleteAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $discipline = $em->getRepository('RemiBundle:Discipline')->find($id);

        $em->remove($discipline);
        $em->flush();
        $this->addFlash('notice', $this->get('translator')->trans('notice.discipline.delete'));

        return $this->redirectToRoute('remi_discipline_index');
    }
}
