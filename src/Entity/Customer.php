<?php

namespace App\Entity;

use App\Repository\CustomerRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;


#[ORM\Entity(repositoryClass: CustomerRepository::class)]
class Customer
{   

   // for validation
   public static function loadValidatorMetadata(ClassMetadata $metadata)
   {
      $metadata->addPropertyConstraint('name' , new Assert\NotBlank([
           'message'=>'name must be required.'
       ]));

       // new Assert\Length(['min' => 10,])
           

       $metadata->addPropertyConstraint('email' , new Assert\NotBlank([
           'message'=>'email must be required.'
       ]));

       $metadata->addPropertyConstraint('email' , new Assert\Email([
           // 'message'=>'Enter valid email.'
           'message'=>'The Email "{{ value }}" is not a valid email..'
           
       ]));

       $metadata->addPropertyConstraint('mobile' , new Assert\NotBlank([
           'message'=>'mobile must be required..'
       ]));


       $metadata->addPropertyConstraint('mobile' , new Assert\Length([
           'min' => 10,
           'max' => 10,
           'minMessage' => 'Enter valid number.',
           'maxMessage' => 'Enter valid number.',
       ]));

       $metadata->addPropertyConstraint('city' , new Assert\NotBlank([
           'message'=>'city must be required.'
       ]));

     


   }
   // end for validation

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\Column(type: 'string', length: 255)]
    private $email;

    #[ORM\Column(type: 'string', length: 255)]
    private $mobile;

    #[ORM\Column(type: 'string', length: 255)]
    private $city;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getMobile(): ?string
    {
        return $this->mobile;
    }

    public function setMobile(string $mobile): self
    {
        $this->mobile = $mobile;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }
}
