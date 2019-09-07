<?php

namespace InstitutionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use InstitutionBundle\Entity\Address;
use InstitutionBundle\Model\ExtendInstitution;
use JMS\Serializer\Annotation as JMS;
use Oro\Bundle\EntityBundle\EntityProperty\DatesAwareInterface;
use Oro\Bundle\EntityBundle\EntityProperty\DatesAwareTrait;
use Oro\Bundle\EntityConfigBundle\Metadata\Annotation\Config;
use Oro\Bundle\EntityConfigBundle\Metadata\Annotation\ConfigField;
use Oro\Bundle\UserBundle\Entity\User;

/**
 * This entity represents a institution of a system
 *
 * @ORM\Entity(repositoryClass="InstitutionBundle\Entity\Repository\InstitutionRepository")
 * @ORM\Table(name="fnz_institution")
 * @Config(
 *      routeName="fnz.institution.institution_index",
 *      routeView="fnz.institution.institution_view",
 *      defaultValues={
 *          "entity"={
 *              "icon"="fa-user"
 *          },
 *          "grouping"={
 *              "groups"={"dictionary"}
 *          },
 *          "dictionary"={
 *              "virtual_fields"={"id"},
 *              "search_fields"={"name", "branchNumber"},
 *              "representation_field"="name",
 *              "activity_support"="true"
 *          },
 *          "dataaudit"={"auditable"=true},
 *          "security"={
 *              "type"="ACL",
 *              "group_name"="institution",
 *          },
 *          "form"={
 *              "form_type"="InstitutionBundle\Form\Type\InstitutionSelectType",
 *              "grid_name"="institutions-select-grid"
 *          },
 *          "grid"={
 *              "default"="institutions-grid",
 *          }
 *      }
 * )
 * @JMS\ExclusionPolicy("ALL")
 */
class Institution extends ExtendInstitution implements DatesAwareInterface
{

    use DatesAwareTrait;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @JMS\Type("integer")
     * @JMS\Expose
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, unique=true)
     * @JMS\Type("string")
     * @JMS\Expose
     * @ConfigField(
     *      defaultValues={
     *          "dataaudit"={
     *              "auditable"=true
     *          }
     *      }
     * )
     */
    protected $name;

    /**
     * @var string
     *
     * @ORM\Column(name="branch_number", type="string", length=255)
     * @ConfigField(
     *      defaultValues={
     *          "dataaudit"={
     *              "auditable"=true
     *          }
     *      }
     * )
     */
    protected $branchNumber;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=11, unique=true, unique=true)
     * @JMS\Type("string")
     * @JMS\Expose
     * @ConfigField(
     *      defaultValues={
     *          "dataaudit"={
     *              "auditable"=true
     *          }
     *      }
     * )
     */
    protected $bic;

    /**
     * @var string
     *
     * @ORM\Column(name="iban", type="string", length=255, unique=true)
     * @ConfigField(
     *      defaultValues={
     *          "dataaudit"={
     *              "auditable"=true
     *          }
     *      }
     * )
     */
    protected $iban;

    /**
     * @var Address
     *
     * @ORM\ManyToOne(targetEntity="InstitutionBundle\Entity\Address", cascade={"persist"})
     * @ORM\JoinColumn(name="address_id", referencedColumnName="id")
     * @ConfigField(
     *      defaultValues={
     *          "dataaudit"={
     *              "auditable"=true
     *          }
     *      }
     * )
     */
    protected $address;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="Oro\Bundle\UserBundle\Entity\User")
     * @ORM\JoinColumn(name="created_by_user_id", referencedColumnName="id", onDelete="SET NULL")
     * @ConfigField(
     *      defaultValues={
     *          "dataaudit"={
     *              "auditable"=true
     *          }
     *      }
     * )
     */
    protected $createdBy;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="Oro\Bundle\UserBundle\Entity\User")
     * @ORM\JoinColumn(name="updated_by_user_id", referencedColumnName="id", onDelete="SET NULL")
     * @ConfigField(
     *      defaultValues={
     *          "dataaudit"={
     *              "auditable"=true
     *          }
     *      }
     * )
     */
    protected $updatedBy;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     * @JMS\Type("date")
     * @ConfigField(
     *      defaultValues={
     *          "entity"={
     *              "label"="oro.ui.updated_at"
     *          }
     *      }
     * )
     */
    protected $updatedAt;

    /**
     * @var bool
     */
    protected $updatedAtSet;

    /**
     * @var \DateTime
     *
     * @Doctrine\ORM\Mapping\Column(name="created_at", type="datetime", nullable=true)
     * @ConfigField(
     *      defaultValues={
     *          "entity"={
     *              "label"="oro.ui.updated_at"
     *          }
     *      }
     * )
     */
    protected $createdAt;

    /**
     * Get the value of Id
     *
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of Id
     *
     * @param mixed id
     *
     * @return self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of Name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of Name
     *
     * @param string name
     *
     * @return self
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the value of Branch Number
     *
     * @return string
     */
    public function getBranchNumber()
    {
        return $this->branchNumber;
    }

    /**
     * Set the value of Branch Number
     *
     * @param string branchNumber
     *
     * @return self
     */
    public function setBranchNumber($branchNumber)
    {
        $this->branchNumber = $branchNumber;

        return $this;
    }

    /**
     * Get the value of Bic
     *
     * @return string
     */
    public function getBic()
    {
        return $this->bic;
    }

    /**
     * Set the value of Bic
     *
     * @param string bic
     *
     * @return self
     */
    public function setBic($bic)
    {
        $this->bic = $bic;

        return $this;
    }

    /**
     * Get the value of Iban
     *
     * @return string
     */
    public function getIban()
    {
        return $this->iban;
    }

    /**
     * Set the value of Iban
     *
     * @param string iban
     *
     * @return self
     */
    public function setIban($iban)
    {
        $this->iban = $iban;

        return $this;
    }


    /**
     * Get the value of Address
     *
     * @return Address
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set the value of Address
     *
     * @param Address address
     *
     * @return self
     */
    public function setAddress(Address $address)
    {
        $this->address = $address;

        return $this;
    }

}
