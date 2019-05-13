<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Orders
 *
 * @ORM\Table(name="orders")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\OrdersRepository")
 */
class Orders
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
     * @ORM\ManyToOne(targetEntity="Status_orders")
     */
    private $statusOrder;

    /**
     * @ORM\ManyToMany(targetEntity="Product", mappedBy="order")
     */
    private $products;

    /**
     * @ORM\ManyToMany(targetEntity="Users", mappedBy="order")
     */
    private $users;

    /**
     * @var date
     *
     * @ORM\Column(name="date", type="date")
     */
    private $dateCommande;

    /**
     * @return date
     */
    public function getDateCommande()
    {
        return $this->dateCommande;
    }

    /**
     * @param date $dateCommande
     */
    public function setDateCommande($dateCommande)
    {
        $this->dateCommande = $dateCommande;
    }

    /**
     * @return mixed
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * @param mixed $users
     */
    public function setUsers($users)
    {
        $this->users = $users;
    }

    /**
     * @return mixed
     */
    public function getProducts()
    {
        return $this->products;
    }

    /**
     * @param mixed $products
     */
    public function setProducts($products)
    {
        $this->products = $products;
    }

    /**
     * @return mixed
     */
    public function getStatusOrder()
    {
        return $this->statusOrder;
    }

    /**
     * @param mixed $statusOrder
     */
    public function setStatusOrder($statusOrder)
    {
        $this->statusOrder = $statusOrder;
    }

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
}
