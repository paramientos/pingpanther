<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 *
 *
 * @property string $id
 * @property string $relation_type
 * @property string|null $relation_id
 * @property string $notes
 * @property string $created_by
 * @property \Illuminate\Support\Carbon $created_at
 * @property-read \App\Models\User|null $createdBy
 * @method static \Illuminate\Database\Eloquent\Builder|ActionLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ActionLog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ActionLog query()
 * @method static \Illuminate\Database\Eloquent\Builder|ActionLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActionLog whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActionLog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActionLog whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActionLog whereRelationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActionLog whereRelationType($value)
 * @mixin \Eloquent
 */
	class ActionLog extends \Eloquent {}
}

namespace App\Models{
/**
 *
 *
 * @property string $id
 * @property int $is_my_address
 * @property string|null $name
 * @property string|null $contact_id
 * @property AddressType $type
 * @property string $address
 * @property string $created_by
 * @property string|null $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Contact|null $contact
 * @property-read \App\Models\User|null $createdBy
 * @property-read \App\Models\User|null $updatedBy
 * @method static \Illuminate\Database\Eloquent\Builder|Address newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Address newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Address query()
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereContactId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereIsMyAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereUpdatedBy($value)
 * @mixin \Eloquent
 */
	class Address extends \Eloquent {}
}

namespace App\Models{
/**
 *
 *
 * @property int $id
 * @property int $country_id
 * @property string $name
 * @property string|null $latitude
 * @property string|null $longitude
 * @method static \Illuminate\Database\Eloquent\Builder|City newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|City newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|City query()
 * @method static \Illuminate\Database\Eloquent\Builder|City whereCountryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereLatitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereLongitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereName($value)
 * @mixin \Eloquent
 */
	class City extends \Eloquent {}
}

namespace App\Models{
/**
 *
 *
 * @property string $id
 * @property string $code
 * @property string $name
 * @property string|null $user_id
 * @property int $company_type
 * @property string|null $address
 * @property string|null $second_address
 * @property string|null $district
 * @property int|null $city_id
 * @property int|null $country
 * @property string|null $tax_administration
 * @property string|null $tax_number
 * @property string|null $phone
 * @property string|null $mobile
 * @property string|null $email
 * @property string|null $website
 * @property string|null $language
 * @property array|null $tickets
 * @property int $is_supplier
 * @property string|null $payment_condition_id
 * @property string|null $exchange_id
 * @property string|null $price_list_id
 * @property string|null $shipping_type_id
 * @property string|null $pos_campaign_id
 * @property string|null $financial_condition_id
 * @property string|null $currency_id
 * @property string $created_by
 * @property string|null $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static Builder|Contact newModelQuery()
 * @method static Builder|Contact newQuery()
 * @method static Builder|Contact query()
 * @method static Builder|Contact suppliers()
 * @method static Builder|Contact whereAddress($value)
 * @method static Builder|Contact whereCityId($value)
 * @method static Builder|Contact whereCode($value)
 * @method static Builder|Contact whereCompanyType($value)
 * @method static Builder|Contact whereCountry($value)
 * @method static Builder|Contact whereCreatedAt($value)
 * @method static Builder|Contact whereCreatedBy($value)
 * @method static Builder|Contact whereCurrencyId($value)
 * @method static Builder|Contact whereDistrict($value)
 * @method static Builder|Contact whereEmail($value)
 * @method static Builder|Contact whereExchangeId($value)
 * @method static Builder|Contact whereFinancialConditionId($value)
 * @method static Builder|Contact whereId($value)
 * @method static Builder|Contact whereIsSupplier($value)
 * @method static Builder|Contact whereLanguage($value)
 * @method static Builder|Contact whereMobile($value)
 * @method static Builder|Contact whereName($value)
 * @method static Builder|Contact wherePaymentConditionId($value)
 * @method static Builder|Contact wherePhone($value)
 * @method static Builder|Contact wherePosCampaignId($value)
 * @method static Builder|Contact wherePriceListId($value)
 * @method static Builder|Contact whereSecondAddress($value)
 * @method static Builder|Contact whereShippingTypeId($value)
 * @method static Builder|Contact whereTaxAdministration($value)
 * @method static Builder|Contact whereTaxNumber($value)
 * @method static Builder|Contact whereTickets($value)
 * @method static Builder|Contact whereUpdatedAt($value)
 * @method static Builder|Contact whereUpdatedBy($value)
 * @method static Builder|Contact whereUserId($value)
 * @method static Builder|Contact whereWebsite($value)
 * @property string|null $photo
 * @method static Builder|Contact wherePhoto($value)
 * @property-read \App\Models\City|null $city
 * @property-read \App\Models\User|null $createdBy
 * @property-read \App\Models\User|null $updatedBy
 * @mixin \Eloquent
 */
	class Contact extends \Eloquent {}
}

