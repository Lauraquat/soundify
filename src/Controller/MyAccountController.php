<?php

namespace App\Controller;

use App\Entity\Artiste;
use App\Entity\User;
use App\Repository\UserRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security as UserSecurity;

class MyAccountController extends AbstractController
{
    #[Route('/account', name: 'app_my_account')]
    #[Security('is_granted("ROLE_USER")')]
    public function index(UserSecurity $security, Request $request, UserPasswordHasherInterface $userPasswordHasher, UserRepository $userRepository): Response
    {
        /** @var User $user */
        $user = $security->getUser();

        $formBuilder = $this->createFormBuilder([
            'artiste' => $user->getArtiste() ?? ''
        ]);

        $formBuilder
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'required' => false,
                'first_options' => ['label' => 'Mot de passe'],
                'second_options' => ['label' => 'Répéter le mot de passe']
            ])
            ->add('artiste', TextType::class, ['label' => "Nom de l'artiste", 'required' => false])
            ->add('submit', SubmitType::class, ['label' => 'Mettre à jour']);

        $form = $formBuilder->getForm();
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $data = $form->getData();

            if(!empty($data['password'])){
                $user->setPassword($userPasswordHasher->hashPassword($user, $data['password']));
            }
            

            if(!empty($data['artiste'])){
                $artiste = $user->getArtiste() ?? new Artiste;
                $artiste->setName($data['artiste']);
                $user->setArtiste($artiste);
            }

            $userRepository->flush();
        }

        return $this->render('my_account/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
