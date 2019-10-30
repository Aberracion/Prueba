<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Filesystem\Filesystem;

use Symfony\Component\DependencyInjection\ContainerInterface;

use App\Entity\Media;
use App\Entity\User;
use App\Entity\Event;

class ImportMediaCommand extends Command
{
    protected static $defaultName = 'importMedia';
    private $container;

    public function __construct(ContainerInterface $container)
    {
        parent::__construct();
        $this->container = $container;
    }

    protected function configure()
    {
        $this
            ->setDescription('Importa archivos multimedia')
            ->addArgument('file', InputArgument::REQUIRED, 'Fichero multimedia con path incluido')
            ->addArgument('id_event', InputArgument::REQUIRED, 'Id del evento que asignar')
            ->addArgument('id_user', InputArgument::REQUIRED, 'Id del usuario al que pertenece el fichero')
            ->addArgument('password', InputArgument::REQUIRED, 'Contraseña del usuario')
            //->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $entityManager = $this->container->get('doctrine')->getManager();
        $file = $input->getArgument('file');
        $error = false;

        if ($file) {
            $io->note(sprintf('You passed an argument: %s', $file));
        }
        else{
          $error = true;
          $io->error("You didn't pass file argument");
        }

        $id_event = $input->getArgument('id_event');

        if ($id_event) {
            $io->note(sprintf('You passed an argument: %s', $id_event));
            $e = $entityManager->getRepository(Event::class)->find($id_event);

            if (!$e) {
              $error = true;
              $io->error('Evento con id '.$id_event.' no encontrado');
            }
        }
        else{
          $error = true;
          $io->error("You didn't pass event argument");
        }

        $id_user = $input->getArgument('id_user');
        $password = $input->getArgument('password');
        if ($id_user && $password) {
            $io->note(sprintf('You passed an argument: %s', $id_user));
            $u = $entityManager->getRepository(User::class)->findOneBy([
                    'id' => $id_user,
                    'Password' => $password,
                ]);

            if (!$u) {
              $error = true;
              $io->error('Id_usuario o contraseña incorrectos');
            }


        }
        else{
          $error = true;
          $io->error("You didn't pass user argument");
        }

        //if ($input->getOption('option1')) {
            // ...
        //}


        if(!$error)
        {
          $dotpos=strrpos($file,'.');
          $ext=substr($file,$dotpos);
          $fecha = date_create();
          $new_file = '/storage/'.$u->getUsername()."_".date_timestamp_get($fecha).$ext;
          copy($file, './public'.$new_file);



          $media = new Media();
          $media->setPath($new_file);
          $media->setIdUser($id_user);
          $media->setIdEvent($id_event);
          $media->setCreateAt($fecha);

          $entityManager->persist($media);

          $entityManager->flush();
          $io->success('Fichero importado');
        }
    }
}
