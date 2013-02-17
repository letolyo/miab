<?php

namespace Koala\MiabBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="miab_bottle")
 */
class Bottle
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\
     * @ORM\Column(type="")
     */
    protected $name;

    /**
     * @ORM\
     * @ORM\Column(type="")
     */
    protected $description;

    /**
     * @ORM\
     * @ORM\Column(type="")
     */
    protected $tags;

    /**
     * @ORM\
     * @ORM\Column(type="")
     */
    protected $bottleHash;

    /**
     * @ORM\
     * @ORM\Column(type="")
     */
    protected $createDate;

    /**
     * @ORM\
     * @ORM\Column(type="")
     */
    protected $sendDate;

    /**
     * @ORM\
     * @ORM\Column(type="")
     */
    protected $periodicity;

    /**
     * @ORM\
     * @ORM\Column(type="")
     */
    protected $visibilite;

    /**
     * @ORM\
     * @ORM\Column(type="")
     */
    protected $bottleChoice;

    /**
     * @ORM\
     * @ORM\Column(type="")
     */
    protected $parcheminChoice;


}
?>
