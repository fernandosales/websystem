<?php

namespace AccountancyBundle\Entity;

use AccountancyBundle\Model\ExtendBeneficiary;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;
use Oro\Bundle\EntityBundle\EntityProperty\DatesAwareInterface;
use Oro\Bundle\EntityBundle\EntityProperty\DatesAwareTrait;
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
 *              "icon"="fa-user"
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

}
