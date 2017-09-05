<?php

namespace SBC\AWAPartnersBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * Client
 *
 * @ORM\Table(name="client")
 * @ORM\Entity(repositoryClass="SBC\AWAPartnersBundle\Repository\ClientRepository")
 * @Vich\Uploadable
 */
class Client implements \JsonSerializable
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="creation_date", type="datetime")
     * @Assert\DateTime()
     */
    private $creationDate;

    /**
     * @Vich\UploadableField(mapping="client_logo", fileNameProperty="logoName")
     * @Assert\File(
     *     mimeTypes = {"image/png", "image/jpeg", "image/jpg"},
     *     mimeTypesMessage = "Please upload a valid IMAGE"
     * )
     *
     * @var File
     */
    private $logoFile;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @var string
     */
    private $logoName;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     *
     * @var \DateTime
     */
    private $updatedAt;


    /**
     * @var integer
     *
     * @ORM\Column(name="position", type="integer")
     */
    private $position;

    /**
     * @var bool
     * @ORM\Column(name="displayed", type="boolean")
     */
    private $displayed;


    function jsonSerialize()
    {
        return get_object_vars($this);
    }
    public function __toString()
    {
        return $this->name;
    }

    public function __construct()
    {
        $this->displayed = true;
        $this->creationDate = new \Datetime();

    }

    /**
     * @return bool
     */
    public function isDisplayed()
    {
        return $this->displayed;
    }

    /**
     * @param $displayed
     * @return $this
     */
    public function setDisplayed($displayed)
    {
        $this->displayed = $displayed;

        return $this;
    }



    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Client
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set creationDate
     *
     * @param \DateTime $creationDate
     *
     * @return Client
     */
    public function setCreationDate($creationDate)
    {
        $this->creationDate = $creationDate;

        return $this;
    }

    /**
     * Get creationDate
     *
     * @return \DateTime
     */
    public function getCreationDate()
    {
        return $this->creationDate;
    }


    /**
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $logoFile
     *
     * @return Client
     */
    public function setLogoFile(File $logoFile = null)
    {
        $this->logoFile = $logoFile;

        if ($logoFile) {
            $this->updatedAt = new \DateTime('now');
        }

        return $this;
    }

    /**
     * @return File|null
     */
    public function getLogoFile()
    {
        return $this->logoFile;
    }

    /**
     *
     * @param string $logoName
     *
     * @return Client
     */
    public function setLogoName($logoName)
    {
        $this->logoName = $logoName;
        return $this;
    }

    /**
     *
     * @return string|null
     */
    public function getLogoName()
    {
        return $this->logoName;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return Client
     */
    public function setUpdatedAt()
    {
        $this->updatedAt = new \DateTime('now');

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }


    /**
     * Set position
     *
     * @param integer $position
     *
     * @return Client
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Get position
     *
     * @return integer
     */
    public function getPosition()
    {
        return $this->position;
    }

}

