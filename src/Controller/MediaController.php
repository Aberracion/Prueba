<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

use App\Entity\Media;
use App\Entity\User;

class MediaController extends AbstractController
{
    /**
     * @Route("/media", name="media")
     */
    public function index()
    {
      if(in_array('ROLE_USER', $this->getUser()->getRoles())){
        $where = array('id_user' => $this->getUser()->getId());
        $medias =  $this->getDoctrine()->getEntityManager()->getRepository(Media::class)
                          ->findBy( $where, array('create_at' => 'ASC') );
      }
      else if(in_array('ROLE_ADMIN_APP', $this->getUser()->getRoles())){
        $where = array();
        $medias =  $this->getDoctrine()->getEntityManager()->getRepository(Media::class)
                          ->findBy( $where, array('create_at' => 'ASC') );
      }
      else if(in_array('ROLE_ADMIN_GROUP', $this->getUser()->getRoles())){
        $where = array();
        $medias = $this->getDoctrine()->getEntityManager()->createQueryBuilder()
                  ->select('m')
                  ->from(Media::class, 'm')
                  ->innerJoin(User::class, 'u', 'WITH', 'u.id = m.id_user')
                  ->where('u.id_group = :group')
                  ->setParameter('group', $this->getUser()->getIdGroup())
                  ->orderBy('m.create_at' , 'ASC')
                  ->getQuery()
                  ->execute();

      }


      return $this->render('media/index.html.twig', ['medias' => $medias]);
    }
}