namespace App\Models{
/**
 *
 *
 * @property int $id
 * @property string $code
 * @property string $name
 * @method static \Illuminate\Database\Eloquent\Builder|Country newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Country newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Country query()
 * @method static \Illuminate\Database\Eloquent\Builder|Country whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Country whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Country whereName($value)
 * @mixin \Eloquent
 */
	class Country extends \Eloquent {}
}

namespace App\Models{
/**
 *
 *
 * @property string $id
 * @property string|null $relation_id
 * @property string|null $proposal_no
 * @property string|null $contact_name
 * @property string $contacted_person
 * @property string $notes
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property \Illuminate\Support\Carbon|null $contacted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Contact|null $contact
 * @property-read \App\Models\User|null $createdBy
 * @property-read \App\Models\User|null $updatedBy
 * @method static \Illuminate\Database\Eloquent\Builder|CrmLead newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CrmLead newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CrmLead query()
 * @method static \Illuminate\Database\Eloquent\Builder|CrmLead whereContactName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CrmLead whereContactedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CrmLead whereContactedPerson($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CrmLead whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CrmLead whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CrmLead whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CrmLead whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CrmLead whereProposalNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CrmLead whereRelationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CrmLead whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CrmLead whereUpdatedBy($value)
 * @mixin \Eloquent
 */
	class CrmLead extends \Eloquent {}
}

namespace App\Models{
/**
 *
 *
 * @property int $id
 * @property string $name
 * @property string $code
 * @property string|null $symbol_left
 * @property string|null $symbol_right
 * @property float|null $value
 * @property string $created_by
 * @property string|null $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User|null $updatedBy
 * @method static \Illuminate\Database\Eloquent\Builder|Currency newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Currency newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Currency query()
 * @method static \Illuminate\Database\Eloquent\Builder|Currency whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Currency whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Currency whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Currency whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Currency whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Currency whereSymbolLeft($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Currency whereSymbolRight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Currency whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Currency whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Currency whereValue($value)
 * @mixin \Eloquent
 */
	class Currency extends \Eloquent {}
}

namespace App\Models{
/**
 *
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder|Language newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Language newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Language query()
 * @method static \Illuminate\Database\Eloquent\Builder|Language whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Language whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Language whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Language whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class Language extends \Eloquent {}
}

namespace App\Models{
/**
 *
 *
 * @property-read \App\Models\User|null $createdBy
 * @method static \Illuminate\Database\Eloquent\Builder|MessageLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MessageLog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MessageLog query()
 * @property string $id
 * @property string $relation_type
 * @property string|null $relation_id
 * @property string $message
 * @property string $created_by
 * @property \Illuminate\Support\Carbon $created_at
 * @method static \Illuminate\Database\Eloquent\Builder|MessageLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MessageLog whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MessageLog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MessageLog whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MessageLog whereRelationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MessageLog whereRelationType($value)
 * @mixin \Eloquent
 */
	class MessageLog extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\PaymentCondition
 *
 * @property string $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentCondition newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentCondition newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentCondition query()
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentCondition whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentCondition whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentCondition whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentCondition whereUpdatedAt($value)
 * @property string $created_by
 * @property string|null $updated_by
 * @property-read \App\Models\User|null $createdBy
 * @property-read \App\Models\User|null $updatedBy
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentCondition whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentCondition whereUpdatedBy($value)
 * @mixin \Eloquent
 */
	class PaymentCondition extends \Eloquent {}
}

namespace App\Models{
/**
 *
 *
 * @property string $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $created_by
 * @property string|null $updated_by
 * @property-read \App\Models\User|null $createdBy
 * @property-read \App\Models\User|null $updatedBy
 * @method static \Illuminate\Database\Eloquent\Builder|PriceList newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PriceList newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PriceList query()
 * @method static \Illuminate\Database\Eloquent\Builder|PriceList whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PriceList whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PriceList whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PriceList whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PriceList whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PriceList whereUpdatedBy($value)
 * @mixin \Eloquent
 */
	class PriceList extends \Eloquent {}
}

