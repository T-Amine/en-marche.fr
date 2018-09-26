<?php

namespace AppBundle\Entity\Biography;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\EntityIdentityTrait;
use AppBundle\Entity\EntityTimestampableTrait;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\MappedSuperclass
 */
abstract class AbstractBiography
{
    use EntityIdentityTrait;
    use EntityTimestampableTrait;

    /**
     * @ORM\Column(length=50)
     *
     * @Assert\NotBlank
     */
    protected $firstName;

    /**
     * @ORM\Column(length=50)
     *
     * @Assert\NotBlank
     */
    protected $lastName;

    /**
     * @ORM\Column
     *
     * @Gedmo\Slug(fields={"firstName", "lastName"})
     */
    protected $slug;

    /**
     * @ORM\Column(type="boolean", options={"default": 0})
     */
    protected $published;

    /**
     * @ORM\Column(nullable=true)
     *
     * @Assert\Length(max=255)
     */
    protected $description;

    /**
     * @ORM\Column(length=800, nullable=true)
     *
     * @Assert\Length(min=5, max=800)
     */
    protected $content;

    /**
     * @ORM\Column(nullable=true)
     *
     * @Assert\Length(max=255)
     */
    protected $facebookProfile;

    /**
     * @ORM\Column(nullable=true)
     *
     * @Assert\Length(max=255)
     */
    protected $twitterProfile;

    /**
     * @ORM\Column(nullable=true)
     *
     * @Assert\Length(max=255)
     */
    protected $instagramProfile;

    /**
     * @ORM\Column(nullable=true)
     *
     * @Assert\Length(max=255)
     */
    protected $linkedInProfile;

    /**
     * @var UploadedFile|null
     *
     * @Assert\Image(
     *     mimeTypes={"image/jpeg", "image/png"},
     *     maxSize="1M",
     *     maxWidth="1024",
     *     maxHeight="1024",
     *     minWidth="300",
     *     allowLandscape=false,
     * )
     */
    protected $image;

    /**
     * @ORM\Column(nullable=true)
     *
     * @Assert\Length(max=255)
     */
    protected $imageName;

    public function __construct(
        UuidInterface $uuid = null,
        string $firstNname = null,
        string $lastName = null,
        string $description = null,
        string $content = null,
        bool $published = null
    ) {
        $this->uuid = $uuid ?: Uuid::uuid4();
        $this->firstName = $firstNname;
        $this->lastName = $lastName;
        $this->description = $description;
        $this->content = $content;
        $this->published = $published;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): void
    {
        $this->content = $content;
    }

    public function setFirstName(string $firstName): void
    {
        $this->firstName = $firstName;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function getFullName(): string
    {
        return sprintf('%s %s', ucfirst($this->firstName), ucfirst($this->lastName));
    }

    public function setLastName(string $lastName): void
    {
        $this->lastName = $lastName;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function setPublished(bool $published): void
    {
        $this->published = $published;
    }

    public function isPublished(): ?bool
    {
        return $this->published;
    }

    public function getFacebookProfile(): ?string
    {
        return $this->facebookProfile;
    }

    public function setFacebookProfile(string $facebookProfile): void
    {
        $this->facebookProfile = $facebookProfile;
    }

    public function getTwitterProfile(): ?string
    {
        return $this->twitterProfile;
    }

    public function setTwitterProfile(string $twitterProfile): void
    {
        $this->twitterProfile = $twitterProfile;
    }

    public function getInstagramProfile(): ?string
    {
        return $this->instagramProfile;
    }

    public function setInstagramProfile(string $instagramProfile): void
    {
        $this->instagramProfile = $instagramProfile;
    }

    public function getLinkedInProfile(): ?string
    {
        return $this->linkedInProfile;
    }

    public function setLinkedInProfile(string $linkedInProfile): void
    {
        $this->linkedInProfile = $linkedInProfile;
    }

    public function setImageName(?UploadedFile $image): void
    {
        $this->imageName = null === $image ? null :
            sprintf('%s.%s',
                md5(sprintf('%s@%s', $this->getUuid()->toString(), $image->getClientOriginalName())),
                $image->getClientOriginalExtension()
            )
        ;
    }

    public function getImageName(): ?string
    {
        return $this->imageName;
    }

    public function hasImageName(): bool
    {
        return null !== $this->imageName;
    }

    public function getImage(): ?UploadedFile
    {
        return $this->image;
    }

    public function setImage(?UploadedFile $image): void
    {
        $this->image = $image;
    }

    public function getAssetImagePath(): string
    {
        return sprintf('/assets/%s', $this->getImagePath());
    }

    abstract public function getImagePath(): string;
}