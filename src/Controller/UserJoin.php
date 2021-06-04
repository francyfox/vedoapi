<?php


namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UserJoin extends AbstractController
{
    private $em;
    private $list;
    private $user;

    public function index(Request $request) {
        $this->em = $this->getDoctrine()->getManager();
        $data = json_decode($this->request->getContent(), true);
        $username = $data['username'];
        $this->list = $data['list'];
        $this->user = $this->getDoctrine()
            ->getRepository(User::class)
            ->findOneBy(array('username'=>$username));

    }
    /**
     * @Route("/api/joinTo/{RoomType}", name="join", methods={"PATCH"})
     */
    public function joinToUser($RoomType): Response {
        if ($this->user){
            if($RoomType == 'user'){
                $this->user->setFriendList($this->list);
            } elseif ($RoomType == 'group') {
                $this->user->setGroupList($this->list);
            } else {
                throw new \Error('Uknown End Point');
            }

            $this->em->flush();
            return new Response('New friends'+$this->list, 200);
        } elseif (!$this->user) {
            return new Response('Error! Set the username', 404);
        } elseif (!$this->list) {
            return new Response('Error! List is empty', 404);
        } else {
            return new Response('Error! Unknown', 404);
        }

    }
}