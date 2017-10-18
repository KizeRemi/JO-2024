<?php
namespace RemiBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use RemiBundle\Entity\Ville;
use RemiBundle\Form\VilleType;

class VilleController extends Controller
{

    /**
     * @Route("/villes", name="remi_ville_index")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $villes = $em->getRepository('RemiBundle:Ville')->findAll();

        return $this->render('RemiBundle:Ville:index.html.twig', [
            'villes' => $villes
        ]);
    }

    /**
     * @Route("/villes/add", name="remi_ville_add", options = { "expose" = true })
     */
    public function addAction(Request $request)
    {
        return $this->container->get('remi.ville_handler')->post($request);
    }

    /**
     * @Route("/villes/form/{id}", name="remi_ville_form", options = { "expose" = true })
     */
    public function getFormAction(Request $request, $id = null)
    {
        // Methode dégueulasse qui n'est pas sensé exister dans une API Rest
        $em = $this->getDoctrine()->getManager();

        //dégueu
        if ($id) {
            $ville = $em->getRepository('RemiBundle:Ville')->find($id);
        } else {
            $ville = new Ville();
        }
        $form = $this->createForm(VilleType::class, $ville);
        
        return $this->render('RemiBundle:Ville:form.html.twig',[ 'form' => $form->createView()]);;
    }

    /**
     * @Route("/villes/update/{id}", name="remi_ville_update", options = { "expose" = true })
     */
    public function updateAction(Request $request, $id)
    {
        return $this->container->get('remi.ville_handler')->patch($id, $request);
    }

    /**
     * @Route("/villes/remove/{id}", name="remi_ville_delete", options = { "expose" = true })
     */
    public function removeAction(Request $request, $id)
    {
        return $this->container->get('remi.ville_handler')->delete($id);
    }
}
