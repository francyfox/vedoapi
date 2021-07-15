<?php


namespace App\Controller;

use App\Entity\User;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Serializer\SerializerInterface;


class Security extends AbstractController
{
    /**
     * @Route("/api/auth", name="auth", methods={"POST"})
     */

    public function auth(SerializerInterface $serializer,
                         Request $request,
                         UserPasswordEncoderInterface $passwordEncoder,
                         JWTEncoderInterface $jwt): Response
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

            $serialFriends = $serializer->serialize($user->getMyFriends(), 'json');
            $serialGroups = $serializer->serialize($user->getMyGroups(), 'json');

            $token = $jwt->encode([
                'id' => $user->getId(),
                'profileUrl' => $user->getProfileUrl(),
                'username' => $user->getUsername(),
                'name' => $user->getName(),
                'lastname' => $user->getLastName(),
                'friends' => $serialFriends,
                'users_groups' => $serialGroups,
                'exp' => time() + 3600 // 1 hour expiration
            ]);

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