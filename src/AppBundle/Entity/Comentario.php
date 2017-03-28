<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Comentario
 *
 * @ORM\Table(name="comentario")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ComentarioRepository")
 */
class Comentario
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
     * @ORM\Column(name="texto", type="string", length=255)
     */
    private $texto;

    /**
     * @var int
     *
     * @ORM\Column(name="likes", type="integer", nullable=true)
     */
    private $likes;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime")
     */
    private $updatedAt;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Proyecto", inversedBy="proyecto")
     */
    private $proyecto;

    /**
     * @ORM\ManyToOne(targetEntity="Trascastro\UserBundle\Entity\User", inversedBy="comentariosCreados")
     */
    private $creador;


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
     * Set texto
     *
     * @param string $texto
     *
     * @return Comentario
     */
    public function setTexto($texto)
    {
        $this->texto = $texto;

        return $this;
    }

    /**
     * Get texto
     *
     * @return string
     */
    public function getTexto()
    {
        return $this->texto;
    }

    /**
     * Set likes
     *
     * @param integer $likes
     *
     * @return Comentario
     */
    public function setLikes($likes)
    {
        $this->likes = $likes;

        return $this;
    }

    /**
     * Get likes
     *
     * @return int
     */
    public function getLikes()
    {
        return $this->likes;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Comentario
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return Comentario
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = new \DateTime();

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

    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->updatedAt = $this->createdAt;

    }

    /**
     * Add proyecto
     *
     * @param \AppBundle\Entity\Proyecto $proyecto
     *
     * @return Comentario
     */
    public function addProyecto(\AppBundle\Entity\Proyecto $proyecto)
    {
        $this->proyecto[] = $proyecto;

        return $this;
    }

    /**
     * Remove proyecto
     *
     * @param \AppBundle\Entity\Proyecto $proyecto
     */
    public function removeProyecto(\AppBundle\Entity\Proyecto $proyecto)
    {
        $this->proyecto->removeElement($proyecto);
    }

    /**
     * Get proyecto
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProyecto()
    {
        return $this->proyecto;
    }

    /**
     * Set proyecto
     *
     * @param \AppBundle\Entity\Proyecto $proyecto
     *
     * @return Comentario
     */
    public function setProyecto(\AppBundle\Entity\Proyecto $proyecto = null)
    {
        $this->proyecto = $proyecto;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getCreador()
    {
        return $this->creador;
    }

    /**
     * @param mixed $creador
     */
    public function setCreador($creador)
    {
        $this->creador = $creador;
    }


}
