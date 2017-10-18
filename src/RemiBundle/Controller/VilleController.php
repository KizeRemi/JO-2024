<?php
namespace RemiBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use RemiBundle\Entity\Ville;
use RemiBundle\Form\VilleType;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class VilleController extends Controller
{

    /**
     * @Route("/villes", name="remi_ville_index")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $ville = new Ville();

        $villes = $em->getRepository('RemiBundle:Ville')->findAll();

        $form = $this->createForm(VilleType::class, $ville);

        return $this->render('RemiBundle:Ville:index.html.twig', [
            'villes' => $villes,
            'form'   => $form->createView(),
        ]);
    }

    /**
     * @Route("/villes/add", name="remi_ville_add")
     */
    public function addAction(Request $request)
    {
        // En théorie, le serializer est configuré dans un fichier de config dans le cas d'une vraie API
        // pour éviter de faire ça a chaque fois
        $encoders = array(new JsonEncoder());
        $normalizers = array(new ObjectNormalizer());
        $serializer = new Serializer($normalizers, $encoders);

        $ville = new Ville();
        $form = $this->createForm(VilleType::class, $ville);
        $form->handleRequest($request);        
        
        // Les assert vont s'occuper de gérer la validité des données. 
        if($form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($ville);
            $em->flush();
            
            // Le serializer transforme l'objet Ville en json, oklm
            // Si le serializer était configuré, on peut faire un return $ville direct
            $jsonContent = $serializer->serialize($ville, 'json');  
            $response = new Response($jsonContent, 200);
            $response->headers->set('Content-Type', 'application/json');
            return $response;
        } 

        // On retourne le message. A chaque fois, on prend que la 1ere erreur.
        // L'erreur 400 est obligatoire pour passer dans le error coté ajax. 
        // Le prof a dit que le call ajax passe dans le error si celui-ci a planté mais en réalité, cela dépend du
        // statut code qu'il reçoit.
        return new JsonResponse($form->getErrors(true)[0]->getMessage(), 400);
    }

    /**
     * @Route("/villes/form/{id}", name="remi_ville_form")
     */
    public function getFormAction(Request $request, $id = null)
    {
        $em = $this->getDoctrine()->getManager();
        if ($id) {
            $ville = $em->getRepository('RemiBundle:Ville')->find($id);
        } else {
            $ville = new Ville();
        }
        $form = $this->createForm(VilleType::class, $ville);
        
        return $this->render('RemiBundle:Ville:form.html.twig',[ 'form' => $form->createView()]);;
    }

    /**
     * @Route("/villes/remove/{id}", name="remi_ville_remove")
     */
    public function removeAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $ville = $em->getRepository('RemiBundle:Ville')->find($id);
        $em->remove($ville);
        $em->flush();

        return new JsonResponse([], 200);
    }
}