namespace App\Models{
/**
 *
 *
 * @property string $id
 * @property string $name
 * @property string $stock_code
 * @property float|null $sales_price
 * @property float|null $cost
 * @property int|null $unit_id
 * @property string|null $photo
 * @property string|null $product_attributes
 * @property int|null $can_purchase
 * @property int|null $can_sale
 * @property int|null $allow_negative_stock
 * @property int $warehouse_id
 * @property string $created_by
 * @property string|null $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User|null $createdBy
 * @property-read \App\Models\User|null $updatedBy
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|Product newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Product newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Product query()
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereAllowNegativeStock($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereCanPurchase($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereCanSale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereCost($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product wherePhoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereProductAttributes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereSalesPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereStockCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereUnitId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereWarehouseId($value)
 * @property-read \App\Models\Warehouse|null $warehouse
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ProductVariant> $variants
 * @property-read int|null $variants_count
 * @property float|null $tax_rate
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereTaxRate($value)
 * @mixin \Eloquent
 */
	class Product extends \Eloquent {}
}

namespace App\Models{
/**
 *
 *
 * @property int $id
 * @property string $name
 * @property array|null $values
 * @property string $created_by
 * @property string|null $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User|null $createdBy
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ProductAttributeItem> $items
 * @property-read int|null $items_count
 * @property-read \App\Models\User|null $updatedBy
 * @method static \Illuminate\Database\Eloquent\Builder|ProductAttribute newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductAttribute newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductAttribute query()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductAttribute whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductAttribute whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductAttribute whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductAttribute whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductAttribute whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductAttribute whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductAttribute whereValues($value)
 * @mixin \Eloquent
 */
	class ProductAttribute extends \Eloquent {}
}

namespace App\Models{
/**
 *
 *
 * @property int $id
 * @property int $product_attribute_id
 * @property string $value
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read string $describe
 * @property-read \App\Models\ProductAttribute|null $productAttribute
 * @method static \Illuminate\Database\Eloquent\Builder|ProductAttributeItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductAttributeItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductAttributeItem query()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductAttributeItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductAttributeItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductAttributeItem whereProductAttributeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductAttributeItem whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductAttributeItem whereValue($value)
 * @mixin \Eloquent
 */
	class ProductAttributeItem extends \Eloquent {}
}

namespace App\Models{
/**
 *
 *
 * @property int $id
 * @property string $product_id
 * @property int $quantity
 * @property StockProcessType $type
 * @property string $relation_type
 * @property string|null $relation_id
 * @property string|null $contact_id
 * @property string|null $created_by
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property-read \App\Models\Contact|null $contact
 * @property-read \App\Models\User|null $createdBy
 * @property-read \App\Models\Product|null $product
 * @method static \Illuminate\Database\Eloquent\Builder|ProductTransaction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductTransaction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductTransaction onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductTransaction query()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductTransaction whereContactId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductTransaction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductTransaction whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductTransaction whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductTransaction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductTransaction whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductTransaction whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductTransaction whereRelationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductTransaction whereRelationType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductTransaction whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductTransaction withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductTransaction withoutTrashed()
 * @property int|null $product_stocks
 * @property int|null $warehouse_id
 * @property-read \App\Models\Warehouse|null $warehouse
 * @method static \Illuminate\Database\Eloquent\Builder|ProductTransaction whereProductStocks($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductTransaction whereWarehouseId($value)
 * @mixin \Eloquent
 */
	class ProductStock extends \Eloquent {}
}

namespace App\Models{
/**
 *
 *
 * @property string $id
 * @property string|null $stock_code
 * @property string|null $product_name
 * @property string $product_id
 * @property string|null $attribute_items
 * @property int|null $stock
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read string $variant
 * @property-read string $variant_with_product_name
 * @property-read \App\Models\Product|null $product
 * @method static \Illuminate\Database\Eloquent\Builder|ProductVariant newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductVariant newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductVariant query()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductVariant whereAttributeItems($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductVariant whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductVariant whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductVariant whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductVariant whereProductName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductVariant whereStock($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductVariant whereStockCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductVariant whereUpdatedAt($value)
 * @property string $created_by
 * @property string|null $updated_by
 * @method static \Illuminate\Database\Eloquent\Builder|ProductVariant whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductVariant whereUpdatedBy($value)
 * @property-read \App\Models\User|null $createdBy
 * @property-read \App\Models\User|null $updatedBy
 * @mixin \Eloquent
 */
	class ProductVariant extends \Eloquent {}
}

