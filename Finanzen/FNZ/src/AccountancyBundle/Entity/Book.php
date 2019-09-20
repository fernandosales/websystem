<?php


namespace AccountancyBundle\Entity;

use AccountancyBundle\Model\ExtendBook;
use DateTime;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use InstitutionBundle\Entity\Account;
use JMS\Serializer\Annotation as JMS;
use Oro\Bundle\EntityBundle\EntityProperty\DatesAwareInterface;
use Oro\Bundle\EntityBundle\EntityProperty\DatesAwareTrait;
use Oro\Bundle\EntityConfigBundle\Metadata\Annotation\Config;
use Oro\Bundle\EntityConfigBundle\Metadata\Annotation\ConfigField;
use Oro\Bundle\UserBundle\Entity\User;

/**
 * This entity represents a log of a system
 *
 * @ORM\Entity(repositoryClass="AccountancyBundle\Entity\Repository\BookRepository")
 * @ORM\Table(name="fnz_book")
 * @Config(
 *      routeName="fnz.book.book_index",
 *      routeView="fnz.book.book_view",
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
 *              "form_type"="AccountancyBundle\Form\Type\BookSelectType",
 *              "grid_name"="books-select-grid"
 *          },
 *          "grid"={
 *              "default"="books-grid",
 *          }
 *      }
 * )
 * @JMS\ExclusionPolicy("ALL")
 */
class Book extends ExtendBook implements
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
     * @var Collection|Record[]
     *
     * @ORM\OneToMany(
     *      targetEntity="AccountancyBundle\Entity\Record",
     *      mappedBy="book",
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
     * @var Account
     *
     * @ORM\OneToOne(targetEntity="InstitutionBundle\Entity\Account", mappedBy="book")
     * @JMS\Exclude
     */
    protected $account;

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
     * @param User $createdBy
     * @return Book
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
     * @param User $updatedBy
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
     * @param DateTime|null $updatedAt
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
     * @param DateTime|null $createdAt
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