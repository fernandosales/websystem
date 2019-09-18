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
 * This entity represents a account of a system
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

}
