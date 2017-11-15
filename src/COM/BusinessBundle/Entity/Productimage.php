<?php

namespace COM\BusinessBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * Productimage
 *
 * @ORM\Table(name="bs_productimage")
 * @ORM\Entity(repositoryClass="COM\BusinessBundle\Entity\ProductimageRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Productimage
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="path", type="string", length=255, nullable=true)
     */
    private $path;

    /**
     * @var string
     *
     * @ORM\Column(name="originalname", type="string", length=255, nullable=true)
     */
    private $originalname;
	
    /**
    * @ORM\ManyToOne(targetEntity="COM\BusinessBundle\Entity\Product")
    * @ORM\JoinColumn(nullable=false)
    */
    private $product;
	
    /**
     * @var boolean
     *
     * @ORM\Column(name="current", type="boolean")
     */
    private $current;

    /**
     * @Assert\File(maxSize="2m", maxSizeMessage = "The file is too large ({{ size }})", mimeTypes = {"image/jpg", "image/jpeg", "image/gif", "image/png"}, mimeTypesMessage = "Please upload a valid Image")
     */
    public $file;
    
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
     * Set name
     *
     * @param string $name
     * @return Productimage
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
     * Set path
     *
     * @param string $path
     * @return Productimage
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get path
     *
     * @return string 
     */
    public function getPath()
    {
        return $this->path;
    }
    
    /**
     * Set originalname
     *
     * @param string $originalname
     * @return Productimage
     */
    public function setOriginalname($originalname)
    {
        $this->originalname = $originalname;

        return $this;
    }

    /**
     * Get originalname
     *
     * @return string 
     */
    public function getOriginalname()
    {
        return $this->originalname;
    }
    
    public function getAbsolutePath()
    {
        return null === $this->path ? null : $this->getUploadRootDir().'/'.$this->path;
    }

    public function getWebPath()
    {
        return null === $this->path ? null : $this->getUploadDir().'/'.$this->path;
    }

    protected function getUploadRootDir()
    {
        // le chemin absolu du répertoire où les documents uploadés doivent être sauvegardés
        return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }

    protected function getUploadDir()
    {
        return 'upload/image/product';
    }
    
    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()
    {
        if (null !== $this->file) {
            // generation nom unique
			$t=time();
			
            $this->path = substr(sha1(uniqid(mt_rand(), true)), 0, 15).'_'.$this->product->getId().'_'.$t.'.'.$this->file->guessExtension();
            $this->originalname = $this->file->getClientOriginalName();
            $this->name = $this->file->getClientOriginalName();
        }
    }
    
    /*
    public function upload()
    {
        // la propriété « file » peut être vide si le champ n'est pas requis
        if (null === $this->file) {
            return;
        }

        // utilisez le nom de fichier original ici mais
        // vous devriez « l'assainir » pour au moins éviter
        // quelconques problèmes de sécurité

        // la méthode « move » prend comme arguments le répertoire cible et
        // le nom de fichier cible où le fichier doit être déplacé
        $this->file->move($this->getUploadRootDir(), $this->file->getClientOriginalName());

        // définit la propriété « path » comme étant le nom de fichier où vous
        // avez stocké le fichier
        $this->path = $this->file->getClientOriginalName();

        // « nettoie » la propriété « file » comme vous n'en aurez plus besoin
        $this->file = null;
    }*/
    
    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload()
    {
        if (null === $this->file) {
            return;
        }

        // s'il y a une erreur lors du déplacement du fichier, une exception
        // va automatiquement être lancée par la méthode move(). Cela va empêcher
        // proprement l'entité d'être persistée dans la base de données si
        // erreur il y a
        $this->file->move($this->getUploadRootDir(), $this->path);

        unset($this->file);
    }

    /**
     * @ORM\PostRemove()
     */
    public function removeUpload()
    {
		//Suppression du fichier principal
		$file = $this->getAbsolutePath();
        if (file_exists($file)) {
            unlink($file);
        }
		
		//Suppression des fichiers dans le dossier créé par le bundle liip . see app/config/liip.yml
		$dossiers = array(
			"32x32", 
			"40x40", 
			"50x50", 
			"60x60", 
			"80x80", 
			"120x120",
		);
		foreach ($dossiers as $dossier) {
			$file = __DIR__.'/../../../../web/media/'.$dossier.'/'.$this->getUploadDir().'/'.$this->path;
			if (file_exists($file)) {
				unlink($file);
			}
		}

    }


    /**
     * Set current
     *
     * @param boolean $current
     *
     * @return Productimage
     */
    public function setCurrent($current)
    {
        $this->current = $current;

        return $this;
    }

    /**
     * Get current
     *
     * @return boolean
     */
    public function getCurrent()
    {
        return $this->current;
    }

    /**
     * Set product
     *
     * @param \COM\BusinessBundle\Entity\Product $product
     *
     * @return Productimage
     */
    public function setProduct(\COM\BusinessBundle\Entity\Product $product)
    {
        $this->product = $product;

        return $this;
    }

    /**
     * Get product
     *
     * @return \COM\BusinessBundle\Entity\Product
     */
    public function getProduct()
    {
        return $this->product;
    }
}
