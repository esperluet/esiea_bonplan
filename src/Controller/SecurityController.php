<?php

namespace App\Controller;

use App\Form\Type\{LoginType, RegistrationType};
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\{Request, Response};
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Utilisateur;

#[Route(path:"/security", name:"security_")]
class SecurityController extends AbstractController
{
    #[Route(path:"/login-check", name:"login_check", methods: ["POST"])]
    public function check(Request $request, EntityManagerInterface $em, UserPasswordHasherInterface $passwordHasher, Security $security)
    {
        $form = $this->createForm(LoginType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $user = $em->getRepository(Utilisateur::class)->findOneByEmail($data['email']);

            if(null === $user) {
                $this->addFlash("error","Wrong email");
                return new Response('Unable to find the user');
            }

            if(false === $passwordHasher->isPasswordValid($user, $data['password'])) {
                $this->addFlash("error","Wrong password");
                return new Response('Unable to find the user');
            }

            $security->login($user);

            return new Response("log In");        
        }
    }

    #[Route(path:"/login", name:"login", methods: ["GET"])]
    public function login(): Response
    {
        $user = $this->getUser();

        if(null !== $user) {
            return $this->redirectToRoute('categorie-list');
        }

        $form = $this->createForm(LoginType::class, null, [
            'action' => $this->generateUrl('security_login_check')
        ]);

        return $this->render(
            "security/login.html.twig",
            [
                "form"=> $form->createView(),
            ]
        );
    }

    #[Route(path:"/registration", name:"registration", methods: ["GET", "POST"])]
    public function registration(Request $request, UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $em): Response
    {
        $user = new Utilisateur();
        $form = $this->createForm(RegistrationType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();

            $hashedPassword = $passwordHasher->hashPassword(
                $user,
                $user->getPassword()
            );

            $user->setPassword($hashedPassword);

            $em->persist($user);
            $em->flush();

            return new Response('registered');
        }

        return $this->render(
            "security/registration.html.twig",
            [
                "form"=> $form->createView(),
            ]
        );
    }

    #[Route(path:"/logout", name:"logout", methods: ["GET"])]
    public function logout(Security $security): Response | null
    {
        return $security->logout();
    }

}