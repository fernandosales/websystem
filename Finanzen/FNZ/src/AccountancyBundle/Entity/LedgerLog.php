<?php

namespace AccountancyBundle\Entity;

use AccountancyBundle\Model\ExtendLedgerLog;
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
 * @ORM\Entity(repositoryClass="AccountancyBundle\Entity\Repository\LedgerLogRepository")
 * @ORM\Table(name="fnz_ledger_log")
 * @Config(
 *      routeName="fnz.ledger_log.ledger_log_index",
 *      routeView="fnz.ledger_log.ledger_log_view",
 *      defaultValues={
 *          "entity"={
 *              "icon"="fa-user"
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
 *              "grid_name"="ledger-logs-select-grid"
 *          },
 *          "grid"={
 *              "default"="ledger-logs-grid",
 *          }
 *      }
 * )
 * @JMS\ExclusionPolicy("ALL")
 */
class LedgerLog extends ExtendLedgerLog implements
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
     * @var \DateTime
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

}