namespace App\Models{
/**
 *
 *
 * @property string $id
 * @property string $proposal_no
 * @property int $has_contact
 * @property string|null $contact_id
 * @property string|null $delivery_address_id
 * @property string|null $invoice_address_id
 * @property string|null $contact_name
 * @property string|null $delivery_address
 * @property string|null $invoice_address
 * @property string $currency_id
 * @property \Illuminate\Support\Carbon|null $deadline_at
 * @property string|null $price_list_id
 * @property int|null $is_renewable
 * @property string|null $payment_condition_id
 * @property float|null $sub_total
 * @property float|null $total
 * @property string|null $notes
 * @property \Illuminate\Support\Collection|null $library
 * @property \App\Enums\Proposal\ProposalStatus $status
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ProposalProduct> $products
 * @property-read int|null $products_count
 * @method static \Illuminate\Database\Eloquent\Builder|Proposal newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Proposal newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Proposal query()
 * @method static \Illuminate\Database\Eloquent\Builder|Proposal whereContactId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Proposal whereContactName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Proposal whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Proposal whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Proposal whereCurrencyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Proposal whereDeadlineAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Proposal whereDeliveryAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Proposal whereDeliveryAddressId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Proposal whereHasContact($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Proposal whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Proposal whereInvoiceAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Proposal whereInvoiceAddressId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Proposal whereIsRenewable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Proposal whereLibrary($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Proposal whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Proposal wherePaymentConditionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Proposal wherePriceListId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Proposal whereProposalNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Proposal whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Proposal whereSubTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Proposal whereTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Proposal whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Proposal whereUpdatedBy($value)
 * @property-read \App\Models\User|null $createdBy
 * @property-read \App\Models\User|null $updatedBy
 * @property-read \App\Models\Contact|null $contact
 * @mixin \Eloquent
 * @property-read \App\Models\Address|null $deliveryAddress
 * @property-read \App\Models\Address|null $invoiceAddress
 */
	class Proposal extends \Eloquent {}
}

namespace App\Models{
/**
 *
 *
 * @property string $id
 * @property string $proposal_id
 * @property string $product_id
 * @property string|null $notes
 * @property int $qty
 * @property float $unit_price
 * @property float $tax_rate
 * @property float $tax_price
 * @property float $line_total
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Proposal> $proposal
 * @property-read int|null $proposal_count
 * @method static \Illuminate\Database\Eloquent\Builder|ProposalProduct newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProposalProduct newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProposalProduct query()
 * @method static \Illuminate\Database\Eloquent\Builder|ProposalProduct whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProposalProduct whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProposalProduct whereLineTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProposalProduct whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProposalProduct whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProposalProduct whereProposalId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProposalProduct whereQty($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProposalProduct whereTaxPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProposalProduct whereTaxRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProposalProduct whereUnitPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProposalProduct whereUpdatedAt($value)
 * @property-read \App\Models\Product|null $product
 * @mixin \Eloquent
 */
	class ProposalProduct extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Purchase
 *
 * @property string $id
 * @property string $supplier_id
 * @property string $currency_id
 * @property \Illuminate\Support\Carbon $purchased_at
 * @property \Illuminate\Support\Carbon $deadline_at
 * @property string|null $source_doc
 * @property int $warehouse_id
 * @property string|null $invoice_no
 * @property float|null $sub_total
 * @property float|null $total
 * @property PurchaseStatus $status
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Administrator|null $createdBy
 * @property-read \App\Models\Currency|null $currency
 * @property-read \App\Models\Contact|null $supplier
 * @property-read \App\Models\Administrator|null $updatedBy
 * @property-read \App\Models\Warehouse|null $warehouse
 * @method static \Illuminate\Database\Eloquent\Builder|Purchase newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Purchase newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Purchase query()
 * @method static \Illuminate\Database\Eloquent\Builder|Purchase whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Purchase whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Purchase whereCurrencyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Purchase whereDeadlineAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Purchase whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Purchase whereInvoiceNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Purchase wherePurchasedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Purchase whereSourceDoc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Purchase whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Purchase whereSubTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Purchase whereSupplierId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Purchase whereTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Purchase whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Purchase whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Purchase whereWarehouseId($value)
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PurchaseItem> $items
 * @property-read int|null $items_count
 * @property string|null $notes
 * @method static \Illuminate\Database\Eloquent\Builder|Purchase whereNotes($value)
 * @property string $purchase_no
 * @method static \Illuminate\Database\Eloquent\Builder|Purchase wherePurchaseNo($value)
 * @property string|null $images
 * @method static \Illuminate\Database\Eloquent\Builder|Purchase whereImages($value)
 * @property \Illuminate\Support\Collection|null $library
 * @method static \Illuminate\Database\Eloquent\Builder|Purchase whereLibrary($value)
 * @mixin \Eloquent
 */
	class Purchase extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\PurchaseComment
 *
 * @property string $id
 * @property array $content
 * @property string $user_id
 * @property string $purchase_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Administrator|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseComment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseComment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseComment query()
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseComment whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseComment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseComment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseComment wherePurchaseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseComment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseComment whereUserId($value)
 * @mixin \Eloquent
 */
	class PurchaseComment extends \Eloquent {}
}

