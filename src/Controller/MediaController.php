<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

use App\Entity\Media;

class MediaController extends AbstractController
{
    /**
     * @Route("/media", name="media")
     */
    public function index()
    {
      //$medias =  $this->getDoctrine()->getEntityManager()->getRepository(Media::class)->findAll();
      $medias =  $this->getDoctrine()->getEntityManager()->getRepository(Media::class)
                        ->findBy( array(), array('create_at' => 'ASC') );
      //                ['name' => 'Keyboard'],
      //                ['price' => 'ASC']
      //            );
      return $this->render('media/index.html.twig', ['medias' => $medias]);
    }
}
