<?php

namespace InstitutionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use InstitutionBundle\Model\ExtendAccount;
use JMS\Serializer\Annotation as JMS;
use Oro\Bundle\EntityBundle\EntityProperty\DatesAwareInterface;
use Oro\Bundle\EntityBundle\EntityProperty\DatesAwareTrait;
use Oro\Bundle\EntityConfigBundle\Metadata\Annotation\Config;
use Oro\Bundle\EntityConfigBundle\Metadata\Annotation\ConfigField;
use Oro\Bundle\UserBundle\Entity\User;

/**
 * This entity represents a account of a system
 *
 * @ORM\Entity(repositoryClass="InstitutionBundle\Entity\Repository\AccountRepository")
 * @ORM\Table(name="fnz_account")
 * @Config(
 *      routeName="institution.account_index",
 *      routeView="institution.account_view",
 *      defaultValues={
 *          "entity"={
 *              "icon"="fa-user"
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
 *              "group_name"="institution",
 *              "field_acl_supported" = "true"
 *          },
 *          "form"={
 *              "form_type"="InstitutionBundle\Form\Type\AccountSelectType",
 *              "grid_name"="accounts-select-grid"
 *          },
 *          "grid"={
 *              "default"="accounts-grid",
 *          }
 *      }
 * )
 * @JMS\ExclusionPolicy("ALL")
 */
class Account extends ExtendAccount implements DatesAwareInterface
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
     * @ORM\Column(name="number", type="string", length=255)
     * @ConfigField(
     *      defaultValues={
     *          "dataaudit"={
     *              "auditable"=true
     *          }
     *      }
     * )
     */
    protected $number;

    /**
     * @var string
     *
     * @ORM\Column(name="currency", type="currency", length=3, nullable=true)
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
    protected $currency;

    /**
     * @var double
     *
     * @ORM\Column(name="opening_balance", type="money", nullable=true)
     * @ConfigField(
     *      defaultValues={
     *          "dataaudit"={
     *              "auditable"=true
     *          }
     *      }
     * )
     */
    protected $openingBalance;

    /**
     * @var double
     *
     * @ORM\Column(name="minimum_balance_to_notify", type="money", nullable=true)
     * @ConfigField(
     *      defaultValues={
     *          "dataaudit"={
     *              "auditable"=true
     *          }
     *      }
     * )
     */
    protected $minimumBalanceToNotify;

    /**
     * @var \DateTime $openingDate
     *
     * @ORM\Column(name="opening_date", type="datetime")
     * @ConfigField(
     *      defaultValues={
     *          "dataaudit"={
     *              "auditable"=true
     *          }
     *      }
     * )
     */
    protected $openingDate;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_favorite", type="boolean", nullable=true)
     * @ConfigField(
     *      defaultValues={
     *          "dataaudit"={
     *              "auditable"=true
     *          }
     *      }
     * )
     */
    protected $favorite;

    /**
     * @var string
     *
     * @ORM\Column(name="accounting_type", type="string", length=10, nullable=true)
     * @ConfigField(
     *      defaultValues={
     *          "dataaudit"={
     *              "auditable"=true
     *          }
     *      }
     * )
     */
    protected $accountingType;


    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=10, nullable=true)
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
     * @var Account
     *
     * @ORM\ManyToOne(targetEntity="Account", cascade={"persist"})
     * @ORM\JoinColumn(name="parent_account_id", referencedColumnName="id")
     * @ConfigField(
     *      defaultValues={
     *          "dataaudit"={
     *              "auditable"=true
     *          }
     *      }
     * )
     */
     protected $parentAccount;

     /**
      * @var Institution
      *
      * @ORM\ManyToOne(targetEntity="Institution", cascade={"persist"})
      * @ORM\JoinColumn(name="institution_id", referencedColumnName="id")
      * @ConfigField(
      *      defaultValues={
      *          "dataaudit"={
      *              "auditable"=true
      *          }
      *      }
      * )
      */
      protected $institution;

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
       * @Doctrine\ORM\Mapping\Column(name="updated_at", type="datetime")
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
       * @JMS\Type("boolean")
       */
      protected $updatedAtSet;


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
     * Get the value of Number
     *
     * @return string
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * Set the value of Number
     *
     * @param string number
     *
     * @return self
     */
    public function setNumber($number)
    {
        $this->number = $number;

        return $this;
    }

    /**
     * Get the value of Currency
     *
     * @return string
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * Set the value of Currency
     *
     * @param string currency
     *
     * @return self
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;

        return $this;
    }

    /**
     * Get the value of Opening Balance
     *
     * @return double
     */
    public function getOpeningBalance()
    {
        return $this->openingBalance;
    }

    /**
     * Set the value of Opening Balance
     *
     * @param double openingBalance
     *
     * @return self
     */
    public function setOpeningBalance($openingBalance)
    {
        $this->openingBalance = $openingBalance;

        return $this;
    }

    /**
     * Get the value of Minimum Balance To Notify
     *
     * @return double
     */
    public function getMinimumBalanceToNotify()
    {
        return $this->minimumBalanceToNotify;
    }

    /**
     * Set the value of Minimum Balance To Notify
     *
     * @param double minimumBalanceToNotify
     *
     * @return self
     */
    public function setMinimumBalanceToNotify($minimumBalanceToNotify)
    {
        $this->minimumBalanceToNotify = $minimumBalanceToNotify;

        return $this;
    }

    /**
     * Get the value of Opening Date
     *
     * @return \DateTime $openingDate
     */
    public function getOpeningDate()
    {
        return $this->openingDate;
    }

    /**
     * Set the value of Opening Date
     *
     * @param \DateTime $openingDate openingDate
     *
     * @return self
     */
    public function setOpeningDate(\DateTime $openingDate)
    {
        $this->openingDate = $openingDate;

        return $this;
    }

    /**
     * Get the value of Favorite
     *
     * @return bool
     */
    public function getFavorite()
    {
        return $this->favorite;
    }

    /**
     * Set the value of Favorite
     *
     * @param bool favorite
     *
     * @return self
     */
    public function setFavorite($favorite)
    {
        $this->favorite = $favorite;

        return $this;
    }

    /**
     * Get the value of Accounting Type
     *
     * @return string
     */
    public function getAccountingType()
    {
        return $this->accountingType;
    }

    /**
     * Set the value of Accounting Type
     *
     * @param string accountingType
     *
     * @return self
     */
    public function setAccountingType($accountingType)
    {
        $this->accountingType = $accountingType;

        return $this;
    }

    /**
     * Get the value of Type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set the value of Type
     *
     * @param string type
     *
     * @return self
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get the value of Parent Account
     *
     * @return Account
     */
    public function getParentAccount()
    {
        return $this->parentAccount;
    }

    /**
     * Set the value of Parent Account
     *
     * @param Account parentAccount
     *
     * @return self
     */
    public function setParentAccount(Account $parentAccount)
    {
        $this->parentAccount = $parentAccount;

        return $this;
    }

    /**
     * Get the value of Institution
     *
     * @return Institution
     */
    public function getInstitution()
    {
        return $this->institution;
    }

    /**
     * Set the value of Institution
     *
     * @param Institution institution
     *
     * @return self
     */
    public function setInstitution(Institution $institution)
    {
        $this->institution = $institution;

        return $this;
    }

}
