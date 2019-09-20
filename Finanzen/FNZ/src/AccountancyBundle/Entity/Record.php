<?php

namespace AccountancyBundle\Entity;

use AccountancyBundle\Model\ExtendRecord;
use DateTime;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;
use Oro\Bundle\EntityBundle\EntityProperty\DatesAwareInterface;
use Oro\Bundle\EntityBundle\EntityProperty\DatesAwareTrait;
use Oro\Bundle\EntityConfigBundle\Metadata\Annotation\Config;
use Oro\Bundle\EntityConfigBundle\Metadata\Annotation\ConfigField;
use Oro\Bundle\UserBundle\Entity\User;

/**
 * This entity represents a log of a system
 *
 * @ORM\Entity(repositoryClass="AccountancyBundle\Entity\Repository\RecordRepository")
 * @ORM\Table(name="fnz_record")
 * @Config(
 *      routeName="fnz.record.record_index",
 *      routeView="fnz.record.record_view",
 *      defaultValues={
 *          "entity"={
 *              "icon"="fa-book"
 *          },
 *          "grouping"={
 *              "groups"={"dictionary"}
 *          },
 *          "dictionary"={
 *              "virtual_fields"={"id"},
 *              "search_fields"={"memo"},
 *              "representation_field"="memo",
 *              "activity_support"="true"
 *          },
 *          "dataaudit"={"auditable"=true},
 *          "security"={
 *              "type"="ACL",
 *              "group_name"="accountancy",
 *              "field_acl_supported" = "true"
 *          },
 *          "form"={
 *              "form_type"="AccountancyBundle\Form\Type\LedgerLogSelectType",
 *              "grid_name"="records-select-grid"
 *          },
 *          "grid"={
 *              "default"="records-grid",
 *          }
 *      }
 * )
 * @JMS\ExclusionPolicy("ALL")
 */
class Record extends ExtendRecord implements
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
     * @ORM\Column(name="memo", type="string", length=255, nullable=true)
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
    protected $memo;

    /**
     * @var integer
     *
     * @ORM\Column(name="status", type="integer", length=3, nullable=true)
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
    protected $status;

    /**
     * @var integer
     *
     * @ORM\Column(name="operation", type="integer", length=3, nullable=true)
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
    protected $operation;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="date", type="date", nullable=true)
     * @ConfigField(
     *      defaultValues={
     *          "dataaudit"={
     *              "auditable"=true
     *          }
     *      }
     * )
     */
    protected $date;

    /**
     * @var double
     *
     * @ORM\Column(name="amount", type="decimal", nullable=true, precision = 19, scale = 4)
     * @ConfigField(
     *      defaultValues={
     *          "dataaudit"={
     *              "auditable"=true
     *          }
     *      }
     * )
     */
    protected $amount;

    /**
     * @var Beneficiary
     *
     * @ORM\ManyToOne(targetEntity="Beneficiary", cascade={"persist"})
     * @ORM\JoinColumn(name="beneficiary_id", referencedColumnName="id", onDelete="SET NULL")
     * @ConfigField(
     *      defaultValues={
     *          "dataaudit"={
     *              "auditable"=true
     *          }
     *      }
     * )
     */
    protected $beneficiary;

    /**
     * @var Category
     *
     * @ORM\ManyToOne(targetEntity="Category", cascade={"persist"})
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id", onDelete="SET NULL")
     * @ConfigField(
     *      defaultValues={
     *          "dataaudit"={
     *              "auditable"=true
     *          }
     *      }
     * )
     */
    protected $category;

    /**
     * @var Book
     *
     * @ORM\ManyToOne(
     *      targetEntity="AccountancyBundle\Entity\Book",
     *      inversedBy="records",
     *      cascade={"persist"}
     * )
     * @ORM\JoinColumn(name="book_id", referencedColumnName="id", nullable=false)
     * @ConfigField(
     *      defaultValues={
     *          "dataaudit"={
     *              "auditable"=true
     *          }
     *      }
     *)
     */
    protected $book;

    /**
     * @var Collection
     *
     * @ORM\ManyToMany(targetEntity="Tag", inversedBy="records")
     * @ORM\JoinTable(name="fnz_record_tag",
     *      joinColumns={@ORM\JoinColumn(name="record_id", referencedColumnName="id", onDelete="CASCADE")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="tag_id", referencedColumnName="id", onDelete="CASCADE")}
     * )
     * @ConfigField(
     *      defaultValues={
     *          "dataaudit"={
     *              "auditable"=true
     *          }
     *      }
     * )
     */
    protected $tags;

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
     * @var DateTime
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
     * @var DateTime
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
     * Get the value of Memo
     *
     * @return string
     */
    public function getMemo()
    {
        return $this->memo;
    }

    /**
     * Set the value of Memo
     *
     * @param string memo
     *
     * @return self
     */
    public function setMemo($memo)
    {
        $this->memo = $memo;

        return $this;
    }

    /**
     * Get the value of Status
     *
     * @return integer
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set the value of Status
     *
     * @param integer status
     *
     * @return self
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get the value of Operation
     *
     * @return integer
     */
    public function getOperation()
    {
        return $this->operation;
    }

    /**
     * Set the value of Operation
     *
     * @param integer operation
     *
     * @return self
     */
    public function setOperation($operation)
    {
        $this->operation = $operation;

        return $this;
    }

    /**
     * Get the value of Date
     *
     * @return DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set the value of Date
     *
     * @param DateTime date
     *
     * @return self
     */
    public function setDate(DateTime $date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get the value of Amount
     *
     * @return double
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Set the value of Amount
     *
     * @param double amount
     *
     * @return self
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Get the value of Beneficiary
     *
     * @return Beneficiary
     */
    public function getBeneficiary()
    {
        return $this->beneficiary;
    }

    /**
     * Set the value of Beneficiary
     *
     * @param Beneficiary beneficiary
     *
     * @return self
     */
    public function setBeneficiary(Beneficiary $beneficiary)
    {
        $this->beneficiary = $beneficiary;

        return $this;
    }

    /**
     * Get the value of Category
     *
     * @return Category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set the value of Category
     *
     * @param Category category
     *
     * @return self
     */
    public function setCategory(Category $category)
    {
        $this->category = $category;

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
     * @return DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set the value of Updated At
     *
     * @param DateTime updatedAt
     *
     * @return self
     */
    public function setUpdatedAt(DateTime $updatedAt = null)
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
     * @return DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set the value of Created At
     *
     * @param DateTime createdAt
     *
     * @return self
     */
    public function setCreatedAt(DateTime $createdAt = null)
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
