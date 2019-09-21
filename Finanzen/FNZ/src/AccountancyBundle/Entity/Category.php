<?php

namespace AccountancyBundle\Entity;

use AccountancyBundle\Model\ExtendCategory;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;
use Oro\Bundle\EntityBundle\EntityProperty\DatesAwareInterface;
use Oro\Bundle\EntityBundle\EntityProperty\DatesAwareTrait;
use Oro\Bundle\EntityConfigBundle\Metadata\Annotation\Config;
use Oro\Bundle\EntityConfigBundle\Metadata\Annotation\ConfigField;
use Oro\Bundle\UserBundle\Entity\User;

/**
 * This entity represents a category of a system
 *
 * @ORM\Entity(repositoryClass="AccountancyBundle\Entity\Repository\CategoryRepository")
 * @ORM\Table(name="fnz_category")
 * @Config(
 *      routeName="fnz.category.category_index",
 *      routeView="fnz.category.category_view",
 *      defaultValues={
 *          "entity"={
 *              "icon"="fa-bookmark"
 *          },
 *          "grouping"={
 *              "groups"={"dictionary"}
 *          },
 *          "dictionary"={
 *              "virtual_fields"={"id"},
 *              "search_fields"={"name"},
 *              "representation_field"="name",
 *              "activity_support"="true"
 *          },
 *          "dataaudit"={"auditable"=true},
 *          "security"={
 *              "type"="ACL",
 *              "group_name"="accountancy",
 *              "field_acl_supported" = "true"
 *          },
 *          "form"={
 *              "form_type"="AccountancyBundle\Form\Type\CategorySelectType",
 *              "grid_name"="categories-select-grid"
 *          },
 *          "grid"={
 *              "default"="categories-grid",
 *          }
 *      }
 * )
 * @JMS\ExclusionPolicy("ALL")
 */
class Category extends ExtendCategory implements
    DatesAwareInterface
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
   * @ORM\Column(name="name", type="string", length=255, nullable=true)
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
   * @var integer
   *
   * @ORM\Column(name="type", type="integer", nullable=true)
   * @JMS\Type("integer")
   * @JMS\Expose
   * @ConfigField(
   *      defaultValues={
   *          "dataaudit"={
   *              "auditable"=true
   *          }
   *      }
   * )
   */
  protected $type;

  /**
   * @var Category
   *
   * @ORM\ManyToOne(targetEntity="Category", cascade={"persist"})
   * @ORM\JoinColumn(name="parent_category_id", referencedColumnName="id")
   * @ConfigField(
   *      defaultValues={
   *          "dataaudit"={
   *              "auditable"=true
   *          }
   *      }
   * )
   */
   protected $parentCategory;

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
     * Get the value of Type
     *
     * @return integer
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set the value of Type
     *
     * @param integer type
     *
     * @return self
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get the value of Parent Category
     *
     * @return Category
     */
    public function getParentCategory()
    {
        return $this->parentCategory;
    }

    /**
     * Set the value of Parent Category
     *
     * @param Category parentCategory
     *
     * @return self
     */
    public function setParentCategory(Category $parentCategory)
    {
        $this->parentCategory = $parentCategory;

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
    public function setUpdatedAt(\DateTime $updatedAt = null)
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
    public function setCreatedAt(\DateTime $createdAt = null)
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
