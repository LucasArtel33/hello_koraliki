<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Image
 *
 * @ORM\Table(name="img")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ImageRepository")
 */
class Image
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
     * @ORM\Column(name="img1", type="string", length=255)
     */
    private $img1;

    /**
     * @var string
     *
     * @ORM\Column(name="img2", type="string", length=255)
     */
    private $img2;

    /**
     * @var string
     *
     * @ORM\Column(name="img3", type="string", length=255)
     */
    private $img3;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getImg1()
    {
        return $this->img1;
    }

    /**
     * @param string $img1
     */
    public function setImg1($img1)
    {
        $this->img1 = $img1;
    }

    /**
     * @return string
     */
    public function getImg2()
    {
        return $this->img2;
    }

    /**
     * @param string $img2
     */
    public function setImg2($img2)
    {
        $this->img2 = $img2;
    }

    /**
     * @return string
     */
    public function getImg3()
    {
        return $this->img3;
    }

    /**
     * @param string $img3
     */
    public function setImg3($img3)
    {
        $this->img3 = $img3;
    }



}
