<?php


namespace App\Controller;

use App\Entity\User;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class Security extends AbstractController
{
    /**
     * @Route("/api/auth", name="auth", methods={"POST"})
     */
    public function auth(Request $request, UserPasswordEncoderInterface $passwordEncoder, JWTEncoderInterface $jwt): Response
    {
        $data = json_decode($request->getContent(), true);
        $username = $data['username'];
        $plainpwd = $data['password'];

        $user = $this->getDoctrine()
            ->getRepository(User::class)
            ->findOneBy(array('username'=>$username));

        if ($user)
        {
            if ($passwordEncoder->needsRehash($user)){
                $DBplainPwd = $user->getPassword();
                $user->setPassword($passwordEncoder->encodePassword($user, $DBplainPwd));
                $this->getDoctrine()->getManager()->flush();
            }

            $validPassword = $passwordEncoder->isPasswordValid(
                $user,
                $plainpwd      // the submitted password
            );

            $token = $jwt->encode([$username => $user->getUsername()]);
            $json_token = json_encode($token);

            if ($validPassword)
            {
                return new Response($token, 201);
            } elseif (!$validPassword) {

                return new Response('Password incorrect', 401);
            } else {
                return new Response('Unauthorized request. No username or password', 403);
            }
        } else
        {
            return new Response('Incorrect username', 400);
        }
    }
}