namespace App\Models{
/**
 *
 *
 * @property string $id
 * @property string $purchase_id
 * @property string $product_id
 * @property int $qty
 * @property float $unit_price
 * @property float $tax_rate
 * @property float $tax_price
 * @property float $line_total
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Product|null $product
 * @property-read \App\Models\Purchase|null $purchase
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseItem query()
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseItem whereLineTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseItem whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseItem wherePurchaseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseItem whereQty($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseItem whereTaxPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseItem whereTaxRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseItem whereUnitPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseItem whereUpdatedAt($value)
 * @property string|null $notes
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseItem whereNotes($value)
 * @mixin \Eloquent
 */
	class PurchaseItem extends \Eloquent {}
}

namespace App\Models{
/**
 *
 *
 * @property string $id
 * @property string $sales_no
 * @property string $contact_id
 * @property string|null $delivery_address_id
 * @property string|null $invoice_address_id
 * @property string $user_id
 * @property \Illuminate\Support\Carbon|null $deadline_at
 * @property string|null $price_list_id
 * @property int|null $is_renewable
 * @property int $has_receipt
 * @property string|null $payment_condition_id
 * @property float|null $sub_total
 * @property float|null $total
 * @property string|null $notes
 * @property string|null $images
 * @property SaleStatus $status
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Contact|null $contact
 * @property-read \App\Models\User|null $createdBy
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\SaleItem> $items
 * @property-read int|null $items_count
 * @property-read \App\Models\User|null $updatedBy
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|Sale newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Sale newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Sale query()
 * @method static \Illuminate\Database\Eloquent\Builder|Sale whereContactId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sale whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sale whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sale whereDeadlineAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sale whereDeliveryAddressId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sale whereHasReceipt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sale whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sale whereImages($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sale whereInvoiceAddressId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sale whereIsRenewable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sale whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sale wherePaymentConditionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sale wherePriceListId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sale whereSalesNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sale whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sale whereSubTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sale whereTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sale whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sale whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sale whereUserId($value)
 * @property \Illuminate\Support\Collection|null $library
 * @method static \Illuminate\Database\Eloquent\Builder|Sale whereLibrary($value)
 * @property string|null $selected_variants
 * @method static \Illuminate\Database\Eloquent\Builder|Sale whereSelectedVariants($value)
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\SaleVariant> $variants
 * @property-read int|null $variants_count
 * @property string $currency_id
 * @method static \Illuminate\Database\Eloquent\Builder|Sale whereCurrencyId($value)
 * @mixin \Eloquent
 */
	class Sale extends \Eloquent {}
}

namespace App\Models{
/**
 *
 *
 * @property string $id
 * @property string $sale_id
 * @property string $product_id
 * @property string|null $notes
 * @property int $qty
 * @property float $unit_price
 * @property float $tax_rate
 * @property float $tax_price
 * @property float $line_total
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Product|null $product
 * @property-read \App\Models\Sale|null $sale
 * @method static \Illuminate\Database\Eloquent\Builder|SaleItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SaleItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SaleItem query()
 * @method static \Illuminate\Database\Eloquent\Builder|SaleItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SaleItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SaleItem whereLineTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SaleItem whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SaleItem whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SaleItem whereQty($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SaleItem whereSaleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SaleItem whereTaxPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SaleItem whereTaxRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SaleItem whereUnitPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SaleItem whereUpdatedAt($value)
 * @property string|null $receipt
 * @method static \Illuminate\Database\Eloquent\Builder|SaleItem whereReceipt($value)
 * @mixin \Eloquent
 */
	class SaleItem extends \Eloquent {}
}

