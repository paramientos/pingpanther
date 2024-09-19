<?php

use App\Exceptions\CustomException;
use App\Models\ActionLog;
use App\Models\Contact;
use App\Models\CrmLead;
use App\Models\Member;
use App\Models\Proposal;
use App\Models\Purchase;
use App\Models\PurchaseVariant;
use App\Models\Sale;

function makeMemberInChat(bool $inChat): void
{
    auth('member')->user()->update([
        'in_chat' => $inChat
    ]);

    makeMemberIsBusy(isBusy: $inChat);
}

function makeMemberIsBusy(bool $isBusy): void
{
    auth('member')->user()->update([
        'is_busy' => $isBusy
    ]);
}


function makeMemberIsLookingFor(bool $isLookingFor): void
{
    auth('member')->user()->update([
        'is_looking_for' => $isLookingFor
    ]);
}

function is_json($string): bool
{
    json_decode($string);
    return json_last_error() === JSON_ERROR_NONE;
}

/**
 * @throws CustomException
 */
function get_member_balance(?string $userId = null): float
{
    if (is_null($userId)) {
        if (!auth('web')->check()) {
            throw new CustomException('No access!!');
        }

        return auth('member')->user()->getBalance();
    }

    return Member::findOrFail($userId, ['id', 'balance'])->getBalance();
}


function get_real_ip(): mixed
{
    $server = request()->server;

    if (!empty($server->get('HTTP_CF_CONNECTING_IP'))) {
        $ip = $server->get('HTTP_CF_CONNECTING_IP');
    } else if (!empty($server->get('HTTP_CLIENT_IP'))) {
        $ip = $server->get('HTTP_CLIENT_IP');
    } elseif (!empty($server->get('HTTP_X_FORWARDED_FOR'))) {
        $ip = $server->get('HTTP_X_FORWARDED_FOR');

        if (str_contains($ip, ',')) {
            $ipArray = explode(',', $ip);
            $ip = reset($ipArray);
        }
    } else {
        $ip = $server->get('REMOTE_ADDR');
    }

    return $ip;
}

function coin_text(?float $coin = null): string
{
    if (!$coin) {
        return '-';
    }

    return $coin;
}

function array_remove_null($item)
{
    if (!is_array($item)) {
        return $item;
    }

    return collect($item)
        ->reject(function ($item) {
            return is_null($item);
        })
        ->flatMap(function ($item, $key) {

            return is_numeric($key)
                ? [array_remove_null($item)]
                : [$key => array_remove_null($item)];
        })
        ->toArray();
}


function resolve_product_attributes(array $attributes): array
{
    return collect($attributes)->map(function (array $attributeList) {
        return $attributeList['attribute_list'];
    })
        ->values()
        ->toArray();
}

function resolve_product_attribute_items(array $attributes): array
{
    $values = collect($attributes)->map(function (array $attributeList) {
        return $attributeList['attribute_item_list'];
    })
        ->values();

    return collect($values->toArray())->map(fn(array $val) => $val)->flatten()->toArray();
}


function to_case(array $array, string $caseType = 'snake'): array
{
    $items = [];

    foreach ($array as $key => $value) {
        $items[Str::{$caseType}($key)] = $value;
    }

    return $items;
}

function format_as_tax(float $value): string
{
    return format_number(value: $value, symbol: '%', right: false, decimals: 0);
}

function format_number(?float $value = 0, string $symbol = 'TL', bool $right = true, string $decimalPointer = ',', int $decimals = 2): string
{
    $value = number_format($value, $decimals, $decimalPointer, '.');

    return (!$right ? "{$symbol} " : '') . $value . ($right ? " {$symbol}" : '');
}

function format_money_color(string $symbol, mixed $value, string $decimalPointer = ','): string
{
    $text = format_number(value: $value, symbol: $symbol, decimalPointer: $decimalPointer);

    $color = $value <= 0 ? 'green' : 'red';

    return "<span style='color: {$color};'>{$text}</span>";
}


/**
 * @throws Exception
 * @throws Throwable
 */
function generate_contact_code()
{
    return DB::transaction(function () {
        $increment = 0.00001;
        $baseNumber = 120.00000;

        $lastContact = Contact::lockForUpdate()->latest('code')?->first();

        if ($lastContact) {
            $lastNumber = $lastContact->code;
            $newNumber = $lastNumber + $increment;
        } else {
            $newNumber = $baseNumber + $increment;
        }

        // Ensure the number is unique
        while (Contact::where('code', $newNumber)->exists()) {
            $newNumber += $increment;
        }

        return $newNumber;
    });
}

/**
 * @throws Exception
 */
function generate_purchase_no()
{
    $no = generate_number(length: 6, prefix: 'P');

    $exists = Purchase::where('purchase_no', $no)->exists();

    if ($exists) {
        $no = generate_purchase_no();
    }

    return $no;
}

/**
 * @throws Exception
 */
function generate_sales_no()
{
    $no = generate_number(length: 6, prefix: 'S');

    $exists = Sale::where('sales_no', $no)->exists();

    if ($exists) {
        $no = generate_sales_no();
    }

    return $no;
}

/**
 * @throws Exception
 */
function generate_proposal_no()
{
    $no = generate_number(length: 6, prefix: 'T');

    $exists = CrmLead::where('proposal_no', $no)->exists();

    if (!$exists) {
        $exists = Proposal::where('proposal_no', $no)->exists();
    }

    if ($exists) {
        $no = generate_proposal_no();
    }

    return $no;
}

/**
 * @throws Exception
 */
function generate_string(int $length = 10, bool $upperCase = true): string
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';

    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[random_int(0, $charactersLength - 1)];
    }

    return $upperCase ? strtoupper($randomString) : strtolower($randomString);
}

/**
 * @throws Exception
 */
function generate_number(int $length = 10, bool $upperCase = true, string $prefix = ''): string
{
    $characters = '0123456789';
    $charactersLength = strlen($characters);
    $randomString = '';

    for ($i = 0; $i < $length - 1; $i++) {
        $randomString .= $characters[random_int(0, $charactersLength - 1)];
    }

    return $prefix . (
        $upperCase
            ? strtoupper($randomString)
            : strtolower($randomString)
        );
}


function image_to_base64(string $path, string $assetType = 'image'): string
{
    $type = pathinfo($path, PATHINFO_EXTENSION);
    $content = file_get_contents($path);

    return "data:{$assetType}/" . $type . ';base64,' . base64_encode($content);
}

function check_permission(string $permission, string $guard = 'web'): bool
{
    if (!auth($guard)->check()) {
        return false;
    }

    $permissions = auth($guard)->user()->permissions;

    return auth($guard)->user()->is_admin || (!empty($permissions) && (in_array($permission, $permissions) && !empty($permissions[$permission])));
}

function in_array_recursive($needle, $haystack, $strict = false): bool
{
    foreach ($haystack as $item) {
        if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && in_array_recursive($needle, $item, $strict))) {
            return true;
        }
    }

    return false;
}

function log_action(string $message, string $relationType, ?string $relationId = null): void
{
    ActionLog::create([
        'relation_type' => $relationType,
        'relation_id' => $relationId,
        'notes' => $message,
        'created_by' => auth('web')->id(),
    ]);
}

/**
 * @throws ReflectionException
 */
function get_class_name_from_namespace(string $class): string
{
    return (new ReflectionClass($class))->getShortName();
}

function get_variant_qty(string $variantId): mixed
{
    return PurchaseVariant::whereVariantId($variantId)->sum('qty');
}
