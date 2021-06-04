<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use ApiPlatform\Core\Annotation\ApiResource;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as OA;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;

/**
 * @ApiResource(itemOperations={

 * })
 */

/**
 * @ApiResource(
 *
 *  collectionOperations={
 *     "post",
 *      "collName_api_check"={
 *          "route_name"="authentication_token",
 *         "openapi_context"={
 *             "summary"="Check JWT token"
 *          },
 *      },
 *     "join_to_user"={
 *         "method"="PATCH",
 *         "path"="/joinTo/user",
 *         "controller"=UserJoin::class,
 *         "openapi_context"={
 *             "summary"="Add friend list // data(string username, array list)"
 *          },
 *     },
 *     "join_to_group"={
 *         "method"="PATCH",
 *         "path"="/joinTo/group",
 *         "controller"=UserJoin::class,
 *         "openapi_context"={
 *             "summary"="Add groups list // data(string username, array list)"
 *          },
 *     },
 *  },
 *     paginationEnabled=false
 *  )
 * @ApiFilter(SearchFilter::class, properties={"username": "exact"})
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\Table(name="`user`")
 */

class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @OA\Property(description="The unique identifier of the user.")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     *
     */
    private $username;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;


    /**
     * @ORM\Column(type="string", length=100, unique=true)
     */

    private $email;


    /**
     * @ORM\Column(type="string", length=180, unique=false)
     */

    private $name;


    /**
     * @ORM\Column(type="string", length=180, unique=false)
     */

    private $lastname;


    /**
     * @ORM\Column(type="string", length=180, unique=false)
     */

    private $birthday;


    /**
     * @ORM\Column(type="string", length=180, unique=false)
     */

    private $work;

    /**
     * @ORM\Column(type="string", length=180, unique=false)
     */

    private $hobby;

    /**
     * @ORM\Column(type="boolean", options={"default":"0"})
     */

    private $married;

    /**
     * @ORM\Column(type="boolean", options={"default":"0"})
     */

    private $childs;

    /**
     * @ORM\Column(type="string", length=180, unique=false)
     */

    private $country;

    /**
     * @ORM\Column(type="json")
     */

    private $likeArr = [];

    /**
     * @ORM\Column(type="json")
     */

    private $dislikeArr = [];

    #TODO: post user dislike empty? Why?

    /**
     * @ORM\OneToOne(targetEntity=Disc::class, cascade={"persist", "remove"})
     */
    private $disc;

    /**
     * @ORM\Column(type="string", length=1000, nullable=true)
     */
    private $profileUrl;

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private $FriendList = [];

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private $GroupList = [];


    /**
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

    public function getFriendList(): ?array
    {
        return $this->FriendList;
    }

    public function setFriendList(?array $FriendList): self
    {
        $this->FriendList = $FriendList;

        return $this;
    }

    public function getGroupList(): ?array
    {
        return $this->GroupList;
    }

    public function setGroupList(?array $GroupList): self
    {
        $this->GroupList = $GroupList;

        return $this;
    }
}
