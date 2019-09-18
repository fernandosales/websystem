<?php

namespace AccountancyBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;
use AccountancyBundle\Model\ExtendCategory;
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
 *              "form_type"="AccountancyBundle\Form\Type\BeneficiarySelectType",
 *              "grid_name"="categories-select-grid"
 *          },
 *          "grid"={
 *              "default"="categories-grid",
 *          }
 *      }
 * )
 * @JMS\ExclusionPolicy("ALL")
 */
class Category extends ExtendCategory
{

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

}
