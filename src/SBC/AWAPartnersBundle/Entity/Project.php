<?php

namespace SBC\AWAPartnersBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * Project
 *
 * @ORM\Table(name="project")
 * @ORM\Entity(repositoryClass="SBC\AWAPartnersBundle\Repository\ProjectRepository")
 * @Vich\Uploadable
 */
class Project implements \JsonSerializable
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
     * @var \DateTime
     *
     * @ORM\Column(name="creation_date", type="datetime")
     * @Assert\DateTime()
     */
    private $creationDate;

    /**
     * @var string
     *
     * @ORM\Column(name="note", type="text")
     */
    private $note;


    /**
     * @var string
     *
     * @ORM\Column(name="conception_periode", type="string", length=255, nullable=true)
     */
    private $conceptionPeriode;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="conception_begin_date", type="datetime", nullable=true)
     * @Assert\DateTime()
     */
    private $conceptionBeginDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="conception_finish_date", type="datetime", nullable=true)
     * @Assert\DateTime()
     */
    private $conceptionFinishDate;

    /**
     * @var string
     *
     * @ORM\Column(name="construction_periode", type="string", length=255, nullable=true)
     */
    private $constructionPeriode;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="construction_begin_date", type="datetime", nullable=true)
     * @Assert\DateTime()
     */
    private $constructionBeginDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="construction_finish_date", type="datetime", nullable=true)
     * @Assert\DateTime()
     */
    private $constructionFinishDate;


    /**
     * @var string
     *
     * @ORM\Column(name="composante", type="string", length=255, nullable=true)
     */
    private $composante;

    /**
     * @var string
     *
     * @ORM\Column(name="conception_team", type="string", length=255, nullable=true)
     */
    private $conceptionTeam;


    /**
     * @var string
     *
     * @ORM\Column(name="tache", type="string", length=255, nullable=true)
     */
    private $tache;

    /**
     * @var string
     *
     * @ORM\Column(name="company", type="string", length=255, nullable=true)
     */
    private $company;

    /**
     * @var string
     *
     * @ORM\Column(name="mission", type="string", length=255, nullable=true)
     */
    private $mission;

    /**
     * @var string
     *
     * @ORM\Column(name="maitre_ouvrage", type="string", length=255, nullable=true)
     */
    private $maitreOuvrage;


    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255, unique=true)
     */
    private $title;


    /**
     * @var string
     *
     * @ORM\Column(name="location", type="string", length=255, nullable=true)
     */
    private $location;

    /**
     * @ORM\ManyToOne(targetEntity="SBC\AWAPartnersBundle\Entity\Client")
     * @ORM\JoinColumn(nullable=true)
     */
    private $client;

    /**
     * @ORM\ManyToOne(targetEntity="SBC\AWAPartnersBundle\Entity\ProjectType")
     * @ORM\JoinColumn(nullable=false)
     */
    private $projecType;


    /**
     * @ORM\OneToMany(targetEntity="SBC\AWAPartnersBundle\Entity\ProjectPicture", mappedBy="project", cascade={"persist", "merge", "remove"})
     * @ORM\JoinColumn(name="project_picture_id", referencedColumnName="id")
     * @Assert\Valid()
     */

    private $pictures;


    /**
     * @var string
     *
     * @ORM\Column(name="surface_terrain", type="string", length=255, nullable=true)
     */
    private $surfaceTerrain;


    /**
     * @var string
     *
     * @ORM\Column(name="surface_couverte", type="string", length=255, nullable=true)
     */
    private $surfaceCouverte;

    /**
     * @var string
     *
     * @ORM\Column(name="cout", type="string", length=255, nullable=true)
     */
    private $cout;

    /**
     * @Vich\UploadableField(mapping="project_main_picture", fileNameProperty="mainPictureName")
     * @Assert\File(
     *     mimeTypes = {"image/png", "image/jpeg", "image/jpg"},
     *     mimeTypesMessage = "Please upload a valid IMAGE"
     * )
     *
     * @var File
     */
    private $mainPictureFile;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @var string
     */
    private $mainPictureName;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     *
     * @var \DateTime
     */
    private $updatedAt;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=true)
     */
    private $description;

    function jsonSerialize()
    {
        return get_object_vars($this);
    }

    public function __construct()
    {
        $this->creationDate = new \Datetime();
        $this->pictures = new ArrayCollection();

    }


    public function __toString()
    {
        return $this->title;
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
     * Set creationDate
     *
     * @param \DateTime $creationDate
     *
     * @return Project
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
     * Set note
     *
     * @param string $note
     *
     * @return Project
     */
    public function setNote($note)
    {
        $this->note = $note;

        return $this;
    }

    /**
     * Get note
     *
     * @return string
     */
    public function getNote()
    {
        return $this->note;
    }


    /**
     * Set title
     *
     * @param string $title
     *
     * @return Project
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }


    /**
     * Set projecType
     *
     * @param \SBC\AWAPartnersBundle\Entity\ProjectType $projecType
     *
     * @return Project
     */
    public function setProjecType(ProjectType $projecType)
    {
        $this->projecType = $projecType;

        return $this;
    }

    /**
     * Get projecType
     *
     * @return \SBC\AWAPartnersBundle\Entity\ProjectType
     */
    public function getProjecType()
    {
        return $this->projecType;
    }

    /**
     * Add picture
     *
     * @param \SBC\AWAPartnersBundle\Entity\ProjectPicture $picture
     *
     * @return Project
     */
    public function addPicture(ProjectPicture $picture)
    {
        $picture->setProject($this);
        $this->pictures[] = $picture;

        return $this;
    }

    /**
     * Remove picture
     *
     * @param \SBC\AWAPartnersBundle\Entity\ProjectPicture $picture
     */
    public function removePicture(ProjectPicture $picture)
    {
        $this->pictures->removeElement($picture);
    }

    /**
     * Get pictures
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPictures()
    {
        return $this->pictures;
    }


    /**
     * Set location
     *
     * @param string $location
     *
     * @return Project
     */
    public function setLocation($location)
    {
        $this->location = $location;

        return $this;
    }

    /**
     * Get location
     *
     * @return string
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * Set client
     *
     * @param \SBC\AWAPartnersBundle\Entity\Client $client
     *
     * @return Project
     */
    public function setClient($client)
    {
        $this->client = $client;

        return $this;
    }

    /**
     * Get client
     *
     * @return \SBC\AWAPartnersBundle\Entity\Client
     */
    public function getClient()
    {
        return $this->client;
    }

    
    /**
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $mainPictureFile
     *
     * @return Project
     */
    public function setMainPictureFile(File $mainPictureFile = null)
    {
        $this->mainPictureFile = $mainPictureFile;

        if ($mainPictureFile) {
            $this->updatedAt = new \DateTime('now');
        }

        return $this;
    }

    /**
     * @return File|null
     */
    public function getMainPictureFile()
    {
        return $this->mainPictureFile;
    }

    /**
     *
     * @param string $mainPictureName
     *
     * @return Project
     */
    public function setMainPictureName($mainPictureName)
    {
        $this->mainPictureName = $mainPictureName;
        return $this;
    }

    /**
     *
     * @return string|null
     */
    public function getMainPictureName()
    {
        return $this->mainPictureName;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return Project
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
     * Set description
     *
     * @param string $description
     *
     * @return Project
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set conceptionPeriode
     *
     * @param string $conceptionPeriode
     *
     * @return Project
     */
    public function setConceptionPeriode($conceptionPeriode)
    {
        $this->conceptionPeriode = $conceptionPeriode;

        return $this;
    }

    /**
     * Get conceptionPeriode
     *
     * @return string
     */
    public function getConceptionPeriode()
    {
        return $this->conceptionPeriode;
    }

    /**
     * Set conceptionBeginDate
     *
     * @param \DateTime $conceptionBeginDate
     *
     * @return Project
     */
    public function setConceptionBeginDate($conceptionBeginDate)
    {
        $this->conceptionBeginDate = $conceptionBeginDate;

        return $this;
    }

    /**
     * Get conceptionBeginDate
     *
     * @return \DateTime
     */
    public function getConceptionBeginDate()
    {
        return $this->conceptionBeginDate;
    }

    /**
     * Set conceptionFinishDate
     *
     * @param \DateTime $conceptionFinishDate
     *
     * @return Project
     */
    public function setConceptionFinishDate($conceptionFinishDate)
    {
        $this->conceptionFinishDate = $conceptionFinishDate;

        return $this;
    }

    /**
     * Get conceptionFinishDate
     *
     * @return \DateTime
     */
    public function getConceptionFinishDate()
    {
        return $this->conceptionFinishDate;
    }

    /**
     * Set constructionPeriode
     *
     * @param string $constructionPeriode
     *
     * @return Project
     */
    public function setConstructionPeriode($constructionPeriode)
    {
        $this->constructionPeriode = $constructionPeriode;

        return $this;
    }

    /**
     * Get constructionPeriode
     *
     * @return string
     */
    public function getConstructionPeriode()
    {
        return $this->constructionPeriode;
    }

    /**
     * Set constructionBeginDate
     *
     * @param \DateTime $constructionBeginDate
     *
     * @return Project
     */
    public function setConstructionBeginDate($constructionBeginDate)
    {
        $this->constructionBeginDate = $constructionBeginDate;

        return $this;
    }

    /**
     * Get constructionBeginDate
     *
     * @return \DateTime
     */
    public function getConstructionBeginDate()
    {
        return $this->constructionBeginDate;
    }

    /**
     * Set constructionFinishDate
     *
     * @param \DateTime $constructionFinishDate
     *
     * @return Project
     */
    public function setConstructionFinishDate($constructionFinishDate)
    {
        $this->constructionFinishDate = $constructionFinishDate;

        return $this;
    }

    /**
     * Get constructionFinishDate
     *
     * @return \DateTime
     */
    public function getConstructionFinishDate()
    {
        return $this->constructionFinishDate;
    }

    /**
     * Set composante
     *
     * @param string $composante
     *
     * @return Project
     */
    public function setComposante($composante)
    {
        $this->composante = $composante;

        return $this;
    }

    /**
     * Get composante
     *
     * @return string
     */
    public function getComposante()
    {
        return $this->composante;
    }

    /**
     * Set conceptionTeam
     *
     * @param string $conceptionTeam
     *
     * @return Project
     */
    public function setConceptionTeam($conceptionTeam)
    {
        $this->conceptionTeam = $conceptionTeam;

        return $this;
    }

    /**
     * Get conceptionTeam
     *
     * @return string
     */
    public function getConceptionTeam()
    {
        return $this->conceptionTeam;
    }

    /**
     * Set tache
     *
     * @param string $tache
     *
     * @return Project
     */
    public function setTache($tache)
    {
        $this->tache = $tache;

        return $this;
    }

    /**
     * Get tache
     *
     * @return string
     */
    public function getTache()
    {
        return $this->tache;
    }

    /**
     * Set company
     *
     * @param string $company
     *
     * @return Project
     */
    public function setCompany($company)
    {
        $this->company = $company;

        return $this;
    }

    /**
     * Get company
     *
     * @return string
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * Set mission
     *
     * @param string $mission
     *
     * @return Project
     */
    public function setMission($mission)
    {
        $this->mission = $mission;

        return $this;
    }

    /**
     * Get mission
     *
     * @return string
     */
    public function getMission()
    {
        return $this->mission;
    }

    /**
     * Set maitreOuvrage
     *
     * @param string $maitreOuvrage
     *
     * @return Project
     */
    public function setMaitreOuvrage($maitreOuvrage)
    {
        $this->maitreOuvrage = $maitreOuvrage;

        return $this;
    }

    /**
     * Get maitreOuvrage
     *
     * @return string
     */
    public function getMaitreOuvrage()
    {
        return $this->maitreOuvrage;
    }

    /**
     * Set surfaceTerrain
     *
     * @param string $surfaceTerrain
     *
     * @return Project
     */
    public function setSurfaceTerrain($surfaceTerrain)
    {
        $this->surfaceTerrain = $surfaceTerrain;

        return $this;
    }

    /**
     * Get surfaceTerrain
     *
     * @return string
     */
    public function getSurfaceTerrain()
    {
        return $this->surfaceTerrain;
    }

    /**
     * Set surfaceCouverte
     *
     * @param string $surfaceCouverte
     *
     * @return Project
     */
    public function setSurfaceCouverte($surfaceCouverte)
    {
        $this->surfaceCouverte = $surfaceCouverte;

        return $this;
    }

    /**
     * Get surfaceCouverte
     *
     * @return string
     */
    public function getSurfaceCouverte()
    {
        return $this->surfaceCouverte;
    }

    /**
     * Set cout
     *
     * @param string $cout
     *
     * @return Project
     */
    public function setCout($cout)
    {
        $this->cout = $cout;

        return $this;
    }

    /**
     * Get cout
     *
     * @return string
     */
    public function getCout()
    {
        return $this->cout;
    }
}
