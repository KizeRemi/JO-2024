<?php
namespace RemiBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use RemiBundle\Entity\Pays;
use RemiBundle\Form\PaysType;

class PaysController extends Controller
{
    /**
     * @Route("/pays", name="remi_pays_index")
     */
    public function indexAction(Request $request)
    {
    	$em = $this->getDoctrine()->getEntityManager();
    	$pays = new Pays();

    	$form = $this->createForm(PaysType::class, $pays);
    	$form->handleRequest($request);

    	if($form->isSubmitted() && $form->isValid()){
            $file = $pays->getDrapeau();
            $fileName = $this->container->get('remi.file_uploader')->upload($file);
            $pays->setDrapeau($fileName);
    		$em->persist($pays);
    		$em->flush();
    		$this->addFlash('notice', 'Enregistré');
    	}

        $tousLesPays = $em->getRepository('RemiBundle:Pays')->findAll();
        
        return $this->render('RemiBundle:Pays:index.html.twig', [
        	'form'     => $form->createView(),
        	'tousLesPays' => $tousLesPays
        ]);
    }

    /**
     * @Route("/pays/{id}", name="remi_pays_show")
     */
    public function showAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $pays = $em->getRepository('RemiBundle:Pays')->find($id);

        $form = $this->createForm(PaysType::class, $pays);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em->persist($pays);
            $em->flush();
            $this->addFlash('notice', 'Enregistré');
        }

        return $this->render('RemiBundle:Pays:show.html.twig', [
            'form'     => $form->createView(),
            'pays'  => $pays
        ]);
    }

    /**
     * @Route("/pays/{id}/delete", name="remi_pays_delete")
     */
    public function deleteAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $pays = $em->getRepository('RemiBundle:Pays')->find($id);

        $em->remove($pays);
        $em->flush();

        return $this->redirectToRoute('remi_pays_index');
    }
}