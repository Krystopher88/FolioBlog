<?php

namespace App\Entity;

use App\Entity\Posts;
use App\Entity\Projects;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\CategorysRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: CategorysRepository::class)]
#[Vich\Uploadable]
class Categorys
{
    use Traits\nameTrait;
    use Traits\slugTrait;
    use Traits\pictureNameTrait;
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $color = null;

    #[Vich\UploadableField(mapping: 'categorys', fileNameProperty: 'pictureName')]
    private ?string $pictureFile = null;

    #[ORM\ManyToMany(targetEntity: Posts::class, inversedBy: 'categorys')]
    private Collection $post;

    #[ORM\ManyToMany(targetEntity: Projects::class, inversedBy: 'categorys')]
    private Collection $project;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
        $this->post = new ArrayCollection();
        $this->project = new ArrayCollection();
    }

    public function __toString(): string
    {
        return $this->getName();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(?string $color): static
    {
        $this->color = $color;

        return $this;
    }

    public function getPictureFile(): ?string
    {
        return $this->pictureFile;
    }

    public function setPictureFile(?string $pictureFile): static
    {
        $this->pictureFile = $pictureFile;

        return $this;
    }

    /**
     * @return Collection<int, Posts>
     */
    public function getPost(): Collection
    {
        return $this->post;
    }

    public function addPost(Posts $post): static
    {
        if (!$this->post->contains($post)) {
            $this->post->add($post);
        }

        return $this;
    }

    public function removePost(Posts $post): static
    {
        $this->post->removeElement($post);

        return $this;
    }

    /**
     * @return Collection<int, Projects>
     */
    public function getProject(): Collection
    {
        return $this->project;
    }

    public function addProject(Projects $project): static
    {
        if (!$this->project->contains($project)) {
            $this->project->add($project);
        }

        return $this;
    }

    public function removeProject(Projects $project): static
    {
        $this->project->removeElement($project);

        return $this;
    }
}
