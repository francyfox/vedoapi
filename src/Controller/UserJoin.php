<?php


namespace App\Controller;

use App\Entity\Group;
use App\Entity\User;
use Symfony\Component\Routing\Annotation\Route;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UserJoin extends AbstractController
{
    private $em;
    private $id;
    private $user;
    private $list;
    private $data;


    /**
     * @Route("/api/user/{id}/friend/{friendId}", name="remove_friend", methods={"POST"})
     */
    public function removeFriend($id, $groupId): Response {
        $user = $this->getDoctrine()
            ->getRepository(User::class)
            ->find($id);
        $friend = $this->getDoctrine()
            ->getRepository(Group::class)
            ->find($groupId);
        $user->removeFriend($friend);
        return new Response('Friend removed - ', 400);
    }

    /**
     * @Route("/api/user/{id}/group/{groupId}", name="remove_group", methods={"POST"})
     */
    public function removeGroup($id, $groupId): Response {
        $user = $this->getDoctrine()
            ->getRepository(User::class)
            ->find($id);

        $group = $this->getDoctrine()
            ->getRepository(Group::class)
            ->find($groupId);
        $user->removeGroup($group);
        $this->em->flush();
        return new Response('', 204);
    }

    /**
         * @Route("/api/joinTo/{RoomType}", name="join", methods={"POST"})
     */
    public function joinToUser(Request $request, $RoomType): Response {
        $this->em = $this->getDoctrine()->getManager();
        $data = json_decode($request->getContent(), true);
        $this->data = $request;
        $this->id = $data['userID'];
        $this->list = $data['list'];
        $this->user = $this->getDoctrine()
            ->getRepository(User::class)
            ->find($this->id);

        if ($this->user){
            if($RoomType == 'user'){
                foreach ($this->list as $item) {
                    $decoded= json_decode(json_encode($item), FALSE);
                    $friend = $this->getDoctrine()
                        ->getRepository(User::class)
                        ->find($decoded->id);
                    $this->user->addFriend($friend);
                }
            } elseif ($RoomType == 'group') {
                foreach ($this->list as $item) {
                    $decoded = json_decode(json_encode($item), FALSE);
                    $group = $this->getDoctrine()
                        ->getRepository(Group::class)
                        ->find($decoded->id);
                    $this->user->addGroup($group);

                }
            } else {
                throw new \Error('Uknown End Point');
            }

            $this->em->flush();
            return new Response('New friends'.var_dump($this->list), 200);
        } elseif (!$this->user) {
            return new Response(' Error! Set the username'.var_dump($this->user), 404);
        } elseif (!$this->list) {
            return new Response('Error! List is empty', 404);
        } else {
            return new Response('Error! Unknown', 404);
        }

    }
}