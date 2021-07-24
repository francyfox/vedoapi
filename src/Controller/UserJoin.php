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
     * @Route("/api/users/{id}/friend/{friendId}", name="remove_friend", methods={"DELETE"})
     */
    public function removeFriend(int $id, int $groupId): Response {
        $user = $this->getDoctrine()
            ->getRepository(User::class)
            ->find($id);
        $friend = $this->getDoctrine()
            ->getRepository(Group::class)
            ->find($groupId);
        $user->removeFriend($friend);
        return new Response('Friend removed - '.$friend->getName(), 200);
    }

    /**
     * @Route("/api/users/{id}/group/{groupId}", name="remove_group", methods={"DELETE"})
     */
    public function removeGroup(int $id, int $groupId): Response {
        $user = $this->getDoctrine()
            ->getRepository(User::class)
            ->find($id);
        $group = $this->getDoctrine()
            ->getRepository(Group::class)
            ->find($groupId);
        $user->removeGroup($group);
        return new Response('Group removed - '.$group->getGroupName(), 200);
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