<?php

namespace App\Entity;

use App\Entity\Comments;
use App\Entity\Categorys;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\PostsRepository;
use ApiPlatform\Metadata\ApiResource;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: PostsRepository::class)]
#[Vich\Uploadable]
#[ApiResource]
class Posts
{
    use Traits\nameTrait;
    use Traits\slugTrait;
    use Traits\contentTrait;
    use Traits\pictureNameTrait;
    use Traits\isPublishTrait;
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Vich\UploadableField(mapping: 'posts', fileNameProperty: 'pictureName')]
    private ?string $pictureFile = null;

    #[ORM\ManyToOne(inversedBy: 'posts')]
    private ?Users $user = null;

    #[ORM\OneToMany(mappedBy: 'post', targetEntity: Comments::class)]
    private Collection $comments;

    #[ORM\ManyToMany(targetEntity: Categorys::class, mappedBy: 'post')]
    private Collection $categorys;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
        $this->comments = new ArrayCollection();
        $this->categorys = new ArrayCollection();
    }

    public function __toString(): string
    {
        return $this->getName();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPictureFile(): ?string
    {
        return $this->pictureFile;
    }

    public function setPictureFile(?string $pictureFile): static
    {
        $this->pictureFile = $pictureFile;

        if (null !== $pictureFile) {
            $this->updatedAt = new \DateTimeImmutable();
        }

        return $this;
    }

    public function getUser(): ?Users
    {
        return $this->user;
    }

    public function setUser(?Users $user): static
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection<int, Comments>
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comments $comment): static
    {
        if (!$this->comments->contains($comment)) {
            $this->comments->add($comment);
            $comment->setPost($this);
        }

        return $this;
    }

    public function removeComment(Comments $comment): static
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getPost() === $this) {
                $comment->setPost(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Categorys>
     */
    public function getCategorys(): Collection
    {
        return $this->categorys;
    }

    public function addCategory(Categorys $category): static
    {
        if (!$this->categorys->contains($category)) {
            $this->categorys->add($category);
            $category->addPost($this);
        }

        return $this;
    }

    public function removeCategory(Categorys $category): static
    {
        if ($this->categorys->removeElement($category)) {
            $category->removePost($this);
        }

        return $this;
    }
}
