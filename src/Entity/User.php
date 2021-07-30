<?php

namespace App\Entity;

use App\Repository\GroupRepository;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use ApiPlatform\Core\Annotation\ApiResource;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as OA;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use Symfony\Component\Serializer\Annotation\Groups;


/**
 * @ApiResource(
 *  normalizationContext={"groups"={"read"}},
 *  denormalizationContext={"groups"={"write"}},
 *  collectionOperations={
 *     "get",
 *     "post",
 *      "collName_api_check"={
 *          "route_name"="authentication_token",
 *         "openapi_context"={
 *             "summary"="Check JWT token"
 *          },
 *      },
 *     "delete_user_friend"={
 *         "method"="POST",
 *         "path"="/user/{id}/friend/{friendId}",
 *         "controller"=UserJoin::class
 *     },
 *     "delete_user_group"={
 *         "method"="POST",
 *         "path"="/user/{id}/group/{groupId}",
 *         "controller"=UserJoin::class
 *     },
 *     "join_to_user"={
 *         "method"="POST",
 *         "path"="/joinTo/user",
 *         "controller"=UserJoin::class
 *     },
 *     "join_to_group"={
 *         "method"="POST",
 *         "path"="/joinTo/group",
 *         "controller"=UserJoin::class,
 *         "openapi_context"={
 *             "summary"="Add groups list // data(string username, array list)"
 *          },
 *     },
 *  },
 *     paginationEnabled=false
 *  )
 * @ApiFilter(SearchFilter::class, properties={"username": "partial"})
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\Table(name="`user`")
 */

class User implements UserInterface
{
    /**
     * @Groups({"read", "write"})
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @OA\Property(description="The unique identifier of the user.")
     */
    private $id;

    /**
     * @Groups({"read", "write"})
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $username;

    /**
     * @Groups({"read", "write"})
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @Groups({"read", "write"})
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;


    /**
     * @Groups({"read", "write"})
     * @ORM\Column(type="string", length=100, unique=true)
     */

    private $email;


    /**
     * @Groups({"read", "write"})
     * @ORM\Column(type="string", length=180, unique=false)
     */

    private $name;


    /**
     * @Groups({"read", "write"})
     * @ORM\Column(type="string", length=180, unique=false)
     */

    private $lastname;


    /**
     * @Groups({"read", "write"})
     * @ORM\Column(type="string", length=180, unique=false)
     */

    private $birthday;


    /**
     * @Groups({"read", "write"})
     * @ORM\Column(type="string", length=180, unique=false)
     */

    private $work;

    /**
     * @Groups({"read", "write"})
     * @ORM\Column(type="string", length=180, unique=false)
     */

    private $hobby;

    /**
     * @Groups({"read", "write"})
     * @ORM\Column(type="boolean", options={"default":"0"})
     */

    private $married;

    /**
     * @Groups({"read", "write"})
     * @ORM\Column(type="boolean", options={"default":"0"})
     */

    private $childs;

    /**
     * @Groups({"read", "write"})
     * @ORM\Column(type="string", length=180, unique=false)
     */

    private $country;

    /**
     * @Groups({"read", "write"})
     * @ORM\Column(type="json")
     */

    private $likeArr = [];

    /**
     * @Groups({"read", "write"})
     * @ORM\Column(type="json")
     */

    private $dislikeArr = [];

    #TODO: post user dislike empty? Why?

    /**
     * @Groups({"write"})
     * @ORM\OneToOne(targetEntity=Disc::class, cascade={"persist", "remove"})
     */
    private $disc;

    /**
     * @Groups({"read", "write"})
     * @ORM\Column(type="string", length=1000, nullable=true)
     */
    private $profileUrl;

    /**
     * @Groups({"read", "write"})
     * Many Users have Many Users.
     * @ORM\ManyToMany(targetEntity="User", mappedBy="myFriends")
     */
    private $friendsWithMe;

