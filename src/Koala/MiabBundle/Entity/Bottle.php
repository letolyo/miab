<?php

namespace Koala\MiabBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
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
     * @ORM\Column(type="string")
     */
    protected $message;

    /**
     * @ORM\Column(type="string", length=32)
     */
    protected $bottleHash;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $createDate;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $nextApparitionDate;

    /**
     * @ORM\Column(type="integer")
     */
    protected $periodicity;

    /**
     * @ORM\Column(type="integer")
     */
    protected $visibilite;

    /**
     * @ORM\Column(type="integer")
     */
    protected $bottleChoice;

    /**
     * @ORM\Column(type="integer")
     */
    protected $parcheminChoice;

     /**
     * @var string $image
     * @Assert\File( maxSize = "1024k", mimeTypesMessage = "Please upload a valid Image")
     * @ORM\Column(name="image", type="string", length=255)
     */
    private $image;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set bottleHash
     *
     * @param string $bottleHash
     * @return Bottle
     */
    public function setBottleHash($bottleHash)
    {
        $this->bottleHash = $bottleHash;
    
        return $this;
    }

    /**
     * Get bottleHash
     *
     * @return string 
     */
    public function getBottleHash()
    {
        return $this->bottleHash;
    }

    /**
     * Set createDate
     *
     * @param \DateTime $createDate
     * @return Bottle
     */
    public function setCreateDate($createDate)
    {
        $this->createDate = $createDate;
    
        return $this;
    }

    /**
     * Get createDate
     *
     * @return \DateTime 
     */
    public function getCreateDate()
    {
        return $this->createDate;
    }

    /**
     * Set nextApparitionDate
     *
     * @param \DateTime $nextApparitionDate
     * @return Bottle
     */
    public function setNextApparitionDate($nextApparitionDate)
    {
        $this->nextApparitionDate = $nextApparitionDate;
    
        return $this;
    }

    /**
     * Get nextApparitionDate
     *
     * @return \DateTime 
     */
    public function getNextApparitionDate()
    {
        return $this->nextApparitionDate;
    }

    /**
     * Set periodicity
     *
     * @param integer $periodicity
     * @return Bottle
     */
    public function setPeriodicity($periodicity)
    {
        $this->periodicity = $periodicity;
    
        return $this;
    }

    /**
     * Get periodicity
     *
     * @return integer 
     */
    public function getPeriodicity()
    {
        return $this->periodicity;
    }

    /**
     * Set visibilite
     *
     * @param integer $visibilite
     * @return Bottle
     */
    public function setVisibilite($visibilite)
    {
        $this->visibilite = $visibilite;
    
        return $this;
    }

    /**
     * Get visibilite
     *
     * @return integer 
     */
    public function getVisibilite()
    {
        return $this->visibilite;
    }

    /**
     * Set bottleChoice
     *
     * @param integer $bottleChoice
     * @return Bottle
     */
    public function setBottleChoice($bottleChoice)
    {
        $this->bottleChoice = $bottleChoice;
    
        return $this;
    }

    /**
     * Get bottleChoice
     *
     * @return integer 
     */
    public function getBottleChoice()
    {
        return $this->bottleChoice;
    }

    /**
     * Set parcheminChoice
     *
     * @param integer $parcheminChoice
     * @return Bottle
     */
    public function setParcheminChoice($parcheminChoice)
    {
        $this->parcheminChoice = $parcheminChoice;
    
        return $this;
    }

    /**
     * Get parcheminChoice
     *
     * @return integer 
     */
    public function getParcheminChoice()
    {
        return $this->parcheminChoice;
    }

    /**
     * Set message
     *
     * @param string $message
     * @return Bottle
     */
    public function setMessage($message)
    {
        $this->message = $message;
    
        return $this;
    }

    /**
     * Get message
     *
     * @return string 
     */
    public function getMessage()
    {
        return $this->message;
    }



 
    /**
     * Set image
     *
     * @param string $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }
 
    /**
     * Get image
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

        public function getFullImagePath() {
        return null === $this->image ? null : $this->getUploadRootDir(). $this->image;
    }
 
    protected function getUploadRootDir() {
        // the absolute directory path where uploaded documents should be saved
        return $this->getTmpUploadRootDir().$this->getId()."/";
    }
 
    protected function getTmpUploadRootDir() {
        // the absolute directory path where uploaded documents should be saved
        return __DIR__ . '/../../../../web/upload/';
    }
 
    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function uploadImage() {
        // the file property can be empty if the field is not required
        if (null === $this->image) {
            return;
        }
        if(!$this->id){
            $this->image->move($this->getTmpUploadRootDir(), $this->image->getClientOriginalName());
        }else{
            $this->image->move($this->getUploadRootDir(), $this->image->getClientOriginalName());
        }
        $this->setImage($this->image->getClientOriginalName());
    }
 
    /**
     * @ORM\PostPersist()
     */
    public function moveImage()
    {
        if (null === $this->image) {
            return;
        }
        if(!is_dir($this->getUploadRootDir())){
            mkdir($this->getUploadRootDir());
        }
        copy($this->getTmpUploadRootDir().$this->image, $this->getFullImagePath());
        unlink($this->getTmpUploadRootDir().$this->image);
    }
 
    /**
     * @ORM\PreRemove()
     */
    public function removeImage()
    {
        unlink($this->getFullImagePath());
        rmdir($this->getUploadRootDir());
    }
}