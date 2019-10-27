<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

use App\Entity\Role;
use App\Entity\Event;
use App\Entity\Group;
use App\Entity\User;


/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191024100104 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function generateRandomString($length = 16, $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ')
    {
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function up(Schema $schema) : void
    {

      $this->addSql('INSERT INTO role  VALUES (1,"Administrador Aplicación")');
      $this->addSql('INSERT INTO role  VALUES (2,"Administrador Grupo")');
      $this->addSql('INSERT INTO role  VALUES (3,"Usuario")');

      for($i=0; $i<10; $i++){
        $numChar = random_int(1, 10);
        $name = $this->generateRandomString($numChar);
        $this->addSql('INSERT INTO event (name)  VALUES ("'.$name.'")');
      }

      for($i=0; $i<10; $i++){
        $numChar = random_int(1, 10);
        $name = $this->generateRandomString($numChar);
        $this->addSql('INSERT INTO `group` (name)  VALUES ("'.$name.'")');
      }

      for($i=0; $i<100; $i++){
        $numChar = random_int(1, 10);
        $name = $this->generateRandomString($numChar);
        $numChar2 = random_int(1, 10);
        $password = $this->generateRandomString($numChar2);
        $this->addSql('INSERT INTO user (name,  password, id_role, id_group)  VALUES ("'.$name.'", "'.$password.'", '.random_int(1, 3).', '.random_int(1, 10).')');
      }

    }

    public function down(Schema $schema) : void
    {
      $this->addSql('TRUNCATE TABLE role');
      $this->addSql('TRUNCATE TABLE event');
      $this->addSql('TRUNCATE TABLE `group`');
      $this->addSql('TRUNCATE TABLE user');
        // this down() migration is auto-generated, please modify it to your needs

    }
}