    /**
     * @Groups({"read", "write"})
     * Many Users have many Users.
     * @ORM\ManyToMany(targetEntity="User", cascade={"persist", "remove"}, inversedBy="friendsWithMe")
     * @ORM\JoinTable(name="friends",
     *      joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="friend_user_id", referencedColumnName="id")}
     *      )
     */
    private $myFriends;

    /**
     * @Groups({"read", "write"})
     * Many Users have Many Groups.
     * @ORM\ManyToMany(targetEntity="Group", cascade={"persist", "remove"}, orphanRemoval=true)
     * @ORM\JoinTable(name="users_groups",
     *      joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="group_id", referencedColumnName="id")}
     *      )
     */
    private $groups;

    public function __construct() {
        $this->friendsWithMe = new \Doctrine\Common\Collections\ArrayCollection();
        $this->groups = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getMyFriends(){
        return $this->myFriends;
    }

    public function getMyGroups()
    {
        return $this->groups;
    }

    /**
     * Add friend
     * @param App\Entity\User $friend
     */
    public function addFriend(\App\Entity\User $friend){
        $this->myFriends->add($friend);
    }

    public function removeFriend(User $friend){
        $this->myFriends->removeElement($friend);
    }

    /**
     * Add group
     * @param App\Entity\Group $group
     */
    public function addGroup(\App\Entity\Group $group){
        if (!$this->groups->contains($group)) {
            $this->groups->add($group);
        }
    }

    public function removeGroup(\App\Entity\Group $group){
        if (!$this->groups->contains($group)) {
            return;
        }
        $this->groups->removeElement($group);
    }


    /**
     * @Groups({"read", "write"})
     * @param json $likeArr
     */
    public function setLikeArr(array $likeArr): array
    {
        return $this->likeArr = $likeArr;
    }


    /**
     * @return array
     */
    public function getLikeArr(): ?array
    {
        $likeArr = $this->likeArr;
        return array_unique($likeArr);
    }


    /**
     * @param json $dislikeArr
     */

    public function setDislikeArr(array $dislikeArr): array
    {
        return $this->likeArr = $dislikeArr;
    }

    /**
     * @return array
     */

    public function getDislikeArr(): ?array
    {
        $dislikeArr = $this->dislikeArr;
        return array_unique($dislikeArr);
    }



    /**
     * @return mixed
     */
    public function getBirthday()
    {
        return $this->birthday;
    }



    /**
     * @return mixed
     */
    public function getChilds()
    {
        return $this->childs;
    }

    /**
     * @return mixed
     */
    public function getCountry()
    {
        return $this->country;
    }



    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return mixed
     */
    public function getHobby()
    {
        return $this->hobby;
    }

    /**
     * @return mixed
     */
    public function getLastname()
    {
        return $this->lastname;
    }


    /**
     * @return mixed
     */
    public function getMarried()
    {
        return $this->married;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getWork()
    {
        return $this->work;
    }


    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @param string $lastname
     */
    public function setLastname(string $lastname): void
    {
        $this->lastname = $lastname;
    }

    /**
     * @param string $birthday
     */
    public function setBirthday(string $birthday): void
    {
        $this->birthday = $birthday;
    }


    /**
     * @param string $work
     */
    public function setWork(string $work): void
    {
        $this->work = $work;
    }

    /**
     * @param string $hobby
     */
    public function setHobby(string $hobby): void
    {
        $this->hobby = $hobby;
    }

    /**
     * @param boolean $married
     */
    public function setMarried($married): void
    {
        $this->married = $married;
    }

    /**
     * @param boolean $childs
     */
    public function setChilds($childs): void
    {
        $this->childs = $childs;
    }

    /**
     * @param mixed $country
     */
    public function setCountry($country): void
    {
        $this->country = $country;
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getDisc(): ?Disc
    {
        return $this->disc;
    }

    public function setDisc(?Disc $disc): self
    {
        $this->disc = $disc;

        return $this;
    }

    public function getProfileUrl(): ?string
    {
        return $this->profileUrl;
    }

    public function setProfileUrl(?string $profileUrl): self
    {
        $this->profileUrl = $profileUrl;

        return $this;
    }
}
