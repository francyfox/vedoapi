<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ChatRoomRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * delete
 * ORM\Entity(repositoryClass=ChatRoomRepository::class)
 */
#[ApiResource]
class ChatRoom
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $Time;

    /**
     * @ORM\Column(type="integer")
     */
    private $GroupId;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $Sender;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $Recipient;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Text;

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private $Upload = [];

    /**
     * @ORM\Column(type="boolean", options={"default":"0"})
     */
    private $isRead;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTime(): ?\DateTimeInterface
    {
        return $this->Time;
    }

    public function setTime(\DateTimeInterface $Time): self
    {
        $this->Time = $Time;

        return $this;
    }

    public function getGroupId(): ?int
    {
        return $this->GroupId;
    }

    public function setGroupId(int $GroupId): self
    {
        $this->GroupId = $GroupId;

        return $this;
    }

    public function getSender(): ?string
    {
        return $this->Sender;
    }

    public function setSender(string $Sender): self
    {
        $this->Sender = $Sender;

        return $this;
    }

    public function getRecipient(): ?string
    {
        return $this->Recipient;
    }

    public function setRecipient(string $Recipient): self
    {
        $this->Recipient = $Recipient;

        return $this;
    }

    public function getText(): ?string
    {
        return $this->Text;
    }

    public function setText(string $Text): self
    {
        $this->Text = $Text;

        return $this;
    }

    public function getUpload(): ?array
    {
        return $this->Upload;
    }

    public function setUpload(?array $Upload): self
    {
        $this->Upload = $Upload;

        return $this;
    }

    public function getIsRead(): ?bool
    {
        return $this->isRead;
    }

    public function setIsRead(bool $isRead): self
    {
        $this->isRead = $isRead;

        return $this;
    }
}