namespace App\Models{
/**
 *
 *
 * @property string $id
 * @property string $sale_id
 * @property string $product_id
 * @property string $variant_id
 * @property int $qty
 * @property string|null $notes
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Product|null $product
 * @property-read \App\Models\Sale|null $sale
 * @method static \Illuminate\Database\Eloquent\Builder|SaleVariant newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SaleVariant newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SaleVariant query()
 * @method static \Illuminate\Database\Eloquent\Builder|SaleVariant whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SaleVariant whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SaleVariant whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SaleVariant whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SaleVariant whereQty($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SaleVariant whereSaleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SaleVariant whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SaleVariant whereVariantId($value)
 * @property-read \App\Models\Product|null $variant
 * @mixin \Eloquent
 */
	class SaleVariant extends \Eloquent {}
}

namespace App\Models{
/**
 *
 *
 * @property int $id
 * @property string $name
 * @property string $color
 * @property string $background_color
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Tag newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Tag newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Tag query()
 * @method static \Illuminate\Database\Eloquent\Builder|Tag whereBackgroundColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tag whereColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tag whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tag whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tag whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tag whereUpdatedAt($value)
 * @property string|null $created_by
 * @property string|null $updated_by
 * @method static \Illuminate\Database\Eloquent\Builder|Tag whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tag whereUpdatedBy($value)
 * @property-read \App\Models\User|null $updatedBy
 * @mixin \Eloquent
 */
	class Tag extends \Eloquent {}
}

namespace App\Models{
/**
 *
 *
 * @property int $id
 * @property string $name
 * @property int $city_id
 * @property string|null $county
 * @property int|null $code
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|TaxOffice newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TaxOffice newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TaxOffice query()
 * @method static \Illuminate\Database\Eloquent\Builder|TaxOffice whereCityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaxOffice whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaxOffice whereCounty($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaxOffice whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaxOffice whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaxOffice whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaxOffice whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class TaxOffice extends \Eloquent {}
}

namespace App\Models{
/**
 *
 *
 * @property string $id
 * @property string $name
 * @property string $color
 * @property string $bg_color
 * @property string $created_by
 * @property string|null $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Contact> $contacts
 * @property-read int|null $contacts_count
 * @method static \Illuminate\Database\Eloquent\Builder|Ticket newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Ticket newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Ticket query()
 * @method static \Illuminate\Database\Eloquent\Builder|Ticket whereBgColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ticket whereColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ticket whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ticket whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ticket whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ticket whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ticket whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ticket whereUpdatedBy($value)
 * @mixin \Eloquent
 */
	class Ticket extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Unit
 *
 * @property string $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Unit newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Unit newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Unit query()
 * @method static \Illuminate\Database\Eloquent\Builder|Unit whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Unit whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Unit whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Unit whereUpdatedAt($value)
 * @property string $created_by
 * @property string|null $updated_by
 * @method static \Illuminate\Database\Eloquent\Builder|Unit whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Unit whereUpdatedBy($value)
 * @property-read \App\Models\User|null $createdBy
 * @property-read \App\Models\User|null $updatedBy
 * @mixin \Eloquent
 */
	class Unit extends \Eloquent {}
}

namespace App\Models{
/**
 *
 *
 * @property string $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property mixed $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property array|null $permissions
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property-read \App\Models\Country|null $country
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Language> $languages
 * @property-read int|null $languages_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePermissions($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedBy($value)
 * @mixin \Eloquent
 */
	class User extends \Eloquent {}
}

namespace App\Models{
/**
 *
 *
 * @property int $id
 * @property string $name
 * @property string|null $short_name
 * @property string|null $address_id
 * @property string $created_by
 * @property string|null $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Address|null $address
 * @property-read \App\Models\Contact|null $contact
 * @method static \Illuminate\Database\Eloquent\Builder|Warehouse newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Warehouse newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Warehouse query()
 * @method static \Illuminate\Database\Eloquent\Builder|Warehouse whereAddressId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Warehouse whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Warehouse whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Warehouse whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Warehouse whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Warehouse whereShortName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Warehouse whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Warehouse whereUpdatedBy($value)
 * @property-read \App\Models\User|null $createdBy
 * @property-read \App\Models\User|null $updatedBy
 * @mixin \Eloquent
 */
	class Warehouse extends \Eloquent {}
}

