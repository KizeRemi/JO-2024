<?php
namespace RemiBundle\Services;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use RemiBundle\Entity\Ville;
use RemiBundle\Form\VilleType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Request;

class VilleHandler
{
    protected $em;

    protected $formFactory;

    protected $serializer;

    public function __construct(
        EntityManagerInterface $em,
        FormFactoryInterface $formFactory,
        SerializerInterface $serializer
    )
    {
        $this->em = $em;
        $this->formFactory = $formFactory;
        $this->serializer = $serializer;
    }

    public function post(Request $request)
    {
        $ville = new Ville();

        return $this->processForm($ville, $request, 'POST');
    }

    public function patch($id, Request $request) {
        $ville = $this->em->getRepository('RemiBundle:Ville')->find($id);
        if (!$ville) {
            return new JsonResponse('Not found', 404);
        }

        return $this->processForm($ville, $request, 'POST');
    }

    public function delete($id) {
        $ville = $this->em->getRepository('RemiBundle:Ville')->find($id);
        if (!$ville) {
            return new JsonResponse('Not found', 404);
        }

        $this->em->remove($ville);
        $this->em->flush();

        return new JsonResponse([], 200);
    }

    private function processForm(Ville $ville, Request $request, $method)
    {
        $form = $this->formFactory->create(VilleType::class, $ville, ['method' => $method]);
        $form->handleRequest($request);        

        if($form->isValid()){
            $this->em->persist($ville);
            $this->em->flush();

            $jsonContent = $this->serializer->serialize($ville, 'json');  
            $response = new Response($jsonContent, 200);
            return $response;
        } 

        return new JsonResponse($form->getErrors(true)[0]->getMessage(), 400);
    }
}
