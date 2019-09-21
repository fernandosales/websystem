<?php

namespace AccountancyBundle\Entity;

use AccountancyBundle\Model\ExtendBeneficiary;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;
use Oro\Bundle\EntityConfigBundle\Metadata\Annotation\Config;
use Oro\Bundle\EntityConfigBundle\Metadata\Annotation\ConfigField;
use Oro\Bundle\UserBundle\Entity\User;

/**
 * This entity represents a beneficiary of a system
 *
 * @ORM\Entity(repositoryClass="AccountancyBundle\Entity\Repository\BeneficiaryRepository")
 * @ORM\Table(name="fnz_beneficiary")
 * @Config(
 *      routeName="fnz.beneficiary.beneficiary_index",
 *      routeView="fnz.beneficiary.beneficiary_view",
 *      defaultValues={
 *          "entity"={
 *              "icon"="fa-users"
 *          },
 *          "grouping"={
 *              "groups"={"dictionary"}
 *          },
 *          "dictionary"={
 *              "virtual_fields"={"id"},
 *              "search_fields"={"firstName"},
 *              "representation_field"="firstName",
 *              "activity_support"="true"
 *          },
 *          "dataaudit"={"auditable"=true},
 *          "security"={
 *              "type"="ACL",
 *              "group_name"="accountancy",
 *              "field_acl_supported" = "true"
 *          },
 *          "form"={
 *              "form_type"="AccountancyBundle\Form\Type\BeneficiarySelectType",
 *              "grid_name"="beneficiaries-select-grid"
 *          },
 *          "grid"={
 *              "default"="beneficiaries-grid",
 *          }
 *      }
 * )
 * @JMS\ExclusionPolicy("ALL")
 */
class Beneficiary extends ExtendBeneficiary
{

  /**
   * @var Category
   *
   * @ORM\ManyToOne(targetEntity="Category", cascade={"persist"})
   * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
   * @ConfigField(
   *      defaultValues={
   *          "dataaudit"={
   *              "auditable"=true
   *          }
   *      }
   * )
   */
   protected $defaultCategory;

    /**
     * @var Collection|Record[]
     *
     * @ORM\OneToMany(
     *      targetEntity="AccountancyBundle\Entity\Record",
     *      mappedBy="beneficiary",
     *      cascade={"all"},
     *      orphanRemoval=true
     *)
     * @ConfigField(
     *      defaultValues={
     *          "dataaudit"={
     *              "auditable"=true
     *          }
     *   }
     *)
     */
    private $records;

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
     * Get the value of Default Category
     *
     * @return Category
     */
    public function getDefaultCategory()
    {
        return $this->defaultCategory;
    }

    /**
     * Set the value of Default Category
     *
     * @param Category defaultCategory
     *
     * @return self
     */
    public function setDefaultCategory(Category $defaultCategory)
    {
        $this->defaultCategory = $defaultCategory;

        return $this;
    }

    /**
     * Get the value of Created By
     *
     * @return User
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    /**
     * Set the value of Created By
     *
     * @param User createdBy
     *
     * @return self
     */
    public function setCreatedBy(User $createdBy)
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    /**
     * Get the value of Updated By
     *
     * @return User
     */
    public function getUpdatedBy()
    {
        return $this->updatedBy;
    }

    /**
     * Set the value of Updated By
     *
     * @param User updatedBy
     *
     * @return self
     */
    public function setUpdatedBy(User $updatedBy)
    {
        $this->updatedBy = $updatedBy;

        return $this;
    }

    /**
     * Get the value of Updated At
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set the value of Updated At
     *
     * @param \DateTime updatedAt
     *
     * @return self
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get the value of Updated At Set
     *
     * @return bool
     */
    public function getUpdatedAtSet()
    {
        return $this->updatedAtSet;
    }

    /**
     * Set the value of Updated At Set
     *
     * @param bool updatedAtSet
     *
     * @return self
     */
    public function setUpdatedAtSet($updatedAtSet)
    {
        $this->updatedAtSet = $updatedAtSet;

        return $this;
    }

    /**
     * Get the value of Created At
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set the value of Created At
     *
     * @param \DateTime createdAt
     *
     * @return self
     */
    public function setCreatedAt($createdAt = null)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return bool
     */
    public function isUpdatedAtSet()
    {
        return $this->updatedAtSet;
    }
}
